<?php

namespace Fuel\Migrations;

class Create_users_sessions
{
	public function up()
	{
		\DBUtil::create_table('users_sessions', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'client_id' => array('constraint' => 32, 'type' => 'varchar'),
			'redirect_uri' => array('constraint' => 255, 'type' => 'varchar'),
			'type_id' => array('constraint' => 64, 'type' => 'varchar'),
			'type' => array('constraint' => '"user","auto"', 'type' => 'enum'),
			'code' => array('type' => 'text'),
			'access_token' => array('constraint' => 50, 'type' => 'varchar'),
			'stage' => array('constraint' => '"request","granted"', 'type' => 'enum'),
			'first_requested' => array('constraint' => 11, 'type' => 'int'),
			'last_updated' => array('constraint' => 11, 'type' => 'int'),
			'limited_access' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_sessions');
	}
}