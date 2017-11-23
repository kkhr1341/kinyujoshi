<?php

namespace Fuel\Migrations;

class Create_inquiries
{
	public function up()
	{
		\DBUtil::create_table('inquiries', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'category_code' => array('constraint' => 50, 'type' => 'varchar'),
			'company' => array('constraint' => 200, 'type' => 'varchar'),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'name_kana' => array('constraint' => 200, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'title' => array('constraint' => 200, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
			'status' => array('type' => 'tinyint'),
			'user_agent' => array('constraint' => 300, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('inquiries');
	}
}