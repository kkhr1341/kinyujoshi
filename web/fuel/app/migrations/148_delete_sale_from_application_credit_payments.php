<?php

namespace Fuel\Migrations;

class Delete_sale_from_application_credit_payments
{
	public function up()
	{
		\DBUtil::drop_fields('application_credit_payments', array(
			'sale'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('application_credit_payments', array(
            'sale' => array('type' => 'tinyint', 'default' => '0', 'after' => 'charge_id'),

		));
	}
}
