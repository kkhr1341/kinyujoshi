<?php

namespace Fuel\Migrations;

class Create_users_sessionscopes
{
	public function up()
	{
		\DBUtil::create_table('users_sessionscopes', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'session_id' => array('constraint' => 11, 'type' => 'int'),
			'access_token' => array('constraint' => 50, 'type' => 'varchar'),
			'scope' => array('constraint' => 64, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_sessionscopes');
	}
}