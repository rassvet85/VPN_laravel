<?php

namespace App\Lib;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DbQuery
{
    public function selectUserDb(): array
    {
        try {
            $users = DB::table('vpnusers')->get();
            return [true,$users];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function selectComputersDb(): array
    {
        try {
            $computers = DB::table('vpncomputers')->get();
            return [true,$computers];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function selectComputerDb($comp): array
    {
        try {
            $computers = DB::table('vpncomputers')->where('comp', '=', $comp)->get();
            return [true,$computers];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function deleteRowUserDb(string $name): array
    {
        try {
            DB::table('vpnusers')->where('login', '=', $name)->delete();
            return [true,"строка удалена"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function deleteRowCompDb(string $login, string $comp): array
    {
        try {
            DB::table('vpncomputers')->where('login', '=', $login)->where('comp', '=', $comp)->delete();
            return [true,"строка удалена"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function updateRowUserDb(string $name, array $param): array
    {
        try {
            DB::table('vpnusers')->where('login', '=', $name)->update($param);
            return [true,"данные обновлены"];
        }
        catch (QueryException $e) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function updateRowComputersDb(string $login, string|null $comp, array $param): array
    {
        try {
            if ($comp == null) DB::table('vpncomputers')->where('login', '=', $login)->update($param);
            else DB::table('vpncomputers')->where('login', '=', $login)->where('comp', '=', $comp)->update($param);
            return [true,"данные обновлены"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function updateComputersDb(string $login, string|null $comp, array $param): array
    {
        try {
            if ($comp == null) DB::table('vpncomputers')->where('login', '=', $login)->update($param);
            else DB::table('vpncomputers')->where('login', '=', $login)->where('comp', '=', $comp)->update($param);
            return [true,"данные обновлены"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function insertNewRowUserDb(string $create, string $login, string $name, string $mail): array
    {
        try {
            DB::table('vpnusers')->insert([
                'create' => $create,
                'status' => true,
                'login' => $login,
                'name' => $name,
                'mail' => $mail,
                'wgprofile' => false,
                'emailsend' => false,
                'work' => true
            ]);
            return [true,"данные Users добавлены"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }

    public function insertNewRowCompDb(string $create, string $login, string $comp): array
    {
        try {
            DB::table('vpncomputers')->insert([
                'create' => $create,
                'status' => true,
                'login' => $login,
                'comp' => $comp,
                'firewall' => false,
                'remotegroup' => false,
                'work' => true
            ]);
            return [true,"данные Comps добавлены"];
        }
        catch (QueryException) {
            return [false,'Нет доступа к БД Postgress'];
        }
    }
}