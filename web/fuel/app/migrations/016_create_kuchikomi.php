<?php

namespace Fuel\Migrations;

class Create_kuchikomi
{
	public function up()
	{
		\DBUtil::create_table('kuchikomi', array(
			'message' => array('type' => 'text'),
			'nickname' => array('constraint' => 20, 'type' => 'varchar', 'null' => true),

		), null, true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('kuchikomi');
	}
}