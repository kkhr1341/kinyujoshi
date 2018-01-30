<?php
use \Model\Profiles;

class Controller_Api_Profiles extends Controller_Base
{
    public function action_save()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            $this->ok('login');
        }

        $res = Profiles::save(\Input::all());
        if (is_string($res)) {
            $this->error($res);
        }

        $this->ok();
    }
}
