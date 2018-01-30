<?php

use \Model\Sections;
use \Model\regist;

class Controller_Admin_Registlist extends Controller_Adminbase
{

    public function action_create()
    {
        $this->data['sections'] = Sections::lists();
        $this->data['registlist'] = Regist::lists();
        $this->template->contents = View::forge('admin/registlist/create.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_index()
    {

        $this->data['sections'] = Sections::lists();
        $this->data['registlist'] = Regist::lists();
        //print_r($this->data['registlist']);
        $this->template->contents = View::forge('admin/registlist/registlist.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        //$this->template->diary_bottom = View::forge('fitthelocal/triparea/template/hawaii_bottom.smarty', $this->data);
    }

    public function action_detail($code)
    {
        $this->data['registlist'] = Regist::lists();
        $this->data['registel'] = Regist::getByCodeWithurl($code);
        $this->template->contents = View::forge('admin/registlist/detail.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}