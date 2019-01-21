<?php

namespace Fuel\Migrations;

class Add_pr_to_blogs
{
	public function up()
	{
		\DBUtil::add_fields('blogs', array(
			'pr' => array('constraint' => 4, 'type' => 'tinyint', 'after' => 'pickup'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('blogs', array(
			'pr',

		));
	}
}
