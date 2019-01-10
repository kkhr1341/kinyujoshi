<?php

use \Model\BusinessInquiries;

class Controller_Api_Businessinquiries extends Controller_Apibase
{
    public function action_create()
    {
        $val = BusinessInquiries::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(BusinessInquiries::create($val->validated()));
        } catch(Exception $e) {
            var_dump($e->getMessage());
            return $this->error("保存に失敗しました。");
        }
    }
}
