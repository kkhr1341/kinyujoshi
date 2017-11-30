<?php

namespace Fuel\Migrations;

class Create_payments
{
	public function up()
	{
		\DBUtil::create_table('payments', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'project_code' => array('constraint' => 50, 'type' => 'varchar'),
			'course_code' => array('constraint' => 50, 'type' => 'varchar'),
			'address_code' => array('constraint' => 50, 'type' => 'varchar'),
			'webpay_id' => array('constraint' => 50, 'type' => 'varchar'),
			'livemode' => array('type' => 'tinyint'),
			'amount' => array('constraint' => 11, 'type' => 'int'),
			'card_exp_year' => array('constraint' => 11, 'type' => 'int'),
			'card_exp_month' => array('constraint' => 11, 'type' => 'int'),
			'card_fingerprint' => array('constraint' => 50, 'type' => 'varchar'),
			'card_name' => array('constraint' => 50, 'type' => 'varchar'),
			'card_country' => array('constraint' => 50, 'type' => 'varchar'),
			'card_type' => array('constraint' => 50, 'type' => 'varchar'),
			'card_cvc_check' => array('constraint' => 50, 'type' => 'varchar'),
			'card_last4' => array('constraint' => 50, 'type' => 'varchar'),
			'created' => array('type' => 'datetime'),
			'currency' => array('constraint' => 50, 'type' => 'varchar'),
			'paid' => array('type' => 'tinyint'),
			'captured' => array('type' => 'tinyint'),
			'refunded' => array('type' => 'tinyint'),
			'description' => array('constraint' => 300, 'type' => 'varchar'),
			'failure_message' => array('type' => 'text'),
			'expire_time' => array('type' => 'datetime'),
			'zip' => array('constraint' => 10, 'type' => 'varchar'),
			'address' => array('constraint' => 300, 'type' => 'varchar'),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'kana' => array('constraint' => 50, 'type' => 'varchar'),
			'tel' => array('constraint' => 50, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('payments');
	}
}