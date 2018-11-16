<?php

namespace Fuel\Migrations;

class Create_business_inquiry_appointment_dates
{
	public function up()
	{
		\DBUtil::create_table('business_inquiry_appointment_dates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'business_inquiry_code' => array('constraint' => 50, 'type' => 'varchar'),
			'appointment_date' => array('type' => 'date'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'business_inquiry_appointment_dates_ibfk_1',
                    'key' => 'business_inquiry_code',
                    'reference' => array(
                        'table' => 'business_inquiries',
                        'column' => 'code',
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('business_inquiry_appointment_dates');
	}
}