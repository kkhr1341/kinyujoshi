<?php

namespace Fuel\Migrations;

class Create_pages
{
	public function up()
	{
		\DBUtil::create_table('pages', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'open_date' => array('type' => 'datetime'),
			'title' => array('constraint' => 500, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('pages');
	}
}