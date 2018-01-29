<?php

namespace Fuel\Migrations;

class Create_users_sessions
{
	public function up()
	{
		\DBUtil::create_table('users_sessions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'client_id' => array('constraint' => 32, 'type' => 'varchar', 'default' => ''),
			'redirect_uri' => array('constraint' => 255, 'type' => 'varchar', 'default' => ''),
			'type_id' => array('constraint' => 64, 'type' => 'varchar'),
			'type' => array('constraint' => '"user","auto"', 'type' => 'enum', 'default' => 'user'),
			'code' => array('type' => 'text'),
			'access_token' => array('constraint' => 50, 'type' => 'varchar', 'default' => ''),
			'stage' => array('constraint' => '"request","granted"', 'type' => 'enum', 'default' => 'request'),
			'first_requested' => array('constraint' => 11, 'type' => 'int'),
			'last_updated' => array('constraint' => 11, 'type' => 'int'),
			'limited_access' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('users_sessions');
	}
}