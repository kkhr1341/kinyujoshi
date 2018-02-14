<?php

namespace Fuel\Migrations;

class Add_industry_other_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'industry_other' => array('constraint' => 200, 'type' => 'varchar', null => true, 'after' => 'industry'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'industry_other'

		));
	}
}
