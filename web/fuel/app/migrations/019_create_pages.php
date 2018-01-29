<?php

namespace Fuel\Migrations;

class Create_pages
{
	public function up()
	{
		\DBUtil::create_table('pages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'status' => array('type' => 'tinyint', 'default' => '0'),
			'open_date' => array('type' => 'datetime', 'null' => true),
			'title' => array('constraint' => 500, 'type' => 'varchar', 'null' => true),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('pages');
	}
}