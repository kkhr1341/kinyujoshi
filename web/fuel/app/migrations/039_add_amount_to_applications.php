<?php

namespace Fuel\Migrations;

class Add_amount_to_applications
{
    public function up()
    {
        \DBUtil::add_fields('applications', array(
            'amount' => array('constraint' => 11, 'type' => 'int', 'default' => '0', 'after' => 'cancel'),

        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('applications', array(
            'amount'

        ));
    }
}