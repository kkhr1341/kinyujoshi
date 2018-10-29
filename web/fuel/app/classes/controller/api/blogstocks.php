<?php

use \Model\Blogstocks;

class Controller_Api_Blogstocks extends Controller_Base
{
    public function action_create()
    {
        $username = \Auth::get('username');
        if(Blogstocks::stocked(\Input::all('code'), $username)) {
            $this->error('すでにチェック済みのレポートです');
        }
        $this->ok(Blogstocks::create(\Input::post('code'), $username));
    }

    public function action_delete()
    {
        $username = \Auth::get('username');
        $this->ok(Blogstocks::delete(\Input::all('code'), $username));
    }
}
