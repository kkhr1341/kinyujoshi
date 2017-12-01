<?php

namespace Fuel\Migrations;

class Add_name_kana_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'name_kana' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'name'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'name_kana'

		));
	}
}