<?php

namespace Fuel\Migrations;

class Add_name_kana_to_member_regist
{
    public function up()
    {
        \DBUtil::add_fields('member_regist', array(
            'name_kana' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'name', 'null' => true),

        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('member_regist', array(
            'name_kana'

        ));
    }
}
