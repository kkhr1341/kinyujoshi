<?php

namespace Fuel\Migrations;

class Create_insight_questions
{
	public function up()
	{
		\DBUtil::create_table('insight_questions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'expires' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('insight_questions');
	}
}