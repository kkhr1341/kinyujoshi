<?php

namespace Fuel\Migrations;

class Create_diagnostic_chart_routes
{
	public function up()
	{
		\DBUtil::create_table('diagnostic_chart_routes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'question' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'diagnostic_chart_routes',
            'code',
            'idx_diagnostic_chart_routes_code_1',
            'UNIQUE'
        );

	}

	public function down()
	{
		\DBUtil::drop_table('diagnostic_chart_routes');
	}
}