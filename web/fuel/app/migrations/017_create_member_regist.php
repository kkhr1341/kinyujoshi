<?php

namespace Fuel\Migrations;

class Create_member_regist
{
	public function up()
	{
		\DBUtil::create_table('member_regist', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'age' => array('constraint' => 100, 'type' => 'varchar'),
			'not_know' => array('constraint' => 200, 'type' => 'varchar'),
			'interest' => array('type' => 'mediumtext'),
			'ask' => array('type' => 'mediumtext'),
			'income' => array('constraint' => 100, 'type' => 'varchar'),
			'transmission' => array('constraint' => 100, 'type' => 'varchar'),
			'email' => array('constraint' => 100, 'type' => 'varchar'),
			'facebook' => array('constraint' => 100, 'type' => 'varchar'),
			'other_sns' => array('constraint' => 100, 'type' => 'varchar'),
			'introduction' => array('type' => 'text'),
			'user_agent' => array('constraint' => 300, 'type' => 'varchar'),
			'where_from' => array('constraint' => 50, 'type' => 'varchar'),
			'where_from_other' => array('constraint' => 200, 'type' => 'varchar'),
			'job_kind' => array('constraint' => 50, 'type' => 'varchar'),
			'name_kana' => array('constraint' => 50, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),
			'edit_inner' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('member_regist');
	}
}