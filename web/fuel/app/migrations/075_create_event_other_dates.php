<?php

namespace Fuel\Migrations;

class Create_event_other_dates
{
	public function up()
	{
		\DBUtil::create_table('event_other_dates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'event_code' => array('constraint' => 50, 'type' => 'varchar'),
            'event_date' => array('type' => 'datetime', 'null' => true),
            'event_start_datetime' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'event_end_datetime' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'event_other_dates_ibfk_1',
                    'key' => 'event_code',
                    'reference' => array(
                        'table' => 'events',
                        'column' => 'code'
                    )
                ),
            )
        );
    }

	public function down()
	{
		\DBUtil::drop_table('event_other_dates');
	}
}
