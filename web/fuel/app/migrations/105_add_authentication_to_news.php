<?php

namespace Fuel\Migrations;

class Add_authentication_to_news
{
	public function up()
	{
		\DBUtil::add_fields('news', array(
			'authentication_user' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'main_image'),
			'authentication_password' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'authentication_user')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('news', array(
			'authentication_user',
			'authentication_password',

		));
	}
}
