<?php

namespace App\Http\Controllers;

use Adldap\Auth\BindException;
use App\Lib\DbQuery;
use App\Lib\Helper;
use Exception;
use Illuminate\Http\Request;
use Adldap\AdldapInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\View;
use ZipArchive;


class Apicontroller extends Controller
{
    protected AdldapInterface $ldap;
    protected string $auth;
    #Инициализация
    public function __construct(AdldapInterface $ldap)
    {
        //Параметры авторизации LDAP
        $this->ldap = $ldap;
    }

    #Функция постобработки сообщений
    private function postProcess($messages): \Illuminate\Contracts\View\View
    {
        if (count($messages) == 0) $messages[] = ['infotg', 'API Evolutionsport успешно отработало без изменений'];
        foreach ($messages as $message) {
           if ($message[0] == "error") Log::error('Log message', array('context' => $message[1]));
           if ($message[0] == "warning") Log::warning('Log message', array('context' => $message[1]));
        }
        return View::make('page_api', compact('messages'));
    }
    #Функция изменения ip для компьютеров
    public function ipChange(Request $request): string
    {
        $helper = new Helper();
        $comporiginal = $request->input('comp');
        if (!isset($comporiginal)) {
            Log::error("Ошибка: Нет необходимых параметров для команды");
            return "Ошибка: Нет необходимых параметров для команды";
        }
        $comp = $helper->validateComp($comporiginal);
        if ($comp == "error") {
            Log::error("Ошибка: Имя компьютера ".$comporiginal." не соответствует шаблону Inventory");
            return "Ошибка: Имя компьютера ".$comporiginal." не соответствует шаблону Inventory";
        }
        $replace = false;
        $ip = $helper->getIP($comp);
        if ($ip != null) {
            $dbQuery = new DbQuery();
            $dbComputers = $dbQuery->selectComputerDb($comp);
            if (!$dbComputers[0]) {
                Log::error($dbComputers[1]);
                return $dbComputers[1];
            }
            foreach ($dbComputers[1] as $computer) {
                if ($computer->status && $computer->ipcomp != $ip) {
                    if ($computer->ipcompold == null) {
                        $result = $dbQuery->updateRowComputersDb($computer->login, $computer->comp, ['ipcompold' => $computer->ipcomp, 'ipcomp' => $ip, 'firewall' => false, 'work' => true]);
                    } else {
                        $result = $dbQuery->updateRowComputersDb($computer->login, $computer->comp, ['ipcomp' => $ip, 'firewall' => false, 'work' => true]);
                    }
                    if (!$result[0]) {
                        Log::error($result[1]);
                        return $result[1];
                    }
                    $replace = true;
                }
            }
        }
        $text = "";
        if ($replace) $text = "IP адрес ".$comp." изменён на ".$ip;
        else $text = "IP адрес ".$comp." нет необходимости менять";
        Log::info($text);
        return $text;

    }
    #Основная функция обработки VPN
    public function ldapRefresh(): \Illuminate\Contracts\View\View
    {
        $helper = new Helper();
        $filter = env('LDAP_VPN_FILTER');
        $message = array();
        //Если отсутствует подключение к SSH VPN сервера - возвращаем сразу ошибку
        if (!$helper->getSSH()) {
            $message[] = ['error','Нет доступа к ssh VPN сервера '.env('VPN_SERVER')];
            return $this->postProcess($message);
        }
        //Подключаемся к LDAP серверу и находим записи профилей, соответствующие фильтру LDAP_VPN_FILTER
        try {
            $results = $this->ldap->search()->rawFilter($filter)->get();
        } catch (BindException) {
            $message[] = ['error','Нет доступа к LDAP серверу'];
            return $this->postProcess($message);
        }
        //Записываем полученные данные из LDAP сервера в массив $ldapUsers
        if (isset($results) && count($results) > 0) {
            $ldapUsers = collect($results);
        } else {
            $message[] = ['warning', 'От сервера LDAP не получены данные пользователей VPN'];
            return $this->postProcess($message);
        }
        //Запрашиваем массив данных из таблицы vpnusers
        $dbQuery = new DbQuery();
        $dbUsersFromBase = $dbQuery->selectUserDb();
        if (!$dbUsersFromBase[0]) {
            $message[] = ['error',$dbUsersFromBase[1]];
            return $this->postProcess($message);
        }
        //Запрашиваем массив данных из таблицы vpncomputers
        $dbComputersFromBase = $dbQuery->selectComputersDb();
        if (!$dbComputersFromBase[0]) {
            $message[] = ['error',$dbComputersFromBase[1]];
            return $this->postProcess($message);
        }

        $dbUsers = collect($dbUsersFromBase[1]);
        $dbComputers = collect($dbComputersFromBase[1]);
        $date = date("Y-m-d H:i:s");

        //Проверяем таблицу vpnusers на отсутствие пользователей с ldap. Если в ldap они отсутствуют - выдаем им статус 'false' для дальнейшего удаления,
        //Также в vpncomputers ставим статус для дальнейшего удаления.
        //Если пользователи присутствуют и у них статус "false" - меняем на true
        foreach ($dbUsers as &$dbUser) {
            if ($ldapUsers->doesntContain('samaccountname',[$dbUser->login])) {
                if ($dbUser->status) {
                    $result1 = $dbQuery->updateRowUserDb($dbUser->login, ['create' => $date, 'status' => false, 'work' => false]);
                    $dbUser->create = $date;
                    $dbUser->status = false;
                    $dbUser->work = false;
                    $result2 = $dbQuery->updateRowComputersDb($dbUser->login,null, ['create' => $date, 'status' => false, 'work' => true]);
                    $dbComputers->where('login',$dbUser->login)->each(function ($item) use ($date) {
                        $item->create = $date;
                        $item->status = false;
                        $item->work = true;
                    });
                    if (!$result1[0]) {
                        $message[] = ['error',$result1[1]];
                        return $this->postProcess($message);
                    }
                    if (!$result2[0]) {
                        $message[] = ['error',$result2[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина '.$dbUser->login.' статус FALSE для дальнейшей процедуры удаления'];
                    $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$dbUser->login.' статус FALSE для дальнейшей процедуры удаления'];
                }
            } else {
                if (!$dbUser->status) {
                    $user = $ldapUsers->where('samaccountname',[$dbUser->login])->all();
                    $ldapComps = $helper->array_first($user)->url;
                    foreach ($ldapComps as &$comp) {
                        $comp = $helper->validateComp($comp);
                        if ($comp == 'error') {
                            $message[] = ['warning', 'Название Компьютера '.$comp.' у пользователя '.$dbUser->login.' не соответствует утвержденному шаблону Inventory'];
                        }
                    }
                    $result = $dbQuery->updateRowUserDb($dbUser->login, ['status' => true, 'work' => true]);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина '.$dbUser->login.' статус TRUE для дальнейшей процедуры активации VPN'];
                    $dbUser->status = true;
                    $dbUser->work = true;

                    $dbComps = $dbComputers->where('login',$dbUser->login)->where('status',false)->all();
                    unset($comp);
                    foreach ($dbComps as $comp){
                        $comp->comp = $helper->validateComp($comp->comp);
                        if ($comp->comp == 'error') {
                            $message[] = ['error', 'В базе vpncomputers ошибка в названиии компьютера: '.$comp->comp.' для пользователя '.$comp->login];
                            return $this->postProcess($message);
                        }
                        if (in_array($comp->comp, $ldapComps)) {
                           $result = $dbQuery->updateRowComputersDb($dbUser->login, $comp->comp, ['status' => true, 'work' => true]);
                           if (!$result[0]) {
                               $message[] = ['error', $result[1]];
                               return $this->postProcess($message);
                           }
                            $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$dbUser->login.' и компьютера '.$comp->comp.' статус TRUE для дальнейшей процедуры активации VPN'];
                            $dbComputers->where('login',$dbUser->login)->where('comp',$comp->comp)->each(function ($item) {
                                $item->status = true;
                                $item->work = true;
                            });
                        }
                    }
                }
            }
        }
        //Добавляем новых пользователей и компьютеры, также делаем пометку на удаление компов, которых уже нет в LDAP.
        foreach ($ldapUsers as $ldapUser){
            if ($dbUsers->doesntContain('login',$ldapUser->samaccountname[0])) {
                $result = $dbQuery->insertNewRowUserDb($date,$ldapUser->samaccountname[0],$ldapUser->displayname[0],$ldapUser->mail[0]);
                if (!$result[0]) {
                    $message[] = ['error', $result[1]];
                    return $this->postProcess($message);
                }
                $message[] = ['info', 'Добавляем в таблицу vpnusers новую запись для логина '.$ldapUser->samaccountname[0].' со статусом TRUE для дальнейшей процедуры активации VPN'];
                $dbUsers->push((object)['id' => 0, 'create' => $date, 'status' => true, 'login' => $ldapUser->samaccountname[0], 'name' => $ldapUser->displayname[0], 'ipvpn' => null, 'vpnprofile' => null, 'mail' => $ldapUser->mail[0], 'wgprofile' => false, 'emailsend' => false, 'work' => true]);
            }
            //Проводим обработку всех компьюетров из параметра AD
            if (isset($ldapUser->url) && count($ldapUser->url) > 0) {
                $ldapComps = $ldapUser->url;
                $newcomp = false;
                foreach ($ldapComps as &$comp){
                    $realcompname = $comp;
                    $comp = $helper->validateComp($comp);
                    if ($comp != "error") {
                        if ($dbComputers->where('login',$ldapUser->samaccountname[0])->doesntContain('comp',$comp)) {
                            $result = $dbQuery->insertNewRowCompDb($date,$ldapUser->samaccountname[0],$comp);
                            if (!$result[0]) {
                                $message[] = ['error', $result[1]];
                                return $this->postProcess($message);
                            }
                            $message[] = ['info', 'Добавляем в таблицу vpncomputers новую запись для логина '.$ldapUser->samaccountname[0].' и компьютера '.$comp.' со статусом TRUE для дальнейшей процедуры активации VPN'];
                            $dbComputers->push((object)['id' => 0, 'create' => $date, 'status' => true, 'login' => $ldapUser->samaccountname[0], 'comp' => $comp, 'ipcompold' => null, 'ipcomp' => null, 'firewall' => false, 'remotegroup' => false, 'work' => true]);
                            $newcomp = true;
                        }

                        if ($dbComputers->where('login',$ldapUser->samaccountname[0])->where('status', false)->contains('comp',$comp)) {
                            $result = $dbQuery->updateRowComputersDb($ldapUser->samaccountname[0], $comp, ['status' => true, 'work' => true]);
                            if (!$result[0]) {
                                $message[] = ['error', $result[1]];
                                return $this->postProcess($message);
                            }
                            $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$ldapUser->samaccountname[0].' и компьютера '.$comp.' статус TRUE для дальнейшей процедуры активации VPN'];
                            $dbComputers->where('login',$ldapUser->samaccountname[0])->where('comp',$comp)->each(function ($item) {
                                $item->status = true;
                                $item->work = true;
                            });
                        }
                    }
                    else $message[] = ['info', 'Неправильное имя компьютера '.$realcompname.' у '.$ldapUser->samaccountname[0]];
                }
                //Если добавлен новый комп устанавливаем статус для дальнейшей отправки нового конфига пользователю по Email
                if ($newcomp) {
                    $result = $dbQuery->updateRowUserDb($ldapUser->samaccountname[0], ['emailsend' => false, 'work' => true]);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина '.$ldapUser->samaccountname[0].' в параметре emailsend статус FALSE, чтобы отправить на почту пользовтаеля новый конфиг'];
                    $dbUsers->where('login',$ldapUser->samaccountname[0])->each(function ($item) {
                        $item->emailsend = false;
                        $item->work = true;
                    });
                }
                //Если  компьютер в AD у пользователя удален - ставим статус FALSE для будущего удаления
                $compsdel = $dbComputers->where('login',$ldapUser->samaccountname[0])->where('status',true)->whereNotIn('comp',$ldapComps)->all();
                unset($comp);
                foreach ($compsdel as $comp) {
                    $result = $dbQuery->updateRowComputersDb($ldapUser->samaccountname[0], $comp->comp, ['create' => $date, 'status' => false, 'work' => true]);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$ldapUser->samaccountname[0].' и компьютера '.$comp->comp.' статус FALSE для дальнейшей процедуры удаления'];
                    $dbComputers->where('login',$ldapUser->samaccountname[0])->where('comp',$comp->comp)->each(function ($item) use ($date) {
                        $item->create = $date;
                        $item->status = false;
                        $item->work = true;
                    });
                }
            }
            // Если компьютеры полностью удалены в параметре AD у пользователя - ставим пометку удаления на всех компьютерах пользователя в таблице vpncomputers
            else if (count($dbComputers->where('login',$ldapUser->samaccountname[0])->where('status',true)->all()) > 0) {
                $result = $dbQuery->updateRowComputersDb($ldapUser->samaccountname[0],null, ['create' => $date, 'status' => false, 'work' => true]);
                if (!$result[0]) {
                    $message[] = ['error', $result[1]];
                    return $this->postProcess($message);
                }
                $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$ldapUser->samaccountname[0].' и всех компьютеров статус FALSE для дальнейшей процедуры удаления'];
                $dbComputers->where('login',$ldapUser->samaccountname[0])->each(function ($item) use ($date) {
                    $item->create = $date;
                    $item->status = false;
                    $item->work = true;
                });
            }
        }
        //Работа с профилями VPN
         foreach ($dbUsers as &$user) {
            if ($user->work) {
                if ($user->status) {
                    if (!$user->wgprofile) {
                        $result = $helper->getVpnUser($user->login);
                        if ($result[0]) {
                            $result1 = $helper->getVpnProfile($user->login);
                            if ($result1[0]) {
                                if ($result1[1] && $result1[2] != []) {
                                    if (isset($result1[2][0]['PublicKey']) && $result1[2][0]['PublicKey'] != "") {
                                        $result2 = $helper->getVpnProfile2(urlencode($result1[2][0]['PublicKey']));
                                        if (!$result2[0]) {
                                            $message[] = ['error', $result2[1]];
                                            return $this->postProcess($message);
                                        }
                                        if ($result2[1]) {
                                            $vpnProfile = [$user->login, $helper->findIp($result2[2]), $result2[2]];
                                        }
                                    }
                                } else {
                                    $result2 = $helper->createVpnProfile($user->login);
                                    if ($result2[0]) {
                                        if ($result2[1]) $vpnProfile = [$user->login, $helper->findIp($result2[2]), $result2[2]];
                                        else $message[] = ['warning', 'Профиль VPN для пользователя '.$user->login.' существует, хотя команда getVpnProfile не вернула ответ'];
                                    } else {
                                        $message[] = ['error', $result2[1]];
                                        return $this->postProcess($message);
                                    }
                                }
                                if (isset($vpnProfile)) {
                                    if (isset($vpnProfile[1])) {
                                        $result = $dbQuery->updateRowUserDb($vpnProfile[0], ['ipvpn' => $vpnProfile[1], 'vpnprofile' => $vpnProfile[2], 'wgprofile' => true]);
                                        if (!$result[0]) {
                                            $message[] = ['error', $result[1]];
                                            return $this->postProcess($message);
                                        }
                                        $message[] = ['infotg', 'Для логина '.$user->login.' на сервере VPN был активирован профиль'];
                                        $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина '.$user->login.' в параметре ipvpn - IP VPN, в параметре vpnprofile - конфиг wireguard и ставим TRUE в параметре wgprofile'];
                                        $user->ipvpn = $vpnProfile[1];
                                        $user->vpnprofile = $vpnProfile[2];
                                        $user->wgprofile = true;
                                    }
                                }
                            }
                            else {
                                $message[] = ['error', $result1[1]];
                                return $this->postProcess($message);
                            }
                        }
                        else {
                            $message[] = ['error', $result[1]];
                            return $this->postProcess($message);
                        }
                    }
                }
            }
        }
        //Работа с компами
        foreach ($dbComputers as &$comp) {
            if ($comp->work) {
                if ($comp->status) {
                    if ($comp->ipcomp == null) {
                        $ip = $helper->getIP($comp->comp);
                        if ($ip != null) {
                            $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['ipcomp' => $ip]);
                            if (!$result[0]) {
                                $message[] = ['error', $result[1]];
                                return $this->postProcess($message);
                            }
                            $message[] = ['info', 'Устанавлен IP '.$ip.' в таблице vpncomputers для компьютера '.$comp->comp.' с логином '.$comp->login];
                            $comp->ipcomp = $ip;
                        }
                    }
                    //работаем с фаерволом на VPN сервере с активным статусом
                    if (!$comp->firewall) {
                        $oldipfw = false;
                        $newipfw = false;
                        $ipvpn = $dbUsers->where('login',$comp->login)->all();
                        if (isset($ipvpn) && count($ipvpn) > 0 && $helper->array_first($ipvpn)->ipvpn != null) {
                            //Если в таблице vpncomputers есть IP в параметре ipcompold - удаляем правило VPN для этого IP
                            if ($comp->ipcompold != null && filter_var($comp->ipcompold, FILTER_VALIDATE_IP)) {
                                if ($helper->delFirewall($helper->array_first($ipvpn)->ipvpn, $comp->ipcompold)) {
                                    $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['ipcompold' => null]);
                                    if (!$result[0]) {
                                        $message[] = ['error', $result[1]];
                                        return $this->postProcess($message);
                                    }
                                    $message[] = ['infotg', 'На VPN сервере удалено правило firewall для IP VPN '.$helper->array_first($ipvpn)->ipvpn.' и IP компьютера '.$comp->ipcompold];
                                    $oldipfw = true;
                                } else $message[] = ['error', 'Не удалена запись Firewall на VPN сервере для IP VPN: '.$helper->array_first($ipvpn)->ipvpn.' и IP компьютера '.$comp->ipcompold];
                            }
                            else $oldipfw = true;

                            if ($comp->ipcomp != null && filter_var($comp->ipcomp, FILTER_VALIDATE_IP)) {
                                if ($helper->addFirewall($helper->array_first($ipvpn)->ipvpn, $comp->ipcomp)) {
                                    $newipfw = true;
                                    $message[] = ['infotg', 'В VPN сервере добавлено правило firewall для IP VPN '.$helper->array_first($ipvpn)->ipvpn.' и IP компьютера '.$comp->ipcompold];
                                } else $message[] = ['error', 'Не добавлена запись Firewall на VPN сервере для IP VPN: '.$helper->array_first($ipvpn)->ipvpn.' и IP компьютера '.$comp->ipcompold];
                            }

                            if ($oldipfw && $newipfw) {
                                $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['firewall' => true]);
                                if (!$result[0]) {
                                    $message[] = ['error', $result[1]];
                                    return $this->postProcess($message);
                                }
                                $comp->firewall = true;
                                $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$comp->login.' и компьютера '.$comp->comp.' статус TRUE для параметра firewall'];
                            }
                        }
                        else $message[] = ['warning', 'В таблице vpnusers отсутствуют запись ipvpn для пользователя '.$comp->login];
                    }
                    //Работаем с группой пользователей удаленного рабочего стола с активным статусом
                    if (!$comp->remotegroup) {
                        if ( @fsockopen( $comp->comp, env('POWERSHELL_PORT'), $error_code, $error, 1)) {
                            $results = shell_exec('pwsh -Command \'$User = "' . env('POWERSHELL_USER') . '";$PWord = ConvertTo-SecureString -String "' . env('POWERSHELL_PASSWORD') . '" -AsPlainText -Force;$Credential = New-Object -TypeName System.Management.Automation.PSCredential -ArgumentList $User, $PWord;Invoke-Command -ComputerName ' . $comp->comp . ' -ScriptBlock { Add-LocalGroupMember -Group "Пользователи удаленного рабочего стола" -Member "'.env('DOMAIN').'\\' . $comp->login . '"} -credential $Credential;\' 2>&1');
                            if ($results == null || str_contains($results, 'is already a member of group')) {
                                $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['remotegroup' => true]);
                                if (!$result[0]) {
                                    $message[] = ['error', $result[1]];
                                    return $this->postProcess($message);
                                }
                                $comp->remotegroup = true;
                                $message[] = ['infotg', 'На рабочем месте '.$comp->comp.' в локальную группу "Пользователи удалённого рабочего стола" добавлен пользователь '.$comp->login];
                                $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$comp->login.' и компьютера '.$comp->comp.' статус TRUE для параметра remotegroup'];
                            } else if (str_contains($results, 'acquiring creds with username only failed')) {
                                $message[] = ['error', 'Ошибка авторизации powershell к '.$comp->comp];
                            } else if (str_contains($results, 'MI_RESULT_FAILED')) {
                                $message[] = ['warning', 'Ошибка доступности powershell к '.$comp->comp];
                            }
                        } else $message[] = ['warning', 'Ошибка доступности powershell к '.$comp->comp];
                    }

                    if ($comp->firewall && $comp->remotegroup) {
                        $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['work' => false]);
                        if (!$result[0]) {
                            $message[] = ['error', $result[1]];
                            return $this->postProcess($message);
                        }
                        $comp->work = false;
                        $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина '.$comp->login.' и компьютера '.$comp->comp.' статус FALSE для параметра WORK'];
                    }
                } else {
                    //работаем с фаерволом на VPN сервере с неактивным статусом
                    if ($comp->firewall) {
                        $ipvpn = $dbUsers->where('login',$comp->login)->all();
                        if (isset($ipvpn) && count($ipvpn) > 0 && $helper->array_first($ipvpn)->ipvpn != null ) {
                            if (filter_var($comp->ipcomp, FILTER_VALIDATE_IP)) {
                                if ($helper->delFirewall($helper->array_first($ipvpn)->ipvpn, $comp->ipcomp)) {
                                    $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['firewall' => false]);
                                    if (!$result[0]) {
                                        $message[] = ['error', $result[1]];
                                        return $this->postProcess($message);
                                    }
                                    $comp->firewall = false;
                                    $message[] = ['infotg', 'На VPN сервере удалено правило firewall для IP VPN '.$helper->array_first($ipvpn)->ipvpn.' и IP компьютера '.$comp->ipcomp];
                                }
                            }
                        }
                        else $message[] = "Ошибка запроса ipvpn";
                    }
                    //Работаем с группой пользователей удаленного рабочего стола с неактивным статусом
                    if ($comp->remotegroup) {
                        $tm = idate('i', strtotime($comp->create));
                        if ($comp->create > date("Y-m-d H:i:s", strtotime("+1 days")) || (idate("i") >= $tm && idate("i") < $tm+1)) {
                            if (@fsockopen($comp->comp, env('POWERSHELL_PORT'), $error_code, $error, 1)) {
                                $results = shell_exec('pwsh -Command \'$User = "' . env('POWERSHELL_USER') . '";$PWord = ConvertTo-SecureString -String "' . env('POWERSHELL_PASSWORD') . '" -AsPlainText -Force;$Credential = New-Object -TypeName System.Management.Automation.PSCredential -ArgumentList $User, $PWord;Invoke-Command -ComputerName ' . $comp->comp . ' -ScriptBlock { Remove-LocalGroupMember -Group "Пользователи удаленного рабочего стола" -Member "FA\\' . $comp->login . '"} -credential $Credential;\' 2>&1');
                                if ($results == null || str_contains($results, 'was not found in group')) {
                                    $result = $dbQuery->updateRowComputersDb($comp->login, $comp->comp, ['remotegroup' => false]);
                                    if (!$result[0]) {
                                        $message[] = ['error', $result[1]];
                                        return $this->postProcess($message);
                                    }
                                    $comp->remotegroup = false;
                                    $message[] = ['infotg', 'На рабочем месте ' . $comp->comp . ' из локальной группы "Пользователи удалённого рабочего стола" удалён пользователь ' . $comp->login];
                                    $message[] = ['info', 'Устанавливаем в таблице vpncomputers для логина ' . $comp->login . ' и компьютера ' . $comp->comp . ' статус FALSE для параметра remotegroup'];
                                } else if (str_contains($results, 'acquiring creds with username only failed')) {
                                    $message[] = ['error', 'Ошибка авторизации powershell к ' . $comp->comp];
                                } else if (str_contains($results, 'MI_RESULT_FAILED')) {
                                    $message[] = ['warning', 'Ошибка доступности powershell к ' . $comp->comp];
                                }
                            } else $message[] = ['warning', 'Ошибка доступности powershell к ' . $comp->comp];
                        }
                        // Если в течение последних 7 дней учетная запись пользователя не была удалена из группы "Пользователи удалённого рабочего стола", читаем что рабочее место больше не активно и считаем, что пользователь отсутствует в группе.
                        //if ($comp->create < date("Y-m-d H:i:s", strtotime("-7 days"))) $comp->remotegroup = false;
                    }

                    if (!$comp->firewall && !$comp->remotegroup) {
                        $result = $dbQuery->deleteRowCompDb($comp->login, $comp->comp);
                        if (!$result[0]) {
                            $message[] = ['error', $result[1]];
                            return $this->postProcess($message);
                        }
                        $comp->work = false;
                        $message[] = ['info', 'Удаляем из таблицы vpncomputers строку с логином '.$comp->login.' и компьютером '.$comp->comp];
                    }
                }
            }
        }
        //Финальная проверка и отправка почты пользователю
        unset($user);
        foreach ($dbUsers as $user) {
            if ($user->status && $user->work && $user->wgprofile) {
                if (!$user->emailsend) {
                    if (filter_var($user->mail, FILTER_VALIDATE_EMAIL)) {
                        $comps = $dbComputers->where('login', $user->login)->where('status', true)->all();
                        if (isset($comps) && count($comps) > 0) {
                            $compsToMail = collect($comps)->where('work', false)->all();
                            if (isset($compsToMail) && count($compsToMail) > 0) {
                                $compName = array();
                                foreach ($compsToMail as $comp) {
                                    $compName[] = $comp->comp;
                                }
                                if (count($compName) > 0) {
                                    $textcomp = "Доступные компьютеры для подключения:\r\n";
                                    //Создаём архив
                                    $zip = new ZipArchive();
                                    $zip->open(env('PROFILE_FILS') . "vpn_" . preg_replace('/[\s.,%]/', '', $user->login) . ".zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
                                    $templ = file_get_contents(env('TEMPLATES_FILS') . "evolution.rdp");
                                    foreach ($compName as $comp1) {
                                        $textcomp .= $comp1 . "\r\n";
                                        $rdp = str_replace(['$comp$', '$login$', '$domain$'], [$comp1, $user->login, env('DOMAIN_URL')], $templ);
                                        $zip->addFromString(str_replace('.' . env('DOMAIN_URL'), '', $comp1) . '_' . preg_replace('/[\s.,%]/', '', $user->login) . '.rdp', $rdp);
                                    }
                                    $textcomp .= "\r\nВаш логин: " . $user->login . "@" . strtolower(env('DOMAIN_URL'));

                                    $qr = QrCode::size(250)
                                        ->format('png')
                                        ->backgroundColor(255, 255, 255)
                                        ->generate($user->vpnprofile);

                                    $zip->addFile(env('TEMPLATES_FILS') . "wireguard-installer.exe", "wireguard-windows.exe");
                                    $zip->addFile(env('TEMPLATES_FILS') . "Инструкция.pdf", "Инструкция.pdf");
                                    $zip->addFromString('evol_' . preg_replace('/[\s.,%]/', '', $user->login) . '.conf', $user->vpnprofile);
                                    $zip->addFromString('Компьютеры.txt', $textcomp);
                                    $zip->addFromString('QR_config_' . preg_replace('/[\s.,%]/', '', $user->login) . '.png', $qr);
                                    $zip->close();

                                    try {
                                        $text = "Привет! Во вложении для Вас актуальный конфиг и инструкция для подключения корпоративной VPN.";
                                        $mail = $user->mail;
                                        $attach = env('PROFILE_FILS') . "vpn_" . preg_replace('/[\s.,%]/', '', $user->login) . ".zip";
                                        Mail::raw($text, function ($message) use ($mail, $attach) {
                                            $message->from('bot@evolutionsport.ru', 'VPN Evolutionsport');
                                            $message->to($mail);
                                            $message->cc(env('MAIL_CC'));
                                            $message->subject('Конфиг VPN');
                                            $message->attach($attach);
                                            $message->attach(env('TEMPLATES_FILS') . "Инструкция.pdf");
                                        });

                                        $result = $dbQuery->updateRowUserDb($user->login, ['emailsend' => true]);
                                        if (!$result[0]) {
                                            $message[] = ['error', $result[1]];
                                            return $this->postProcess($message);
                                        }
                                        $user->emailsend = true;
                                        $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина ' . $user->login . ' в параметре emailsend значение TRUE'];
                                        $message[] = ['infotg', 'Пользователю ' . $user->login . ' было отправлено письмо с конфигом на адрес ' . $mail];
                                    } catch (Exception) {
                                        $message[] = ['warning', 'Ошибка отправки письма пользователю ' . $user->login . ' на почту ' . $user->mail];
                                    }
                                }
                            }
                        }
                    } else $message[] = ['warning', 'Email ' . $user->mail . ' пользователя ' . $user->login . ' не прошёл валидацию'];
                }
                //Если все операции завершены - ставим метку true в параметре work в таблице vpnusers
                if ($user->emailsend) {
                    $result = $dbQuery->updateRowUserDb($user->login, ['work' => false]);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина ' . $user->login . ' в параметре work значение FALSE'];
                    $message[] = ['infotg', 'Для пользователя ' . $user->login . ' успешно выполнено развёртывание корпоративного VPN'];
                }
            }
            //Если у пользователя был отключен VPN - направляем ему по почте уведомление
            if (!$user->status) {
                if ($user->emailsend) {
                    try {
                        $text = "Привет! У Вас отключена корпоративная VPN. Просьба полностью удалить все файлы конфигурации VPN, которые вы получили ранее.";
                        $mail = $user->mail;
                        Mail::raw($text, function ($message) use ($mail) {
                            $message->from('bot@evolutionsport.ru', 'VPN Evolutionsport');
                            $message->to($mail);
                            $message->cc(env('MAIL_CC'));
                            $message->subject('Отключение VPN');
                        });
                    } catch (Exception) {
                        $message[] = ['warning', 'Ошибка отправки письма пользователю '.$user->login.' на почту '.$user->mail];
                    }

                    $result = $dbQuery->updateRowUserDb($user->login, ['emailsend' => false]);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                    $message[] = ['info', 'Устанавливаем в таблице vpnusers для логина '.$user->login.' в параметре emailsend значение FALSE'];
                }

                if (count($dbComputers->where('login', $user->login)->where('firewall', true)->all()) == 0) {
                    $result = $dbQuery->deleteRowUserDb($user->login);
                    if (!$result[0]) {
                        $message[] = ['error', $result[1]];
                        return $this->postProcess($message);
                    }
                }

                $message[] = ['infotg', 'Пользователю '.$user->login.' было отправлено письмо с просьбой удалить конфиг в связи с отсутствием услуги корпоративной VPN'];
                $message[] = ['infotg', 'Для пользователя '.$user->login.' полностью выполнено удаление услуги VPN'];
            }
        }
        return $this->postProcess($message);
    }
}