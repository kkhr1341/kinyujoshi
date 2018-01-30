<?php

namespace Fuel\Migrations;

class Create_index_email_in_users
{
    public function up()
    {
        \DBUtil::create_index(
            'users', // テーブル名
            'email', // カラム名
            'idx_users_email', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
    }

    public function down()
    {
        \DBUtil::drop_index(
            'users', // テーブル名
            'idx_users_email'
        );
    }
}

