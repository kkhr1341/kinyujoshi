<?php

namespace Fuel\Migrations;

class Create_projects
{
	public function up()
	{
		\DBUtil::create_table('projects', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'open_date' => array('type' => 'datetime'),
			'close_date' => array('type' => 'datetime'),
			'title' => array('constraint' => 500, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'target_amount' => array('type' => 'bigint'),
			'archive_amount' => array('type' => 'bigint'),
			'num_of_courses' => array('constraint' => 11, 'type' => 'int'),
			'num_of_supporters' => array('constraint' => 11, 'type' => 'int'),
			'num_of_open_courses' => array('constraint' => 11, 'type' => 'int'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('projects');
	}
}