<?php

use \Model\News;

class Controller_News_Top extends Controller_Base
{

	public function action_index($code = null) {
		
		$this->data['news'] = News::lists(1, 100, true);
		$this->template->contents = View::forge('news/index.smarty', $this->data);
	}
}
