<?php

namespace Fuel\Migrations;

class Create_mybbs
{
	public function up()
	{
		\DBUtil::create_table('mybbs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'message' => array('constraint' => 400, 'type' => 'varchar'),
			'image' => array('constraint' => 50, 'type' => 'varchar'),
			'ip' => array('constraint' => 39, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('mybbs');
	}
}