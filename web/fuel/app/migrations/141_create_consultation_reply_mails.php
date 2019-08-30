<?php

namespace Fuel\Migrations;

class Create_consultation_reply_mails
{
	public function up()
	{
		\DBUtil::create_table('consultation_reply_mails', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'consultation_code' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'subject' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'body' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'consultation_reply_mails_ibfk_1',
                    'key' => 'consultation_code',
                    'reference' => array(
                        'table' => 'consultations',
                        'column' => 'code'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('consultation_reply_mails');
	}
}