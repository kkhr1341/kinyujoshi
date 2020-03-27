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
      array('code' => -1, 'name' => 'Banned'),
      array('code' => 1, 'name' => 'メンバー'),
      array('code' => 30, 'name' => 'オフィシャルメンバー'),
      array('code' => 40, 'name' => 'コミュニティスタッフ'),
      array('code' => 80, 'name' => '管理者')
      array('code' => 100, 'name' => 'スーパー管理者')
    );
    $this->template->contents = View::forge('admin/staffs/edit.smarty', $this->data);
    $this->template->description = '管理画面・スタッフ詳細';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
  }
}
