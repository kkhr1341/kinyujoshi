<?php

namespace Fuel\Migrations;

class Create_users_reminders
{
    public function up()
    {
        \DBUtil::create_table('users_reminders', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'access_token' => array('constraint' => 255, 'type' => 'varchar'),
            'expires' => array('type' => 'datetime', 'null' => true),
            'created_at' => array('type' => 'datetime', 'null' => true, 'comment' => '作成日時'),
            'updated_at' => array('type' => 'datetime', 'null' => true, 'comment' => '更新日時'),

        ), array('id'), true, 'InnoDB', null);

        \DBUtil::create_index(
            'users_reminders', // テーブル名
            'access_token', // カラム名
            'idx_users_reminders_access_token', // インデックス名
            'UNIQUE' // インデックスタイプ
        );
    }

    public function down()
    {
        \DBUtil::drop_table('users_reminders');
    }
}