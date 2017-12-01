<?php

namespace Fuel\Migrations;

class Create_users_scopes
{
	public function up()
	{
		\DBUtil::create_table('users_scopes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'scope' => array('constraint' => 64, 'type' => 'varchar', 'default' => ''),
			'name' => array('constraint' => 64, 'type' => 'varchar', 'default' => ''),
			'description' => array('constraint' => 255, 'type' => 'varchar', 'default' => ''),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_scopes');
	}
}