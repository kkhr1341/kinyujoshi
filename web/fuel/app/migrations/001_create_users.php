<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'password' => array('constraint' => 255, 'type' => 'varchar'),
            'group' => array('constraint' => 11, 'type' => 'int', 'default' => '1'),
            'email' => array('constraint' => 255, 'type' => 'varchar'),
            'last_login' => array('constraint' => 25, 'type' => 'varchar'),
            'login_hash' => array('constraint' => 255, 'type' => 'varchar'),
            'profile_fields' => array('type' => 'text'),

            'created_at' => array('type' => 'int', 'default' => '0'),
            'updated_at' => array('type' => 'int', 'default' => '0'),

        ), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}