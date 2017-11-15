<?php

namespace Fuel\Migrations;

class Create_files
{
	public function up()
	{
		\DBUtil::create_table('files', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'mode' => array('constraint' => 10, 'type' => 'varchar'),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'type' => array('constraint' => 50, 'type' => 'varchar'),
			'etag' => array('constraint' => 50, 'type' => 'varchar'),
			'title' => array('constraint' => 200, 'type' => 'varchar'),
			'size' => array('constraint' => 30, 'type' => 'varchar'),
			'url' => array('constraint' => 200, 'type' => 'varchar'),
			'thumb' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('files');
	}
}