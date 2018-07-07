<?php

namespace Fuel\Migrations;

class Create_passports
{
	public function up()
	{
		\DBUtil::create_table('passports', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'message' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'passports_ibfk_1',
                    'key' => 'username',
                    'reference' => array(
                        'table' => 'users',
                        'column' => 'username'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('passports');
	}
}