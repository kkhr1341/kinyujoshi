<?php

namespace Fuel\Migrations;

class Add_display_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'display' => array('type' => 'tinyint', 'default' => '1', 'after' => 'status')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'display'

		));
	}
}
