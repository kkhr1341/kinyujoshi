<?php

use \Model\Blogstocks;

class Controller_Api_Blogstocks extends Controller_Base
{
    public function action_create()
    {
        if(Blogstocks::stocked(\Input::all('code'))) {
            $this->error('すでにチェック済みのレポートです');
        }
        $this->ok(Blogstocks::create(\Input::post('code')));
    }

    public function action_delete()
    {
        $this->ok(Blogstocks::delete(\Input::all('code')));
    }
}
