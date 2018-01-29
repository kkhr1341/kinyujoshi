<?php

namespace Fuel\Migrations;

class Create_users_providers
{
	public function up()
	{
		\DBUtil::create_table('users_providers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'parent_id' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),
			'provider' => array('constraint' => 50, 'type' => 'varchar'),
			'uid' => array('constraint' => 255, 'type' => 'varchar'),
			'secret' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'access_token' => array('constraint' => 255, 'type' => 'varchar'),
			'expires' => array('constraint' => 12, 'type' => 'int', 'default' => '0', 'null' => true),
			'refresh_token' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),

            'created_at' => array('type' => 'int', 'default' => '0'),
            'updated_at' => array('type' => 'int', 'default' => '0'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('users_providers');
	}
}