<?php

namespace Fuel\Migrations;

class Add_official_profile_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'official_member_job' => array('type' => 'bigint', 'unsigned' => true, 'null' => false, 'default' => '0', 'after' => 'instaurl'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'official_member_job',

		));
	}
}
