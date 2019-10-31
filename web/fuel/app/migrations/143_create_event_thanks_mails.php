<?php

namespace Fuel\Migrations;

class Create_event_thanks_mails
{
	public function up()
	{
		\DBUtil::create_table('event_thanks_mails', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'application_code' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp')
		), array('id'), true, 'InnoDB', null,
                    array(
                        array(
                            'constraint' => 'event_thanks_mails_ibfk_1',
                            'key' => 'application_code',
                            'reference' => array(
                                'table' => 'applications',
                                'column' => 'code'
                            )
                        ),
                    )
                );
                \DBUtil::create_index('event_thanks_mails', array('application_code'), 'event_thanks_mails_ibuk_1', 'UNIQUE');
	}

	public function down()
	{
		\DBUtil::drop_table('event_thanks_mails');
	}
}
