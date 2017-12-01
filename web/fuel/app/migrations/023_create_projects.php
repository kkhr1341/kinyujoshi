<?php

namespace Fuel\Migrations;

class Create_projects
{
	public function up()
	{
		\DBUtil::create_table('projects', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'section_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'status' => array('type' => 'tinyint'),
			'open_date' => array('type' => 'datetime', 'null' => true),
			'close_date' => array('type' => 'datetime', 'null' => true),
			'title' => array('constraint' => 500, 'type' => 'varchar', 'null' => true),
			'content' => array('type' => 'blob'),
			'target_amount' => array('type' => 'bigint', 'null' => true),
			'archive_amount' => array('type' => 'bigint', 'null' => true),
			'num_of_courses' => array('constraint' => 11, 'type' => 'int'),
			'num_of_supporters' => array('constraint' => 11, 'type' => 'int'),
			'num_of_open_courses' => array('constraint' => 11, 'type' => 'int'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
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