<?php

namespace Fuel\Migrations;

class Add_creditch_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'creditch' => array('constraint' => 1, 'type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'creditch'

		));
	}
}