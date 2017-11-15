<?php

namespace Fuel\Migrations;

class Create_privacies
{
	public function up()
	{
		\DBUtil::create_table('privacies', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'content' => array('type' => 'text'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('privacies');
	}
}