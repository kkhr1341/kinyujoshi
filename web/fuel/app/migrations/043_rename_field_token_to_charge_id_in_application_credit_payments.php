<?php

namespace Fuel\Migrations;

class Rename_field_token_to_charge_id_in_application_credit_payments
{
	public function up()
	{
		\DBUtil::modify_fields('application_credit_payments', array(
			'token' => array('name' => 'charge_id', 'type' => 'text')
		));
	}

	public function down()
	{
	\DBUtil::modify_fields('application_credit_payments', array(
			'charge_id' => array('name' => 'token', 'type' => 'text')
		));
	}
}