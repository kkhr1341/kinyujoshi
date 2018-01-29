<?php

use \Model\Wp;

class Controller_My_Payments extends Controller_Mybase
{

	public function action_index() {

		$wp = new Wp();
		$this->data['payments'] = $wp->all(Auth::get('username'));
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・支払い';
    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
		$this->template->contents = View::forge('my/payments/index.smarty', $this->data);
	}

}
