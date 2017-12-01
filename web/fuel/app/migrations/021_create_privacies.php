<?php

namespace Fuel\Migrations;

class Create_privacies
{
	public function up()
	{
		\DBUtil::create_table('privacies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'content' => array('type' => 'text'),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('privacies');
	}
}