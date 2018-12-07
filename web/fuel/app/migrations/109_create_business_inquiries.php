<?php

namespace Fuel\Migrations;

class Create_business_inquiries
{
	public function up()
	{
		\DBUtil::create_table('business_inquiries', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
            'username' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'category_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'company' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'department' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'tel' => array('constraint' => 200, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar'),
			'transmission' => array('constraint' => 100, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
			'user_agent' => array('constraint' => 300, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
        \DBUtil::create_index(
            'business_inquiries',
            'code',
            'idx_business_inquiries_code_1',
            'UNIQUE'
        );
	}

	public function down()
	{
		\DBUtil::drop_table('business_inquiries');
	}
}