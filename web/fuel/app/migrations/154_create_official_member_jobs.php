<?php

namespace Fuel\Migrations;

class Create_official_member_jobs
{
	public function up()
	{
		\DBUtil::create_table('official_member_jobs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 200, 'type' => 'varchar'),
			'disable' => array('type' => 'tinyint', 'default' => '0'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
    }

	public function down()
	{
		\DBUtil::drop_table('official_member_jobs');
	}
}
