<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Addresses extends Base
{

    public static function lists($username)
    {
        return \DB::select("*")->from('addresses')->where('disable', '=', 0)->where('username', '=', $username)->execute('slave')->as_array();
    }

    public static function create($params)
    {

        $code = self::getNewCode('addresses', 10);
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('addresses')->set($params)->execute();

        return $code;
    }


    public static function save($params)
    {

        $username = \Auth::get('username');

        \DB::update('addresses')->set($params)->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

        return $params;
    }

    public static function delete($params)
    {

        $username = \Auth::get('username');
        \DB::update('addresses')->set(array('disable' => 1))->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

        return $params;
    }
}
