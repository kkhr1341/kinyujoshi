<?php

namespace Fuel\Migrations;

class Create_files
{
	public function up()
	{
		\DBUtil::create_table('files', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'mode' => array('constraint' => 10, 'type' => 'varchar'),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'type' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'etag' => array('constraint' => 50, 'type' => 'varchar'),
			'title' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'size' => array('constraint' => 30, 'type' => 'varchar', 'null' => true),
			'url' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'thumb' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('files');
	}
}