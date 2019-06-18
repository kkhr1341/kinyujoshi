<?php

namespace Fuel\Migrations;

class Create_blog_user_blogs
{
	public function up()
	{
		\DBUtil::create_table('blog_user_blogs', array(
			'blog_code' => array('constraint' => 50, 'type' => 'varchar'),
			'user_blog_code' => array('constraint' => 50, 'type' => 'varchar'),
        ), array(), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'blog_user_blogs_ibfk_1',
                    'key' => 'blog_code',
                    'reference' => array(
                        'table' => 'blogs',
                        'column' => 'code'
                    )
                ),
                array(
                    'constraint' => 'blog_user_blogs_ibfk_2',
                    'key' => 'user_blog_code',
                    'reference' => array(
                        'table' => 'user_blogs',
                        'column' => 'code'
                    )
                ),
            )
        );

        \DBUtil::create_index(
            'blog_user_blogs', // テーブル名
            'blog_code', // カラム名
            'idx_blog_user_blogs_blog_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );

        \DBUtil::create_index(
            'blog_user_blogs', // テーブル名
            'user_blog_code', // カラム名
            'idx_blog_user_blogs_user_blog_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
		\DBUtil::drop_table('blog_user_blogs');
	}
}