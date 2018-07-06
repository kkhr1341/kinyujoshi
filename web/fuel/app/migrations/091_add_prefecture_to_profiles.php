<?php

namespace Fuel\Migrations;

class Add_prefecture_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'prefecture' => array('constraint' => 50, 'type' => 'varchar', 'null' => true, 'after' => 'gender'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'prefecture',

		));
	}
}
