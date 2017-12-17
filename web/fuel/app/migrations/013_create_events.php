<?php

namespace Fuel\Migrations;

class Create_events
{
	public function up()
	{
		\DBUtil::create_table('events', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'section_code' => array('constraint' => 50, 'type' => 'varchar'),
			'status' => array('type' => 'tinyint', 'default' => '0'),
			'open_date' => array('type' => 'datetime', 'null' => true),
			'limit' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'application_num' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'title' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'content' => array('type' => 'blob'),
			'main_image' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'place' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'url' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'event_start_datetime' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'event_end_datetime' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'disable' => array('type' => 'tinyint', 'default' => '0'),
			'event_category' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'fee' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'pay_url' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'event_date' => array('type' => 'datetime', 'null' => true),
			'description' => array('type' => 'text', 'null' => true),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('events');
	}
}