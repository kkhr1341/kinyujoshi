<?php

namespace Fuel\Migrations;

class Add_want_to_something_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'want_to_something' => array('constraint' => 200, 'type' => 'varchar', 'null' => true, 'after' => 'where_from_other'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'want_to_something'

		));
	}
}
