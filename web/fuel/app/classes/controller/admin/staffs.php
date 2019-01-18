<?php

use \Model\User;

class Controller_Admin_Staffs extends Controller_Adminbase
{
    public function before()
    {
        parent::before();

        if ($this->is_from_company() == FALSE) {
            throw new HttpNoAccessException;
        }
    }

    public function action_index()
    {
        if (!in_array('admin', $this->data['roles'])) {
            throw new HttpNoAccessException;
        }

        $this->data['staffs'] = User::staff_list();

        $this->template->contents = View::forge('admin/staffs/index.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}
