<?php

namespace Fuel\Migrations;

class Add_sale_to_application_credit_payments
{
	public function up()
	{
		\DBUtil::add_fields('application_credit_payments', array(
                        'sale' => array('type' => 'tinyint', 'default' => '0', 'after' => 'charge_id')

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('application_credit_payments', array(
			'sale'

		));
	}
}
