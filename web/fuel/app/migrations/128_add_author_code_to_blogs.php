<?php

namespace Fuel\Migrations;

class Add_author_code_to_blogs
{
	public function up()
	{
		\DBUtil::add_fields('blogs', array(
			'author_code' => array('constraint' => 50, 'type' => 'varchar', 'after' => 'where_from_other'),

		));
        \DBUtil::create_index(
            'blogs', // テーブル名
            'author_code', // カラム名
            'idx_blogs_author_code' // インデックス名
        );
	}

	public function down()
	{
		\DBUtil::drop_fields('blogs', array(
			'author_code'

		));
	}
}
