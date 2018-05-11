<?php

namespace Fuel\Migrations;

class Add_display_past_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'display_past' => array('type' => 'tinyint', 'default' => '0', 'after' => 'display')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'display_past'

		));
	}
}
