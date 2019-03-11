<?php

namespace Fuel\Migrations;

class Add_specific_application_link_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'specific_application_link' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'specific_link')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'specific_application_link'

		));
	}
}
