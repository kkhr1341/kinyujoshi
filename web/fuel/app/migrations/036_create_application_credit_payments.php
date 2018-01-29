<?php

namespace Fuel\Migrations;

class Create_application_credit_payments
{
	public function up()
	{
		\DBUtil::create_table('application_credit_payments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'application_code' => array('constraint' => 50, 'type' => 'varchar'),
			'token' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('application_credit_payments');
	}
}