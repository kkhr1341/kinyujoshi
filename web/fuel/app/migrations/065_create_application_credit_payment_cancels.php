<?php

namespace Fuel\Migrations;

class Create_application_credit_payment_cancels
{
	public function up()
	{
		\DBUtil::create_table('application_credit_payment_cancels', array(
                        'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
                        'application_code' => array('constraint' => 50, 'type' => 'varchar'),
                        'created_at' => array('type' => 'datetime'),
                        'updated_at' => array('type' => 'timestamp'),
                ), array('id'), true, 'InnoDB', null,
                    array(
                        array(
                            'constraint' => 'application_credit_payment_cancels_ibfk_1',
                            'key' => 'application_code',
                            'reference' => array(
                                'table' => 'application_credit_payments',
                                'column' => 'application_code'
                            )
                        ),
                    )
                );
                \DBUtil::create_index('application_credit_payment_cancels', array('application_code'), 'application_credit_payment_cancels_ibuk_1', 'UNIQUE');
	}

	public function down()
	{
		\DBUtil::drop_table('application_credit_payment_cancels');
	}
}
