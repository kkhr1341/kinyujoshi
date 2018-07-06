<?php

namespace Fuel\Migrations;

class Create_user_withdrawal
{
	public function up()
	{
		\DBUtil::create_table('user_withdrawal', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'user_withdrawal', // テーブル名
            'code', // カラム名
            'idx_user_withdrawal_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
		\DBUtil::drop_table('user_withdrawal');
	}
}