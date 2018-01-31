<?php
use \Model\Profiles;

class Controller_Api_Profiles extends Controller_Apibase
{
    public function action_save()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }

        $res = Profiles::save(\Input::all());
        if (is_string($res)) {
            return $this->error($res);
        }

        return $this->ok();
    }
}
