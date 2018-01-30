<?php

namespace Fuel\Migrations;

class Create_index_username_in_users
{
	public function up()
	{
        \DBUtil::create_index(
            'users', // テーブル名
            'username', // カラム名
            'idx_users_username', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'users', // テーブル名
            'idx_users_username'
        );
	}
}

