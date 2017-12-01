<?php

namespace Fuel\Migrations;

class Add_name_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'name' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'code'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'name'

		));
	}
}