<?php

namespace Fuel\Migrations;

class Drop_event_remind_mail_default_templates
{
	public function up()
	{
        \DBUtil::drop_table('event_remind_mail_default_templates');
	}

	public function down()
	{
        \DBUtil::create_table('event_remind_mail_default_templates', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'subject' => array('constraint' => 255, 'type' => 'varchar'),
            'body' => array('type' => 'text'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null);
	}
}
