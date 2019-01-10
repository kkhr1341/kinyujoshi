<?php

namespace Fuel\Migrations;

class Add_memo_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'memo' => array('type' => 'text', 'null' => true, 'after' => 'description'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'memo'

		));
	}
}
