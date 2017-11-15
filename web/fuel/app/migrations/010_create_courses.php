<?php

namespace Fuel\Migrations;

class Create_courses
{
	public function up()
	{
		\DBUtil::create_table('courses', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'project_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'title' => array('constraint' => 200, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'price' => array('constraint' => 11, 'type' => 'int'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar'),
			'limit' => array('constraint' => 11, 'type' => 'int'),
			'num_of_supporters' => array('constraint' => 11, 'type' => 'int'),
			'open_date' => array('type' => 'datetime'),
			'disable' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('courses');
	}
}