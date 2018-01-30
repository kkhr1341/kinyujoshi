<?php

namespace Fuel\Migrations;

class Add_catchcopy_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'catchcopy' => array('type' => 'text', 'null' => true, 'after' => 'profile'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'catchcopy'

		));
	}
}