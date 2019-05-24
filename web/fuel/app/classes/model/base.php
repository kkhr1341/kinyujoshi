<?php

namespace Model;

class Base extends \Model
{
    public static function emp($params, $key)
    {

        if (!isset($params[$key]) || $params[$key] == "") {
            return false;
        }

        return true;
    }

    public static function getNewCode($table_name, $length = 6)
    {
        while (1) {
            $new_code = self::getRandomString($length);
            $res = self::getRandomNumber($table_name, $new_code);
            if ($res == false) {
                return $new_code;
            }
        }
    }

    public static function getByCode($table_name, $code)
    {
        $result = \DB::select('*')
            ->from($table_name)
            ->where('code', '=', $code)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getById($table_name, $id)
    {
        $result = \DB::select('*')
            ->from($table_name)
            ->where('id', '=', $id)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getByKey($table_name, $key, $value)
    {
        $result = \DB::select('*')
            ->from($table_name)
            ->where($key, '=', $value)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getRandomString($nLengthRequired = 10)
    {
        $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        mt_srand();
        $sRes = "";
        for ($i = 0; $i < $nLengthRequired; $i++) {
            $sRes .= $sCharList[mt_rand(0, strlen($sCharList) - 1)];
        }
        return $sRes;
    }

    public static function getRandomNumber($nLengthRequired = 10)
    {
        $sCharList = "0123456789";
        mt_srand();
        $sRes = "";
        for ($i = 0; $i < $nLengthRequired; $i++) {
            $sRes .= $sCharList[mt_rand(0, strlen($sCharList) - 1)];
        }
        return $sRes;
    }
}
