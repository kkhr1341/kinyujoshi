<?php

namespace Fuel\Migrations;

class Create_consultations
{
	public function up()
	{
		\DBUtil::create_table('consultations', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'consultations', // テーブル名
            'code', // カラム名
            'idx_consultations_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );

    }

	public function down()
	{
		\DBUtil::drop_table('consultations');
	}
}