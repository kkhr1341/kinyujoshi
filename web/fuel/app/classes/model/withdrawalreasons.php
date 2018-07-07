<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Withdrawalreasons extends Base
{

    public static function lists()
    {

        $reasons = \DB::select("*")->from('withdrawal_reasons')
            ->order_by('sort', 'asc')
            ->execute()
            ->as_array();

        $keys = array();
        foreach ($reasons as $key => $reason) {
            $keys[$reason['code']] = $reason;
        }
        return $keys;
    }

}
