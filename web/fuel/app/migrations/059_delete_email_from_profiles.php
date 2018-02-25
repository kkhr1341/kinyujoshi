<?php

namespace Fuel\Migrations;

class Delete_email_from_profiles
{
	public function up()
	{
		\DBUtil::drop_fields('profiles', array(
			'email'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('profiles', array(
                        'email' => array('constraint' => 200, 'type' => 'varchar', 'after' => 'profile_image'),

		));
	}
}
