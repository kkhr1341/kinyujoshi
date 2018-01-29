<?php

namespace Fuel\Migrations;

class Create_users_clients
{
	public function up()
	{
		\DBUtil::create_table('users_clients', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 32, 'type' => 'varchar'),
			'client_id' => array('constraint' => 32, 'type' => 'varchar'),
			'client_secret' => array('constraint' => 32, 'type' => 'varchar'),
			'redirect_uri' => array('constraint' => 255, 'type' => 'varchar'),
			'auto_approve' => array('type' => 'tinyint', 'default' => '0'),
			'autonomous' => array('type' => 'tinyint', 'default' => '0'),
			'status' => array('constraint' => '"development","pending","approved","rejected"', 'type' => 'enum', 'default' => 'development'),
			'suspended' => array('type' => 'tinyint', 'default' => '0'),
			'notes' => array('type' => 'tinytext'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('users_clients');
	}
}