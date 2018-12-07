<?php

namespace Fuel\Migrations;

class Add_where_from_site_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'where_from_site' => array('constraint' => 200, 'type' => 'varchar', 'null' => true, 'after' => 'where_from'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'where_from_site'

		));
	}
}
