<?php

namespace Fuel\Migrations;

class Create_comment
{
	public function up()
	{
		\DBUtil::create_table('comment', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'message' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('comment');
	}
}