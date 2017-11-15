<?php

namespace Fuel\Migrations;

class Create_comment
{
	public function up()
	{
		\DBUtil::create_table('comment', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'message' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('comment');
	}
}