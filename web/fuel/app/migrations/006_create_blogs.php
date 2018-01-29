<?php

namespace Fuel\Migrations;

class Create_blogs
{
	public function up()
	{
		\DBUtil::create_table('blogs', array(
			'id' => array('type' => 'bigint', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'project_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'status' => array('type' => 'tinyint', 'default' => '0'),
			'open_date' => array('type' => 'datetime'),
			'title' => array('constraint' => 500, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),
			'description' => array('type' => 'text'),
			'section_name' => array('type' => 'text'),
			'pickup' => array('type' => 'tinyint', 'default' => '0'),
			'kind' => array('constraint' => 50, 'type' => 'varchar'),
			'keyword' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'where_from' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'where_from_other' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('blogs');
	}
}