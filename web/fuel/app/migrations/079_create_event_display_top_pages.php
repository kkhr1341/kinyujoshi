<?php

namespace Fuel\Migrations;

class Create_event_display_top_pages
{
	public function up()
	{
		\DBUtil::create_table('event_display_top_pages', array(
            'event_code' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), null, true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'event_display_top_pages_ibfk_1',
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
		\DBUtil::drop_table('event_display_top_pages');
	}
}
