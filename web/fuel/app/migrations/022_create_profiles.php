<?php

namespace Fuel\Migrations;

class Create_profiles
{
	public function up()
	{
		\DBUtil::create_table('profiles', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'nickname' => array('constraint' => 50, 'type' => 'varchar'),
			'profile_image' => array('constraint' => 200, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'url' => array('constraint' => 200, 'type' => 'varchar'),
			'location' => array('constraint' => 50, 'type' => 'varchar'),
			'location_open' => array('type' => 'tinyint'),
			'birthday' => array('type' => 'date'),
			'gender' => array('constraint' => 50, 'type' => 'varchar'),
			'profile' => array('constraint' => 45, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),
			'twurl' => array('type' => 'text'),
			'fburl' => array('type' => 'text'),
			'instaurl' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('profiles');
	}
}