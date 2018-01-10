<?php

namespace Fuel\Migrations;

class Add_incur_cancellation_fee_date_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'incur_cancellation_fee_date' => array('type' => 'datetime', null => true, 'after' => 'event_date'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'incur_cancellation_fee_date'

		));
	}
}