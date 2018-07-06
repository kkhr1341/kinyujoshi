<?php

namespace Fuel\Migrations;

class Create_withdrawal_reasons
{
	public function up()
	{
		\DBUtil::create_table('withdrawal_reasons', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
            'sort' => array('type' => 'float'),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'withdrawal_reasons', // テーブル名
            'code', // カラム名
            'idx_withdrawal_reasons_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
		\DBUtil::drop_table('withdrawal_reasons');
	}
}