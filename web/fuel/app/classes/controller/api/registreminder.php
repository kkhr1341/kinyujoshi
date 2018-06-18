<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\RegistReminder;

class Controller_Api_Registreminder extends Controller_Apibase
{

    public function action_create()
    {
        // トークンチェック
        if (!$reminder = RegistReminder::get_valid(\Input::post('access_token'))) {
            return $this->error("トークンが不正です。");
        }

        $val = RegistReminder::validate();
        if (!$val->run()) {
            return $this->error(array_values($val->error_message()));
        } else {
            try {

                // TokenとメールアドレスをDBに登録
                return $this->ok(RegistReminder::regist($reminder['member_regist_id'], $val->validated('password')));

            } catch (\Exception $e) {
                echo $e;
                return $this->error(array('設定に失敗しました。'));
            }
        }
    }
}
