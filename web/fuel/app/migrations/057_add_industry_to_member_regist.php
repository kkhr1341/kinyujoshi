<?php

namespace Fuel\Migrations;

class Add_industry_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'industry' => array('constraint' => 200, 'type' => 'varchar', null => true, 'after' => 'edit_inner'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'industry'

		));
	}
}
