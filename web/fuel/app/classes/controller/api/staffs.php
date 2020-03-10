<?php

use \Model\User;

class Controller_Api_Staffs extends Controller_Base
{
  public function action_save()
  {
    if (!Auth::has_access('staffs.edit')) {
      return $this->error('permission denied');
    }

    $val = User::staff_edit_validate();
    if (!$val->run()) {
      $error_messages = $val->error_message();
      $message = reset($error_messages);
      return $this->error($message);
    }

    try {
      return $this->ok(User::grant_update($val->validated(), \Input::post('user_id')));
    } catch(Exception $e) {
      return $this->error("保存に失敗しました。");
    }
  }
}
