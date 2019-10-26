<?php

namespace Fuel\Migrations;

class Add_status_to_event_remind_mail_templates
{
	public function up()
	{
		\DBUtil::add_fields('event_remind_mail_templates', array(
			'status' => array('type' => 'tinyint', 'default' => '0', 'after' => 'body')
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('event_remind_mail_templates', array(
			'status'

		));
	}
}
