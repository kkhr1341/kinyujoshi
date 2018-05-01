<?php

namespace Fuel\Migrations;

class Add_display_event_date_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'display_event_date' => array('constraint' => 255, 'type' => 'varchar', null => true, 'after' => 'event_date'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'display_event_date'

		));
	}
}
