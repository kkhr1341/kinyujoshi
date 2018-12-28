<?php

namespace Fuel\Migrations;

class Create_inquiry_reply_mails
{
	public function up()
	{
        \DBUtil::create_index(
            'inquiries', // テーブル名
            'code', // カラム名
            'idx_inquiries_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );

		\DBUtil::create_table('inquiry_reply_mails', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'inquiry_code' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'subject' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'body' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'inquiry_reply_mails_ibfk_1',
                    'key' => 'inquiry_code',
                    'reference' => array(
                        'table' => 'inquiries',
                        'column' => 'code'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('inquiry_reply_mails');
        \DBUtil::drop_index(
            'inquiries', // テーブル名
            'idx_inquiries_code'
        );
	}
}