<?php

namespace Fuel\Migrations;

class Add_discount_to_applications
{
	public function up()
	{
		\DBUtil::add_fields('applications', array(
			'fee' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'after' => 'amount'),
			'discount' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'after' => 'fee'),
			'coupon_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true, 'after' => 'discount')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('applications', array(
			'fee',
			'discount',
			'coupon_code',

		));
	}
}
