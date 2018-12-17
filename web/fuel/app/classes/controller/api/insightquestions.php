<?php

use \Model\InsightQuestionAnswers;

class Controller_Api_Insightquestions extends Controller_Apibase
{
    public function post_create()
    {
        try {
            $val = InsightQuestionAnswers::validate();
            if (!$val->run()) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }

            $params = $val->validated();
            $params['username'] = Auth::get('username');
            InsightQuestionAnswers::create($params);
            return $this->ok();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
