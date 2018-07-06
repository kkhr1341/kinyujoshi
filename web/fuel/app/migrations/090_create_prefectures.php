<?php

namespace Fuel\Migrations;

class Create_prefectures
{
	public function up()
	{
		\DBUtil::create_table('prefectures', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('prefectures');
	}
}