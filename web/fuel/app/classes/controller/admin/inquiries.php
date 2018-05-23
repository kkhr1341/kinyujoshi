<?php

use \Model\Inquiries;

class Controller_Admin_Inquiries extends Controller_Adminbase
{

    public function action_index()
    {
        $this->data['inquiries'] = Inquiries::lists();
        $this->template->contents = View::forge('admin/inquiries/index.smarty', $this->data);
        $this->template->description = '';
    }
}
