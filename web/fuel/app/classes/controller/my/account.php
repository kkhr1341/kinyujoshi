<?php

use \Model\Profiles;

class Controller_My_Account extends Controller_Mybase
{

  public function action_index() {
    //$this->data['special'] = Profiles::lists(1, 100, true);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->contents = View::forge('my/account/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・プロフィール';
  }
}
