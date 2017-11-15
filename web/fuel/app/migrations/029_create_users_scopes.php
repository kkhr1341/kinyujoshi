<?php

namespace Fuel\Migrations;

class Create_users_scopes
{
	public function up()
	{
		\DBUtil::create_table('users_scopes', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'scope' => array('constraint' => 64, 'type' => 'varchar'),
			'name' => array('constraint' => 64, 'type' => 'varchar'),
			'description' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_scopes');
	}
}