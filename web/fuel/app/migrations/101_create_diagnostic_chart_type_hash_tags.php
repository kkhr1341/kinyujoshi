<?php

namespace Fuel\Migrations;

class Create_diagnostic_chart_type_hash_tags
{
    public function up()
    {
        \DBUtil::create_table('diagnostic_chart_type_hash_tags', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'type_code' => array('constraint' => 50, 'type' => 'varchar'),
            'hash_tag' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'diagnostic_chart_type_hash_tags_ibfk_1',
                    'key' => 'type_code',
                    'reference' => array(
                        'table' => 'diagnostic_chart_types',
                        'column' => 'code'
                    )
                ),
            )
        );
    }

    public function down()
    {
        \DBUtil::drop_table('diagnostic_chart_type_hash_tags');
    }
}