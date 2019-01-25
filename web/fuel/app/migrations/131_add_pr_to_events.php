<?php

namespace Fuel\Migrations;

class Add_pr_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'pr' => array('constraint' => 4, 'type' => 'tinyint', 'after' => 'secret'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'pr',

		));
	}
}
