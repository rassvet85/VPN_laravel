<?php

namespace App\Lib;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class Helper
{
    protected string $auth;
    protected $sshconnection;
    #Инициализация
    public function __construct()
    {
        //Параметры авторизации WIREGUARD портала
        $this->auth = "Basic ".base64_encode(env('VPN_USERNAME').":".env('VPN_PASSWORD'));
        //Сразу соединяемся с VPN сервером
        try {
            $this->sshconnection = ssh2_connect(env('VPN_SERVER'));
            ssh2_auth_password($this->sshconnection, env('VPN_SSH_LOGIN'), env('VPN_SSH_PASSWORD'));
        } catch (Exception) {
            $this->sshconnection = null;
        }
    }
    //Функция проверки авторизации к SSH VPN сервера
    public function getSSH(): bool
    {
        if ($this->sshconnection == null) return false;
        return true;
    }
    #Функция проверки названия компа. Он должен соответствовать утвержденному шаблону на предприятии (Inventory)
    public function validateComp($comp): string
    {
        if (preg_match("/CS.......\d\d\d\d\.".str_replace('.','\.',env('DOMAIN_URL'))."$/i", $comp)) return strtoupper($comp);
        if (preg_match("/CS.......\d\d\d\d$/i", $comp)) return strtoupper($comp.'.'.env('DOMAIN_URL'));
        return "error";
    }
    #Функция поиска IP
    public function findIp($data): string | null
    {
        preg_match("/(?<=Address\s=\s)\d+\.\d+\.\d+\.\d+/",$data,$matches);
        if (isset($matches[0])) return $matches[0];
        return null;
    }
    #Функция добавления разрешающей записи в фаерволе VPN сервера
    public function addFirewall(string $vpnip, string $compip): bool|string|null
    {
        if ($this->viewFirewall($vpnip,$compip) != "") return true;

        ssh2_exec($this->sshconnection, 'sudo  iptables -A FORWARD -s '.$vpnip.' -d '.$compip.' -j ACCEPT_TCP_UDP_3389; sudo iptables-save > /etc/iptables/rules.v4');
        if ($this->viewFirewall($vpnip,$compip) != "") return true;
        return false;
    }
    #Функция удаления разрешающей записи в фаерволе VPN сервера
    public function delFirewall(string $vpnip, string $compip): bool
    {
        for($i = 0; $i < 5; $i++) {
            $line = $this->viewFirewall($vpnip, $compip);
            if ($line != "") {
                preg_match("/^\d+/", $line, $matches);
                if (isset($matches[0])) {
                    ssh2_exec($this->sshconnection, 'sudo  iptables -D FORWARD ' . $matches[0].'; sudo iptables-save > /etc/iptables/rules.v4');
                }
            } else return true;
        }
        return false;
    }
    #Функция получения записи(ей) фаервола VPN сервера
    private function viewFirewall(string $vpnip, string $compip): bool|string
    {
        $stream = ssh2_exec($this->sshconnection, 'sudo iptables -nL --line-numbers | grep ACCEPT  | grep '.$vpnip.'\  | grep '.$compip.'\ ');
        stream_set_blocking($stream, true);
        return stream_get_contents(ssh2_fetch_stream($stream, SSH2_STREAM_STDIO));
    }
    #Функция получения IP адреса по доменному имени компа
    public function getIP($comp): string | null
    {
        $ip = gethostbyname($comp);
        if ($ip == $comp) return null; else return $ip;
    }
    #Функция получения параметров данных пользователя Wireguard от сервера VPN
    public function getVpnUser($login): array
    {
        $response = Http::withHeaders(['authorization' => $this->auth])->timeout(2)->get(env('VPN_GETUSER').'/api/v1/backend/user?Email='.$login);
        // Если ответ не пришел - возвращаем причину ошибки.
        if (!$response->successful()) {
            if ($response->status() == 401) return [false, 'Проблема с авторизацией запроса к серверу API FITNESS'];
            else if ($response->status() == 404) return [true, false];
            else return [false, 'Нет ответа от сервера API FITNESS'];
        }
        return [true, true];
    }
    #Функция получения параметров профиля Wireguard пользователя VPN от сервера VPN
    public function getVpnProfile($login): array
    {
        $response = Http::withHeaders(['authorization' => $this->auth])->timeout(2)->get(env('VPN_GETUSER').'/api/v1/provisioning/peers?Email='.$login);
        // Если ответ не пришел - возвращаем причину ошибки.
        if (!$response->successful()) {
            if ($response->status() == 401) return [false, 'Проблема с авторизацией запроса к серверу API FITNESS'];
            else if ($response->status() == 404) return [true, false];
            else return [false, 'Нет ответа от сервера API FITNESS'];
        }
        return [true, true, $response->json()];
    }
    #Функция получения непосредственно профиля Wireguard пользователя VPN от сервера VPN
    public function getVpnProfile2($publicKey): array
    {
        $response = Http::withHeaders(['authorization' => $this->auth])->timeout(2)->get(env('VPN_GETUSER').'/api/v1/provisioning/peer?PublicKey='.$publicKey);
        // Если ответ не пришел - возвращаем причину ошибки.
        if (!$response->successful()) {
            if ($response->status() == 401) return [false, 'Проблема с авторизацией запроса к серверу API FITNESS'];
            else if ($response->status() == 404) return [true, false];
            else return [false, 'Нет ответа от сервера API FITNESS'];
        }
        return [true, true, $response->body()];
    }
    #Функция создания профиля Wireguard на сервере VPN
    public function createVpnProfile($login): array
    {
        $dataPost = [
            'AllowedIPsStr' => '10.82.132.0/24, 10.82.2.0/24, 192.168.16.0/20, 10.82.144.0/23',
            'DeviceName' => 'wg0',
            'DNSStr' => '10.82.2.2, 10.82.2.1',
            'Email' => $login,
            'Identifier' => $login,
            'Mtu' => 0,
            'PersistentKeepalive' => 0,
        ];

        $response = Http::withHeaders(['authorization' => $this->auth])->post(env('VPN_GETUSER').'/api/v1/provisioning/peers?Email='.$login, $dataPost);
        // Если ответ не пришел - возвращаем причину ошибки.
        if (!$response->successful()) {
            if ($response->status() == 401) return [false, 'Проблема с авторизацией запроса к серверу API FITNESS'];
            else if ($response->status() == 404) return [true, false];
            else return [false, 'Нет ответа от сервера API FITNESS'];
        }
        return [true, true, $response->body()];
    }
    #Функция возврата первого элемента из массива
    public function array_first($array, $default = null)
    {
        foreach ($array as $item) {
            return $item;
        }
        return $default;
    }
}