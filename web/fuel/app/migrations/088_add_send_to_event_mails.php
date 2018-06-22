<?php

namespace Fuel\Migrations;

class Add_send_to_event_mails
{
	public function up()
	{
		\DBUtil::add_fields('event_mails', array(
            'error' => array('type' => 'tinyint', 'default' => '0', 'after' => 'email')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('event_mails', array(
			'error'

		));
	}
}
