<?php

namespace Fuel\Migrations;

class Create_business_inquiry_categories
{
	public function up()
	{
		\DBUtil::create_table('business_inquiry_categories', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'name' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
            'sort' => array('type' => 'float'),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
        \DBUtil::create_index(
            'business_inquiry_categories',
            'code',
            'idx_business_inquiries_code_1',
            'UNIQUE'
        );
	}

	public function down()
	{
		\DBUtil::drop_table('business_inquiry_categories');
	}
}