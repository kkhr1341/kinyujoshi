<?php

use \Model\Events;
use \Model\Applications;
use \Model\Sections;
use \Model\EventRemindMailTemplate;
use \Model\EventRemindMailDefaultTemplate;

class Controller_Admin_Remindmailtemplates extends Controller_Adminbase
{

    public function action_index()
    {

        if (!Auth::has_access('events.admin')) {
            \Auth::logout();
            Response::redirect('/');
            exit();
        }
        $this->data['open_events'] = Events::lists(1, null, null, null, "asc");

        $this->template->contents = View::forge('admin/remindmailtemplates/index.smarty', $this->data);
    }

    public function action_edit($code)
    {

        if (!Auth::has_access('events.admin')) {
            \Auth::logout();
            Response::redirect('/');
            exit();
        }

        $this->data['events'] = Events::getByCode('events', $code);

        if ($event_remind_mail_template = EventRemindMailTemplate::getByEventCode($code)) {
            $this->data['event_remind_mail_template'] = $event_remind_mail_template;
        } else {
            $this->data['event_remind_mail_template'] = EventRemindMailDefaultTemplate::getDefault();
        }

        $this->template->contents = View::forge('admin/remindmailtemplates/edit.smarty', $this->data);
    }
}
