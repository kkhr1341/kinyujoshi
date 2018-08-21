<?php

namespace Fuel\Migrations;

class Create_diagnostic_chart_route_users
{
    public function up()
    {
        \DBUtil::create_table('diagnostic_chart_route_users', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'diagnostic_chart_type_user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'route_code' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'diagnostic_chart_route_users_ibfk_1',
                    'key' => 'diagnostic_chart_type_user_id',
                    'reference' => array(
                        'table' => 'diagnostic_chart_type_users',
                        'column' => 'id'
                    )
                ),
                array(
                    'constraint' => 'diagnostic_chart_route_users_ibfk_2',
                    'key' => 'route_code',
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
        \DBUtil::drop_table('diagnostic_chart_route_users');
    }
}