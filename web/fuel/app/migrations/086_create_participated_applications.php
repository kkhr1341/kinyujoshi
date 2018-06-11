<?php

namespace Fuel\Migrations;

class Create_participated_applications
{
	public function up()
	{
		\DBUtil::create_table('participated_applications', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'application_code' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'participated_applications_ibfk_1',
                    'key' => 'application_code',
                    'reference' => array(
                        'table' => 'applications',
                        'column' => 'code'
                    )
                ),
            )
        );

        \DBUtil::create_index(
            'participated_applications', // テーブル名
            'code', // カラム名
            'idx_participated_applications_code_1', // インデックス名
            'UNIQUE' // インデックスタイプ
        );

        \DBUtil::create_index(
            'participated_applications', // テーブル名
            'application_code', // カラム名
            'idx_participated_applications_code_2', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
    }

	public function down()
	{
		\DBUtil::drop_table('participated_applications');
	}
}
