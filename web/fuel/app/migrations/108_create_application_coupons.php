<?php

namespace Fuel\Migrations;

class Create_application_coupons
{
	public function up()
	{
		\DBUtil::create_table('application_coupons', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'application_code' => array('constraint' => 50, 'type' => 'varchar'),
			'event_coupon_code' => array('constraint' => 50, 'type' => 'varchar'),
            'discount' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'application_coupons_ibfk_1',
                    'key' => 'application_code',
                    'reference' => array(
                        'table' => 'applications',
                        'column' => 'code',
                    )
                ),
                array(
                    'constraint' => 'application_coupons_ibfk_2',
                    'key' => 'event_coupon_code',
                    'reference' => array(
                        'table' => 'event_coupons',
                        'column' => 'code',
                    )
                ),
            )
        );
        \DBUtil::create_index(
            'application_coupons',
            'application_code',
            'idx_application_coupons_code_1',
            'UNIQUE'
        );
	}

	public function down()
	{
		\DBUtil::drop_table('application_coupons');
	}
}