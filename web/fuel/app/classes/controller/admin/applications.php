<?php

use \Model\Applications;
use \Model\Sections;

class Controller_Admin_Applications extends Controller_Adminbase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->data['sections'] = Sections::lists();
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->template->description = 'マイページ・アプリケーション';
        $this->template->contents = View::forge('admin/applications/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}
