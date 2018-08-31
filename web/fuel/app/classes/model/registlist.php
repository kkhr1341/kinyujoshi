<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Registlist extends Base
{

    public static function member_attribute($attr, $attr_name='')
    {
        if (!$attr_name) {
            $attr_name = $attr;
        }
        return \DB::select(\DB::expr($attr_name . ' as label, count(' . $attr . ') as cnt'))
            ->from('member_regist')
            ->join('users', 'left')
                ->on('users.username', '=', 'member_regist.username')
            ->join('profiles', 'left')
                ->on('profiles.username', '=', 'users.username')
            ->join('prefectures', 'left')
                ->on('prefectures.code', '=', 'profiles.prefecture')
            ->where('member_regist.disable', '=', 1)
            ->where($attr, '!=', null)
            ->where($attr, '!=', '-')
            ->group_by($attr)
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
        \DB::update('member_regist')->set($params)->where('code', '=', $params['code'])->execute();

        if ($username = self::getUsername($params['code'])) {
            \DB::update('profiles')
                ->set(array(
                    'name' => $params['name'],
                    'name_kana' => $params['name_kana'],
                ))
                ->where('username', '=', $username)
                ->execute();

            \DB::update('users')
                ->set(array(
                    'email' => $params['email'],
                ))
                ->where('username', '=', $username)
                ->execute();
        }

        return $params;
    }

    public static function delete($params)
    {

        \DB::delete('member_regist')
            ->where(array('code' => $params['code']))
            ->execute();

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
