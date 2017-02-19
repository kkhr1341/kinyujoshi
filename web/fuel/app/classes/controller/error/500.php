<?php

class Controller_Error_500 extends Controller_Kinyubase
{

	public function action_index($e) {

		print_r($e);
		$this->template->contents = View::forge('kinyu/error/500.smarty', $this->data);
	}
}
