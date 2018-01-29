<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\User;
use \Model\UserReminder;

class Controller_Api_Reminder extends Controller_Base
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
                $this->ok(UserReminder::create($user['email'], $user['username']));

            } catch (\Exception $e) {
                $this->error(array('送信に失敗しました。'));
            }
        }
    }

    public function action_document()
    {
        $this->ok(Regist::document(\Input::all()));
    }


}
