<?php

namespace Fuel\Migrations;

class Add_authentication_to_blogs
{
	public function up()
	{
		\DBUtil::add_fields('blogs', array(
			'authentication_user' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'where_from_other'),
			'authentication_password' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'authentication_user')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('blogs', array(
			'authentication_user',
			'authentication_password',

		));
	}
}
