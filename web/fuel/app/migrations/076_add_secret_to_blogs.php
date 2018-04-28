<?php

namespace Fuel\Migrations;

class Add_secret_to_blogs
{
	public function up()
	{
		\DBUtil::add_fields('blogs', array(
			'secret' => array('type' => 'tinyint', 'default' => '0', 'after' => 'open_date')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('blogs', array(
			'secret'

		));
	}
}
