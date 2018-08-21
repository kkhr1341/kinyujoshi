<?php

namespace Fuel\Migrations;

class Create_diagnostic_chart_route_paths
{
	public function up()
	{
		\DBUtil::create_table('diagnostic_chart_route_paths', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'route_code' => array('constraint' => 50, 'type' => 'varchar'),
            'next_route_code' => array('constraint' => 50, 'type' => 'varchar'),
            'yes_no' => array('constraint' => 1, 'type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'diagnostic_chart_routes_ibfk_1',
                    'key' => 'route_code',
                    'reference' => array(
                        'table' => 'diagnostic_chart_routes',
                        'column' => 'code'
                    )
                ),
                array(
                    'constraint' => 'diagnostic_chart_routes_ibfk_2',
                    'key' => 'next_route_code',
                    'reference' => array(
                        'table' => 'diagnostic_chart_routes',
                        'column' => 'code'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('diagnostic_chart_route_paths');
	}
}