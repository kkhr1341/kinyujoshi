<?php

namespace Fuel\Migrations;

class Add_username_to_authors
{
	public function up()
	{
		\DBUtil::add_fields('authors', array(
			'username' => array('constraint' => 50, 'type' => 'varchar', 'null' => true, 'after' => 'code')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('authors', array(
			'username'

		));
	}
}
