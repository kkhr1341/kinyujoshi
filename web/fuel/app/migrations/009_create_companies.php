<?php

namespace Fuel\Migrations;

class Create_companies
{
	public function up()
	{
		\DBUtil::create_table('companies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'foundation_date' => array('type' => 'date', 'null' => true),
			'capital' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'business' => array('type' => 'text'),
			'zip' => array('constraint' => 10, 'type' => 'varchar', 'null' => true),
			'address' => array('constraint' => 300, 'type' => 'varchar', 'null' => true),
			'tel' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'fax' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'email' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'president' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('companies');
	}
}