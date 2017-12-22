<?php

namespace Fuel\Migrations;

class Add_name_to_applications
{
	public function up()
	{
		\DBUtil::add_fields('applications', array(
			'name' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'username', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('applications', array(
			'name'

		));
	}
}