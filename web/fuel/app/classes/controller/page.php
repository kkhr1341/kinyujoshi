<?php

use \Model\Pages;

class Controller_Page extends Controller_Base
{

	public function action_top($code) {
		$this->data['page'] = Pages::getByCode('pages', $code);
		$this->template->contents = View::forge('mono/page/index.smarty', $this->data);
	}
}
