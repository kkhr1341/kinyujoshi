<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Registlist;
use \Model\Userwithdrawal;

class Controller_Api_Registlist extends Controller_Apibase
{

    public function action_create()
    {
        $val = Registlist::validate();
        if (!$val->run(\Input::post())) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        return $this->ok(Registlist::create(\Input::post()));
    }

    public function action_save()
    {
        $username = Registlist::getUsername(\Input::post('code'));
        $val = Registlist::validate($username);
        if (!$val->run(\Input::post())) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        return $this->ok(Registlist::save(\Input::post()));
    }

    public function action_delete()
    {
        // パスワード設定済みのユーザー
        if($username = Registlist::getUsername(\Input::all('code'))) {
            Userwithdrawal::deleteUser($username);
            return $this->ok();
        } else {
            // パスワード未設定済みのユーザー
            return $this->ok(Registlist::delete(\Input::all()));
        }
    }
}
