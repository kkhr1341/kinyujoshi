<?php

namespace Fuel\Migrations;

class Create_profiles
{
	public function up()
	{
		\DBUtil::create_table('profiles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'nickname' => array('constraint' => 50, 'type' => 'varchar'),
			'profile_image' => array('constraint' => 200, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'url' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'location' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'location_open' => array('type' => 'tinyint', 'default' => '0'),
			'birthday' => array('type' => 'date', 'null' => true),
			'gender' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'profile' => array('constraint' => 45, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),
			'twurl' => array('type' => 'text', 'null' => true),
			'fburl' => array('type' => 'text', 'null' => true),
			'instaurl' => array('type' => 'text', 'null' => true),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('profiles');
	}
}