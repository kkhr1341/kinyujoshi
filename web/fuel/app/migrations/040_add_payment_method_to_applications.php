<?php

namespace Fuel\Migrations;

class Add_payment_method_to_applications
{
    public function up()
    {
        \DBUtil::add_fields('applications', array(
            'payment_method' => array('constraint' => 1, 'type' => 'tinyint', 'after' => 'amount'),

        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('applications', array(
            'payment_method'

        ));
    }
}