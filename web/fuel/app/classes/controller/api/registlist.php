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
        return $this->ok(Registlist::create(\Input::all()));
    }

    public function action_save()
    {
        return $this->ok(Registlist::save(\Input::all()));
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
