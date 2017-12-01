<?php

namespace Fuel\Migrations;

class Create_addresses
{
	public function up()
	{
		\DBUtil::create_table('addresses', array(
			'id' => array('type' => 'bigint', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'zip' => array('constraint' => 10, 'type' => 'varchar'),
			'address' => array('constraint' => 300, 'type' => 'varchar'),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'kana' => array('constraint' => 50, 'type' => 'varchar'),
			'tel' => array('constraint' => 50, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('addresses');
	}
}