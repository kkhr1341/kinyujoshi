<?php

namespace Fuel\Migrations;

class Create_index_code_in_applications
{
	public function up()
	{
        \DBUtil::create_index(
            'applications', // テーブル名
            'code', // カラム名
            'idx_applications_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
	}

	public function down()
	{
        \DBUtil::drop_index(
            'applications', // テーブル名
            'idx_applications_code'
        );
	}
}

