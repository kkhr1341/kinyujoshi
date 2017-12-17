<?php

namespace Fuel\Migrations;

class Create_news
{
	public function up()
	{
		\DBUtil::create_table('news', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint', 'default' => '0'),
			'open_date' => array('type' => 'datetime'),
			'title' => array('constraint' => 200, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('news');
	}
}