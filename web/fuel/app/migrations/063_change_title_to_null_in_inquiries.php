<?php

namespace Fuel\Migrations;

class Change_title_to_null_in_inquiries
{
	public function up()
	{
		\DBUtil::modify_fields('inquiries', array(
			'title' => array('constraint' => 200, 'type' => 'varchar', 'null' => true)
		));
	}

	public function down()
	{
	\DBUtil::modify_fields('inquiries', array(
			'title' => array('constraint' => 200, 'type' => 'varchar')
		));
	}
}