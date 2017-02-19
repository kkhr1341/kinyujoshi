<?php

use \Model\News;

class Controller_Top extends Controller_Base
{
	
	/**
	 * トップ画面表示
	 */
	public function action_index() {

		$this->data['news'] = News::lists(1, 5, true);
		$this->template->contents = View::forge('top/index.smarty', $this->data);
	}

}
