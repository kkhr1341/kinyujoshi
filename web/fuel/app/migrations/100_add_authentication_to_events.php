<?php

namespace Fuel\Migrations;

class Add_authentication_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'authentication_user' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'secret'),
			'authentication_password' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'authentication_user')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'authentication_user',
			'authentication_password',

		));
	}
}
