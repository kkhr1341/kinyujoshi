<?php

use \Model\News;

class Controller_News_Detail extends Controller_Base
{

    public function action_index($code = null)
    {
        $this->data['news'] = News::getByCode('news', $code);
        $this->template->contents = View::forge('news/detail.smarty', $this->data);
    }
}
