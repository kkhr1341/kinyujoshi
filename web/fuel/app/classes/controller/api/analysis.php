<?php

use \Model\Registlist;

class Controller_Api_Analysis extends Controller_Base
{

    public function before()
    {
        parent::before();

        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }
    }

    /**
     * ログイン
     */
    public function action_member()
    {
        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }

        $this->ok(Registlist::member_attribute());
    }
}