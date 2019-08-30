<?php

use \Model\Consultations;

class Controller_Admin_Consultations extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('consultations.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['consultations'] = Consultations::lists();
        $this->template->contents = View::forge('admin/consultations/index.smarty', $this->data);
        $this->template->description = '';
    }
}
