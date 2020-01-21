<?php

use \Model\Sections;
use \Model\Regist;
use \Model\Registlist;
use \Model\ParticipatedApplications;

class Controller_Admin_Mails extends Controller_Adminbase
{
    public function before()
    {
        parent::before();

        if ($this->is_from_company() == FALSE) {
            throw new HttpNoAccessException;
        }
    }

    public function action_index()
    {
        \Config::load('mails', true);
        \Config::get('mails.templates');
        $this->data['mails'] = \Config::get('mails.templates');
//
//        $params = Input::get();
//        unset($params['page']);

//        // 一般ユーザーのみを対象とする
//        $params['group'] = array(1);
//
//        $this->data['registlist'] = Regist::all('/admin/registlist/?' . http_build_query($params), Input::get('page', 1), 'page', 30, $params);
//        $pagination = $this->data['registlist']['pagination'];

//        $this->data['params'] = array(
//            'username' => Input::get('username', ''),
//            'name' => Input::get('name', ''),
//            'email' => Input::get('email', ''),
//            'introduction' => Input::get('introduction', ''),
//            'edit_inner' => Input::get('edit_inner', ''),
//        );

        $this->template->contents = View::forge('admin/mails/index.smarty', $this->data);
    }

    public function action_detail()
    {
        \Config::load('mails', true);
        $templates = \Config::get('mails.templates');

        $this->template = null;
        $id = Input::get('id');
        $data = $templates[$id];
        $view = 'email/' . $data['view'];
        $this->data = $data['params'];

        $this->data["footer"] = View::forge('parts/email/footer.smarty', $this->data);
        return View::forge($view, $this->data);
    }
}
