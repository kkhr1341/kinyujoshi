<?php

use \Model\Companies;

class Controller_Kinyu_Policy extends Controller_Kinyubase
{

	public function action_index() {

		$this->data['company'] = Companies::get();
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/policy/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
	}
}
