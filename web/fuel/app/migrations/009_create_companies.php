<?php

namespace Fuel\Migrations;

class Create_companies
{
	public function up()
	{
		\DBUtil::create_table('companies', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'foundation_date' => array('type' => 'date'),
			'capital' => array('constraint' => 11, 'type' => 'int'),
			'business' => array('type' => 'text'),
			'zip' => array('constraint' => 10, 'type' => 'varchar'),
			'address' => array('constraint' => 300, 'type' => 'varchar'),
			'tel' => array('constraint' => 50, 'type' => 'varchar'),
			'fax' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 50, 'type' => 'varchar'),
			'president' => array('constraint' => 100, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('companies');
	}
}