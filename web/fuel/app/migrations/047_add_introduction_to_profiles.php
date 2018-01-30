<?php

namespace Fuel\Migrations;

class Add_introduction_to_profiles
{
    public function up()
    {
        \DBUtil::add_fields('profiles', array(
            'introduction' => array('type' => 'text', 'null' => true, 'after' => 'catchcopy'),

        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('profiles', array(
            'introduction'

        ));
    }
}