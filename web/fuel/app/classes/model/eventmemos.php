<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Eventmemos extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code', 'イベントコード')
            ->add_rule('required');
 
        $val->add('memo', 'メモ');

        return $val;
    }

    public static function save($params, $username)
    {
        $data = array();
        $data['memo'] = $params['memo'];
        $data['username'] = $username;
        $data['updated_at'] = \DB::expr('now()');

        \DB::update('events')
            ->set($data)
            ->where('code', '=', $params['code'])
            ->execute();

        return $data;
    }
}
