<?php

namespace Fuel\Migrations;

class Add_specific_link_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'specific_link' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'display_past')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'specific_link'

		));
	}
}
