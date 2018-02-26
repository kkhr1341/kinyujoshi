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
        $val = Profiles::validate(Auth::get('username'));
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $params = $val->validated();
        $res = Profiles::save($params);
        if (is_string($res)) {
            return $this->error($res);
        }

        return $this->ok();
    }
}
