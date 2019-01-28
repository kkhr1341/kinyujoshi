<?php

namespace Fuel\Migrations;

class Create_page_views
{
	public function up()
	{
		\DBUtil::create_table('page_views', array(
			'date' => array('type' => 'timestamp'),
			'page_path' => array('constraint' => 255, 'type' => 'varchar'),
			'pageviews' => array('type' => 'bigint'),

            'view_id' =>array('constraint' => 255, 'type' => 'varchar'),

        ), null, true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('page_views');
	}
}