<?php

use \Model\BusinessInquiries;

class Controller_Api_Businessinquiries extends Controller_Apibase
{
    public function action_create()
    {
//        $config = array(
//            'max_size'    => 1,
//        );
//        // $_FILES 内のアップロードされたファイルを処理する
//        Upload::process($config);

        if (Upload::get_errors()) {
            return $this->error("添付ファイルのアップロードでエラーが発生しました");
        }
        $val = BusinessInquiries::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(BusinessInquiries::create($val->validated(), Upload::get_files()));
        } catch(Exception $e) {
            var_dump($e->getMessage());
            return $this->error("保存に失敗しました。");
        }
    }
}
