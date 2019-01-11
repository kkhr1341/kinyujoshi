<?php

namespace Fuel\Migrations;

class Create_authors
{
	public function up()
	{
		\DBUtil::create_table('authors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'profile_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'introduction' => array('type' => 'text', 'null' => true),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('authors');
	}
}