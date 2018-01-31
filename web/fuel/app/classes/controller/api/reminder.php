<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\User;
use \Model\UserReminder;

class Controller_Api_Reminder extends Controller_Apibase
{

    public function action_create()
    {
        $val = UserReminder::validate();
        if (!$val->run()) {
            $this->error(array_values($val->error_message()));
        } else {

            try {

                $user = User::getByEmail($val->validated('email'));

                // TokenとメールアドレスをDBに登録
                return $this->ok(UserReminder::create($user['email'], $user['username']));

            } catch (\Exception $e) {
                return $this->error(array('送信に失敗しました。'));
            }
        }
    }

    public function action_reset()
    {
        // トークンチェック
        if (!$reminder = UserReminder::get_valid(\Input::post('access_token'))) {
            return $this->error("トークンが不正です。");
        }
        $val = UserReminder::validate_reset();
        if (!$val->run()) {
            return $this->error(array_values($val->error_message()));
        } else {
            try {
                // TokenとメールアドレスをDBに登録
                return $this->ok(UserReminder::reset($reminder['username'], $val->validated('password')));

            } catch (\Exception $e) {
                return $this->error(array('設定に失敗しました。'));
            }
        }
    }
}
