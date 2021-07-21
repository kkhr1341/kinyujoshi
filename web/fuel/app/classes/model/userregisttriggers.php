<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class UserRegistTriggers extends Base
{
    public static function lists($username)
    {
        $user_regist_triggers = \DB::select(\DB::expr('user_regist_triggers.*'))
            ->from('user_regist_triggers')
            ->where('user_regist_triggers.username', '=', $username)
            ->execute('slave')
            ->as_array();

        $array = array();
        foreach ($user_regist_triggers as $row) {
            $array[] = $row["value"];
        }

        return $array;
    }
}
