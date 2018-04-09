<?php

namespace Fuel\Migrations;

class Create_event_remind_mail_templates
{
	public function up()
	{
		\DBUtil::create_table('event_remind_mail_templates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'event_code' => array('constraint' => 50, 'type' => 'varchar'),
			'subject' => array('constraint' => 255, 'type' => 'varchar'),
			'body' => array('type' => 'text'),
			'created_at' => array('type' => 'datetime'),
                        'updated_at' => array('type' => 'timestamp')
                ), array('id'), true, 'InnoDB', null,
                    array(
                        array(
                            'constraint' => 'event_remind_mail_templates_ibfk_1',
                            'key' => 'event_code',
                            'reference' => array(
                                'table' => 'events',
                                'column' => 'code'
                            )
                        ),
                    )
                );
                \DBUtil::create_index('event_remind_mail_templates', array('event_code'), 'event_remind_mail_templates_ibuk_1', 'UNIQUE');
	}

	public function down()
	{
		\DBUtil::drop_table('event_remind_mail_templates');
	}
}
