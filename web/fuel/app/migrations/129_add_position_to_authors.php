<?php

namespace Fuel\Migrations;

class Add_position_to_authors
{
	public function up()
	{
		\DBUtil::add_fields('authors', array(
			'position' => array('constraint' => 200, 'type' => 'varchar', 'null' => true, 'after' => 'code'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('authors', array(
			'position'

		));
	}
}
