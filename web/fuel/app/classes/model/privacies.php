<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Privacies extends Base
{

    public static function get()
    {
        // 一番大きいIDを取得する
        return \DB::select('*')->from('privacies')->where('disable', '=', '0')->order_by('id', 'desc')->limit(1)->execute('slave')->current();
    }
}
