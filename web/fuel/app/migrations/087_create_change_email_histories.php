<?php

namespace Fuel\Migrations;

class Create_change_email_histories
{
	public function up()
	{
        \DBUtil::create_table('change_email_histories', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'before_email' => array('constraint' => 255, 'type' => 'varchar'),
            'after_email' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime', 'null' => true, 'comment' => '作成日時'),
            'updated_at' => array('type' => 'datetime', 'null' => true, 'comment' => '更新日時'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'change_email_histories_ibfk_1',
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
		\DBUtil::drop_table('change_email_histories');
	}
}
