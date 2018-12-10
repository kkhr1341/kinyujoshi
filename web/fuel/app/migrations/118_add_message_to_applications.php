<?php

namespace Fuel\Migrations;

class Add_message_to_applications
{
	public function up()
	{
		\DBUtil::add_fields('applications', array(
			'message' => array('type' => 'text', 'null' => true, 'after' => 'payment_method'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('applications', array(
			'message'

		));
	}
}
