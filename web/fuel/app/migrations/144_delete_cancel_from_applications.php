<?php

namespace Fuel\Migrations;

class Delete_cancel_from_applications
{
	public function up()
	{
		\DBUtil::drop_fields('applications', array(
			'cancel'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('applications', array(
            'cancel' => array('type' => 'tinyint', 'default' => '0', 'after' => 'email'),

		));
	}
}
