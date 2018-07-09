<?php

namespace Fuel\Migrations;

class Create_diagnostic_chart_types
{
	public function up()
	{
		\DBUtil::create_table('diagnostic_chart_types', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'type' => array('constraint' => 5, 'type' => 'varchar'),
            'character_name' => array('constraint' => 255, 'type' => 'varchar'),
            'catch_copy' => array('constraint' => 255, 'type' => 'varchar'),
            'description' => array('type' => 'text'),
            'character_image' => array('constraint' => 255, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'diagnostic_chart_types',
            'code',
            'idx_diagnostic_chart_types_code_1',
            'UNIQUE'
        );
	}

	public function down()
	{
		\DBUtil::drop_table('diagnostic_chart_types');
	}
}