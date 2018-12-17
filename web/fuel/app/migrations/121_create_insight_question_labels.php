<?php

namespace Fuel\Migrations;

class Create_insight_question_labels
{
	public function up()
	{
		\DBUtil::create_table('insight_question_labels', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'insight_question_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'sort' => array('type' => 'float'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'insight_question_labels_ibfk_1',
                    'key' => 'insight_question_id',
                    'reference' => array(
                        'table' => 'insight_questions',
                        'column' => 'id',
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('insight_question_labels');
	}
}