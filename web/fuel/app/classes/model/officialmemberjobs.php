<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Officialmemberjobs extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name', '名前');

        return $val;
    }

    public static function lists()
    {
        $values = \DB::select("*")->from('official_member_jobs')
            ->execute()
            ->as_array();

        $keys = array();
        foreach ($values as $key => $value) {
            $keys[$value['id']] = $value['name'];
        }
        return $keys;
    }
}
