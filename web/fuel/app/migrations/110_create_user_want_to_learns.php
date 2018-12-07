<?php

namespace Fuel\Migrations;

class Create_user_want_to_learns
{
	public function up()
	{
		\DBUtil::create_table('user_want_to_learns', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
			'value' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
            'created_at' => array('type' => 'datetime'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'user_want_to_learns_ibfk_1',
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
		\DBUtil::drop_table('user_want_to_learns');
	}
}