<?php

namespace Fuel\Migrations;

class Create_applications
{
	public function up()
	{
		\DBUtil::create_table('applications', array(
			'id' => array('type' => 'bigint'),
			'code' => array('constraint' => 50, 'type' => 'varchar'),
			'event_code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'cancel' => array('type' => 'tinyint'),
			'disable' => array('type' => 'tinyint'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('applications');
	}
}