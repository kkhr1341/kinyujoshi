<?php

namespace Fuel\Migrations;

class Create_index_code_in_member_regist
{
	public function up()
	{
        \DBUtil::create_index(
            'member_regist', // テーブル名
            'code', // カラム名
            'idx_member_regist_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'member_regist', // テーブル名
            'idx_member_regist_code'
        );
	}
}

