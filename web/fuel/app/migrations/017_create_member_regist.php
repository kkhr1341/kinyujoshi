<?php

namespace Fuel\Migrations;

class Create_member_regist
{
	public function up()
	{
		\DBUtil::create_table('member_regist', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'age' => array('constraint' => 100, 'type' => 'varchar'),
			'not_know' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'interest' => array('type' => 'mediumtext'),
			'ask' => array('type' => 'mediumtext'),
			'income' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'transmission' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'email' => array('constraint' => 100, 'type' => 'varchar'),
			'facebook' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'other_sns' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'introduction' => array('type' => 'text'),
			'user_agent' => array('constraint' => 300, 'type' => 'varchar', 'null' => true),
			'where_from' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'where_from_other' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'job_kind' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'id_name' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '1'),
			'edit_inner' => array('type' => 'text'),
			'industry' => array('constraint' => 200, 'type' => 'varchar'),
			'industry_other' => array('constraint' => 200, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime', 'null' => true),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('member_regist');
	}
}