<?php

namespace Fuel\Migrations;

class Delete_cancel_from_application_credit_payments
{
	public function up()
	{
		\DBUtil::drop_fields('application_credit_payments', array(
			'cancel'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('application_credit_payments', array(
            'cancel' => array('type' => 'tinyint', 'default' => '0', 'after' => 'sale'),

		));
	}
}
