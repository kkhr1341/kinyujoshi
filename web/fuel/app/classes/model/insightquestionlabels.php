<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class InsightQuestionLabels extends Base
{
    public static function lists($insight_question_id)
    {
        return\DB::select(\DB::expr('insight_question_labels.*'))
            ->from('insight_question_labels')
            ->where('insight_question_id', '=', $insight_question_id)
            ->order_by('insight_question_labels.sort', 'asc')
            ->execute()
            ->as_array();
    }
}
