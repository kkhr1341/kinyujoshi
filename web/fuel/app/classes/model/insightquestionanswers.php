<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class InsightQuestionAnswers extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('insight_question_label_id')
            ->add_rule('required');

        return $val;
    }

    public static function create($params)
    {
        \DB::insert('insight_question_answers')->set(array(
            'insight_question_label_id' => $params['insight_question_label_id'],
            'username' => $params['username'],
            'created_at' => \DB::expr('now()'),
        ))->execute();
    }
}
