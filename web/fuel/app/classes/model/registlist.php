<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Registlist extends Base
{

    public static function lists($username)
    {
        return \DB::select("*")->from('member_regist')
            ->where('member_regist.disable', '=', 0)
            ->execute()
            ->as_array();
    }

    public static function create($params)
    {
        $code = self::getNewCode('member_regist');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        \DB::insert('member_regist')->set($params)->execute();
        return $params;
    }

    public static function save($params)
    {
        $username = \Auth::get('username');
        \DB::update('member_regist')->set($params)->where('code', '=', $params['code'])->execute();
        return $params;
    }

    public static function delete($params)
    {

        $username = \Auth::get('username');
        \DB::update('member_regist')->set(array('disable' => 0))->where('code', '=', $params['code'])->execute();

        return $params;
    }

    public static function getUsername($code)
    {
        $result = \DB::select('users.username')
            ->from('member_regist')
            ->where('code', '=', $code)
            ->join('users')
            ->on('member_regist.username', '=', 'users.username')
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result['username'];
    }
}
