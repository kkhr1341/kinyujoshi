<?php

namespace Fuel\Migrations;

class Create_tsubuyaki
{
	public function up()
	{
		\DBUtil::create_table('tsubuyaki', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'nickname' => array('constraint' => 50, 'type' => 'varchar'),
			'message' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tsubuyaki');
	}
}