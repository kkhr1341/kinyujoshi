<?php

namespace Fuel\Migrations;

class Create_customers
{
	public function up()
	{
		\DBUtil::create_table('customers', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'customer_id' => array('constraint' => 50, 'type' => 'varchar'),
			'description' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('customers');
	}
}