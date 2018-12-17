<?php

namespace Fuel\Migrations;

class Create_insight_question_answers
{
    public function up()
    {
        \DBUtil::create_table('insight_question_answers', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'insight_question_label_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'username' => array('constraint' => 50, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'insight_question_answers_ibfk_1',
                    'key' => 'insight_question_label_id',
                    'reference' => array(
                        'table' => 'insight_question_labels',
                        'column' => 'id',
                    )
                ),
            )
        );
    }

    public function down()
    {
        \DBUtil::drop_table('insight_question_answers');
    }
}