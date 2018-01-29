<?php

namespace Fuel\Migrations;

class Create_document_company
{
	public function up()
	{
		\DBUtil::create_table('document_company', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 50, 'type' => 'varchar'),
			'company' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('document_company');
	}
}