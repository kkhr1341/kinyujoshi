<?php

namespace Fuel\Migrations;

class Add_url_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'url' => array('constraint' => 200, 'type' => 'varchar', 'null' => true, 'after' => 'industry_other'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'url'

		));
	}
}
