<?php

use \Model\Events;
use \Model\Applications;
use \Model\Sections;

class Controller_Admin_Events extends Controller_Adminbase
{

    public function action_index()
    {

        if (!Auth::has_access('events.admin')) {
            \Auth::logout();
            Response::redirect('/');
            exit();
        }

        $this->data['sections'] = Sections::lists();
        $this->data['all_events'] = Events::lists02();
        $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/index.smarty', $this->data);
    }

    public function action_create()
    {

        if (!Auth::has_access('events.admin')) {
            \Auth::logout();
            Response::redirect('/');
            exit();
        }

        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/create.smarty', $this->data);
    }

    public function action_edit($code)
    {

        if (!Auth::has_access('events.admin')) {
            \Auth::logout();
            Response::redirect('/');
            exit();
        }

        $this->data['events'] = Events::getByCode('events', $code);
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/edit.smarty', $this->data);
    }

    public function action_attend()
    {

        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        // $this->data['events'] = Events::lists(1, 50, true);
        // $this->data['sections'] = Sections::lists();
        $this->data['all_events'] = Events::lists02();
       //  $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend.smarty', $this->data);
    }

    public function action_attend_detail($code)
    {
        $this->data['events'] = Events::getByCode('events', $code);
        $this->data['applications'] = Applications::get_applications_by_code($code);
        $this->data['cancel_applications'] = Applications::get_cancel_applications_by_code($code);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend_detail.smarty', $this->data);
    }

}
