<?php

namespace Fuel\Migrations;

class Create_user_blogs
{
	public function up()
	{
        \DBUtil::create_table('user_blogs', array(
            'id' => array('type' => 'bigint', 'auto_increment' => true, 'unsigned' => true),
            'code' => array('constraint' => 50, 'type' => 'varchar'),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'status' => array('type' => 'tinyint', 'default' => '0'),
            'title' => array('constraint' => 500, 'type' => 'varchar'),
            'content' => array('type' => 'blob'),
            'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
            'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'user_blogs_ibfk_1',
                    'key' => 'username',
                    'reference' => array(
                        'table' => 'users',
                        'column' => 'username'
                    )
                ),
            )
        );

        \DBUtil::create_index(
            'user_blogs', // テーブル名
            'code', // カラム名
            'idx_user_blogs_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
		\DBUtil::drop_table('user_blogs');
	}
}