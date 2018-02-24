<?php

namespace Fuel\Migrations;

class Add_id_name_to_member_regist
{
	public function up()
	{
		\DBUtil::add_fields('member_regist', array(
			'id_name' => array('constraint' => 50, 'type' => 'varchar', 'null' => true, 'after' => 'job_kind'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('member_regist', array(
			'id_name'

		));
	}
}
