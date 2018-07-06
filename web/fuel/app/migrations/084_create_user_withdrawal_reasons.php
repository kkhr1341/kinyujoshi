<?php

namespace Fuel\Migrations;

class Create_user_withdrawal_reasons
{
	public function up()
	{
        \DBUtil::create_table('user_withdrawal_reasons', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'user_withdrawal_code' => array('constraint' => 50, 'type' => 'varchar'),
            'withdrawal_reason_code' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'user_withdrawal_reasons_ibfk_1',
                    'key' => 'user_withdrawal_code',
                    'reference' => array(
                        'table' => 'user_withdrawal',
                        'column' => 'code'
                    )
                ),
                array(
                    'constraint' => 'user_withdrawal_reasons_ibfk_2',
                    'key' => 'withdrawal_reason_code',
                    'reference' => array(
                        'table' => 'withdrawal_reasons',
                        'column' => 'code'
                    )
                ),
            )
        );


        \DBUtil::create_index(
            'user_withdrawal_reasons', // テーブル名
            'code', // カラム名
            'idx_user_withdrawal_reasons_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
		\DBUtil::drop_table('user_withdrawal_reasons');
	}
}
