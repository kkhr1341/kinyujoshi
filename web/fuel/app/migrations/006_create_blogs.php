<?php

namespace Fuel\Migrations;

class Create_blogs
{
	public function up()
	{
		\DBUtil::create_table('blogs', array(
			'id' => array('type' => 'bigint'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'project_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'open_date' => array('type' => 'datetime'),
			'title' => array('constraint' => 500, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),
			'description' => array('type' => 'text'),
			'section_name' => array('type' => 'text'),
			'pickup' => array('type' => 'tinyint'),
			'kind' => array('constraint' => 50, 'type' => 'varchar'),
			'keyword' => array('constraint' => 50, 'type' => 'varchar'),
			'where_from' => array('constraint' => 50, 'type' => 'varchar'),
			'where_from_other' => array('constraint' => 200, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('blogs');
	}
}