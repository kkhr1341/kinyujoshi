<?php

namespace Fuel\Migrations;

class Add_email_to_regist_reminders
{
	public function up()
	{
		\DBUtil::add_fields('regist_reminders', array(
			'email' => array('constraint' => 255, 'type' => 'varchar', null => true, 'after' => 'access_token'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('regist_reminders', array(
			'email'

		));
	}
}
