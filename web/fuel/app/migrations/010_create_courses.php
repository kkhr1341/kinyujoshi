<?php

namespace Fuel\Migrations;

class Create_courses
{
	public function up()
	{
		\DBUtil::create_table('courses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'project_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'title' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'content' => array('type' => 'blob'),
			'price' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'limit' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'num_of_supporters' => array('constraint' => 11, 'type' => 'int'),
			'open_date' => array('type' => 'datetime', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime', 'null' => true),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('courses');
	}
}