<?php

namespace Fuel\Migrations;

class Add_place_url_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'place_url' => array('constraint' => 200, 'type' => 'varchar', null => true, 'after' => 'place'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'place_url'

		));
	}
}