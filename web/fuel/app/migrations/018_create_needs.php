<?php

namespace Fuel\Migrations;

class Create_needs
{
	public function up()
	{
		\DBUtil::create_table('needs', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'name_kana' => array('constraint' => 100, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'message' => array('type' => 'blob'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('needs');
	}
}