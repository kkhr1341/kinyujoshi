<?php

namespace Fuel\Migrations;

class Create_kuchikomi
{
	public function up()
	{
		\DBUtil::create_table('kuchikomi', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'message' => array('type' => 'text'),
			'nickname' => array('constraint' => 20, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('kuchikomi');
	}
}