<?php

use \Model\Applicationcreditpayment;

class Controller_Api_Applicationpayments extends Controller_Apibase
{
    public function action_sale()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            Applicationcreditpayment::sale(\Input::post('code'));
            return $this->ok('売り上げ処理成功');
        } catch (\Exception $e) {
            return $this->error('売り上げ処理に失敗しました');
        }
    }
}
