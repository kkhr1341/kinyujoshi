<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class User extends Base
{

    public static function getByEmail($email)
    {
        $result = \DB::select('*')->from('users')
            ->where('users.email', '=', $email)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }
}
