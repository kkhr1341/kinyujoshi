<?php

namespace Fuel\Migrations;

class Create_event_remind_mail_default_templates
{
	public function up()
	{
		\DBUtil::create_table('event_remind_mail_default_templates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
                        'subject' => array('constraint' => 255, 'type' => 'varchar'),
			'body' => array('type' => 'text'),
			'created_at' => array('type' => 'datetime'),
                        'updated_at' => array('type' => 'timestamp'),
		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('event_remind_mail_default_templates');
	}
}
