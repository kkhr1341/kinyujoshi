<?php

namespace Fuel\Migrations;

class Add_zoom_url_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'zoom_url' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'event_category'),
			'zoom_id' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'zoom_url'),
			'zoom_pass' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'after' => 'zoom_id')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'zoom_url',
			'zoom_id',
			'zoom_pass'
		));
	}
}