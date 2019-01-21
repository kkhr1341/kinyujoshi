<?php

use \Model\BusinessInquiries;

class Controller_Api_Businessinquiries extends Controller_Apibase
{
    public function action_create()
    {
        if  (count($_FILES)){

            $config = array(
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png', 'pdf'),
            );
            // $_FILES 内のアップロードされたファイルを処理する
            Upload::process($config);

            if ($errors = Upload::get_errors()) {
                return $this->error(Upload::get_errors()[0]['errors'][0]['message']);
            }
            $files = Upload::get_files();
        } else {
            $files = array();
        }

        $val = BusinessInquiries::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(BusinessInquiries::create($val->validated(), $files));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }
}
