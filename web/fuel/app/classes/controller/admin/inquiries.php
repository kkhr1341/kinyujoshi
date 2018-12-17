<?php

use \Model\Inquiries;

class Controller_Admin_Inquiries extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('inquiries.read') || !$this->is_from_company()) {
            throw new HttpNoAccessException;
        }
        $this->data['inquiries'] = Inquiries::lists();
        $this->template->contents = View::forge('admin/inquiries/index.smarty', $this->data);
        $this->template->description = '';
    }
}
