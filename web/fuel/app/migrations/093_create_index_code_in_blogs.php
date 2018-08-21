<?php

namespace Fuel\Migrations;

class Create_index_code_in_blogs
{
    public function up()
    {
        \DBUtil::create_index(
            'blogs', // テーブル名
            'code', // カラム名
            'idx_blogs_code', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
    }

    public function down()
    {
        \DBUtil::drop_index(
            'blogs', // テーブル名
            'idx_blogs_code'
        );
    }
}

