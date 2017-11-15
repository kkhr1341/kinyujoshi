<?php

namespace Fuel\Migrations;

class Create_sections
{
	public function up()
	{
		\DBUtil::create_table('sections', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'sort' => array('type' => 'float'),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sections');
	}
}