<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class InsightQuestions extends Base
{
    public static function findById($id)
    {
        return static::getById('insight_questions', $id);
    }

}
