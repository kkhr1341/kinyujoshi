<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Needs extends Base
{
    public static function create($params)
    {
        $code = self::getNewCode('needs');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('needs')->set($params)->execute();

        return $params;
    }
}
