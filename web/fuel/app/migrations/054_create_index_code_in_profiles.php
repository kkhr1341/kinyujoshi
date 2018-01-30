<?php

namespace Fuel\Migrations;

class Create_index_code_in_profiles
{
	public function up()
	{
        \DBUtil::create_index(
            'profiles', // テーブル名
            'code', // カラム名
            'idx_profiles_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'profiles', // テーブル名
            'idx_profiles_code'
        );
	}
}

