<?php

namespace Fuel\Migrations;

class Add_secret_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'secret' => array('type' => 'tinyint', 'default' => '0', 'after' => 'description')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'secret'

		));
	}
}
