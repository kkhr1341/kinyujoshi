<?php

namespace Fuel\Migrations;

class Add_email_to_applications
{
    public function up()
    {
        \DBUtil::add_fields('applications', array(
            'email' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'name'),

        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('applications', array(
            'email'

        ));
    }
}