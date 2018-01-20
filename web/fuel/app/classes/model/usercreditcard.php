<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Usercreditcard extends Base
{
//	protected static $_properties = array(
//		'id',
//		'username',
//		'card_id',
//		'created_at',
//		'updated_at',
//	);
//
//	protected static $_observers = array(
//		'Orm\Observer_CreatedAt' => array(
//			'events' => array('before_insert'),
//			'mysql_timestamp' => false,
//		),
//		'Orm\Observer_UpdatedAt' => array(
//			'events' => array('before_update'),
//			'mysql_timestamp' => false,
//		),
//	);
//
//	protected static $_table_name = 'user_credit_cards';

    public static function lists($username) {
        return \DB::select("*")->from('user_credit_cards')
            ->where('user_credit_cards.username', '=', $username)
            ->execute()
            ->as_array();
    }
}
