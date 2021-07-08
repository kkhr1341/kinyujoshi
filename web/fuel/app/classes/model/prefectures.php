<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Prefectures extends Base
{

    public static function lists()
    {

        $values = \DB::select("*")->from('prefectures')
            ->execute('slave')
            ->as_array();

        $keys = array();
        foreach ($values as $key => $value) {
            $keys[$value['code']] = $value['name'];
        }
        return $keys;
    }

}
