<?php

namespace Fuel\Migrations;

class Create_sessions
{
	public function up()
	{
		\DBUtil::create_table('sessions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'session_id' => array('constraint' => 40, 'type' => 'varchar'),
			'previous_id' => array('constraint' => 40, 'type' => 'varchar'),
			'user_agent' => array('type' => 'text'),
			'ip_hash' => array('constraint' => 32, 'type' => 'char'),
			'created' => array('constraint' => 11, 'type' => 'int'),
			'updated' => array('constraint' => 11, 'type' => 'int'),
			'payload' => array('type' => 'longtext'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sessions');
	}
}