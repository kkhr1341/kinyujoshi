<?php

namespace Fuel\Migrations;

class Create_users_sessionscopes
{
	public function up()
	{
		\DBUtil::create_table('users_sessionscopes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'session_id' => array('constraint' => 11, 'type' => 'int'),
			'access_token' => array('constraint' => 50, 'type' => 'varchar', 'default' => ''),
			'scope' => array('constraint' => 64, 'type' => 'varchar', 'default' => ''),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('users_sessionscopes');
	}
}