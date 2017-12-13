<?php

namespace Fuel\Migrations;

class Create_sections
{
	public function up()
	{
		\DBUtil::create_table('sections', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'sort' => array('type' => 'float'),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sections');
	}
}