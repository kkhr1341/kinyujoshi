<?php

namespace Fuel\Migrations;

class Create_event_coupons
{
	public function up()
	{
		\DBUtil::create_table('event_coupons', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'coupon_code' => array('constraint' => 50, 'type' => 'varchar'),
			'event_code' => array('constraint' => 50, 'type' => 'varchar'),
			'discount' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'disable' => array('type' => 'tinyint', 'default' => '0'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'event_coupons_ibfk_1',
                    'key' => 'event_code',
                    'reference' => array(
                        'table' => 'events',
                        'column' => 'code',
                    )
                ),
            )
        );
        \DBUtil::create_index(
            'event_coupons',
            'code',
            'idx_event_coupons_code_1',
            'UNIQUE'
        );
//        \DBUtil::create_index(
//            'event_coupons',
//            'coupon_code',
//            'idx_event_coupons_code_2',
//            'UNIQUE'
//        );
	}

	public function down()
	{
		\DBUtil::drop_table('event_coupons');
	}
}