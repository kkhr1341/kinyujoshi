<?php

namespace Fuel\Migrations;

class Create_user_withdrawal_reason_texts
{
	public function up()
	{
        \DBUtil::create_table('user_withdrawal_reason_texts', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'user_withdrawal_reason_code' => array('constraint' => 50, 'type' => 'varchar'),
            'reason_text' => array('type' => 'text'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'user_withdrawal_reason_texts_ibfk_1',
                    'key' => 'user_withdrawal_reason_code',
                    'reference' => array(
                        'table' => 'user_withdrawal_reasons',
                        'column' => 'code'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('user_withdrawal_reason_texts');
	}
}
