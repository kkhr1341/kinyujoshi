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
    if (!in_array('super_admin', $this->data['roles'])) {
      throw new HttpNoAccessException;
    }

    $this->data['staffs'] = User::staff_list();

    $this->template->contents = View::forge('admin/staffs/index.smarty', $this->data);
    $this->template->description = 'マイページ・ブログ';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
  }

  public function action_edit($user_id)
  {
    if (!Auth::has_access('staffs.edit')) {
      throw new HttpNoAccessException;
    }

    $this->data['staff'] = User::staff_detail($user_id);
    $this->data['grants'] = array(
      array('code' => 1, 'name' => '権限LV.6'),
      array('code' => 2, 'name' => '権限LV.5'),
      array('code' => 42, 'name' => '権限LV.4'),
      array('code' => 41, 'name' => '権限LV.3'),
      array('code' => 40, 'name' => '権限LV.2'),
      array('code' => 100, 'name' => '権限LV.1'),
      array('code' => 80, 'name' => '管理者（削除）'),
      array('code' => -1, 'name' => 'Banned（削除）'),
      array('code' => 30, 'name' => '（旧）オフィシャルメンバー（削除）')
    );
    $this->template->contents = View::forge('admin/staffs/edit.smarty', $this->data);
    $this->template->description = '管理画面・スタッフ詳細';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
  }
}
