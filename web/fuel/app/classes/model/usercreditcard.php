<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Usercreditcard extends Base
{

    public static function lists($username)
    {
        $rows = \DB::select("card_id")->from('user_credit_cards')
            ->where('user_credit_cards.username', '=', $username)
            ->execute()
            ->as_array();
        $ary = array();
        foreach ($rows as $row) {
            $ary[] = $row['card_id'];
        }
        return $ary;
    }
}
