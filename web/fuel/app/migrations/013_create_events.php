<?php

namespace Fuel\Migrations;

class Create_events
{
	public function up()
	{
		\DBUtil::create_table('events', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint'),
			'open_date' => array('type' => 'datetime'),
			'limit' => array('constraint' => 11, 'type' => 'int'),
			'application_num' => array('constraint' => 11, 'type' => 'int'),
			'title' => array('constraint' => 200, 'type' => 'varchar'),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar'),
			'place' => array('constraint' => 200, 'type' => 'varchar'),
			'url' => array('constraint' => 200, 'type' => 'varchar'),
			'event_start_datetime' => array('constraint' => 50, 'type' => 'varchar'),
			'event_end_datetime' => array('constraint' => 50, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint'),
			'event_category' => array('constraint' => 50, 'type' => 'varchar'),
			'fee' => array('constraint' => 50, 'type' => 'varchar'),
			'pay_url' => array('constraint' => 200, 'type' => 'varchar'),
			'event_date' => array('type' => 'datetime'),
			'description' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('events');
	}
}