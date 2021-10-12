<?php

use \Model\Events;
use \Model\EventCoupons;
use \Model\EventDisplayTopPages;
use \Model\Applications;
use \Model\Sections;
use \Model\EventRemindMailTemplates;
use \Model\EventThanksMailTemplates;

class Controller_Admin_Events extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();

        $username = \Auth::get('username');

        // 41: 権限LV.3
        if (Auth::member(41)) {
            // OMC権限（LV.3）は自分の書いた記事のみ表示
            $this->data['past_events'] = Events::lists02(null, null, null, null, null, null, "desc", $username);
            $this->data['closed_events'] = Events::lists(0, null, null, null, "desc", null, $username);
            $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null, $username);
            $this->data['all_events'] = Events::lists03($username);
            $this->data['display_top_event'] = array();
        } else {
            $this->data['past_events'] = Events::lists02(null, null, null, null, null, null, "desc");
            $this->data['closed_events'] = Events::lists(0, null, null, null, "desc", null);
            $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
            $this->data['all_events'] = Events::lists03();
            $this->data['display_top_event'] = EventDisplayTopPages::get();
        }

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/index.smarty', $this->data);
    }

    public function action_create()
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();

        $this->data['remind_mail_template'] = array(
            'status' => 0,
            'subject' => EventRemindMailTemplates::getDefaultSubject(),
            'body' => EventRemindMailTemplates::getDefaultBody(),
        );

        $this->data['thanks_mail_template'] = array(
            'status' => 0,
            'subject' => EventThanksMailTemplates::getDefaultSubject(),
            'body' => EventThanksMailTemplates::getDefaultBody(),
        );

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';

        $this->data['events']['content'] = Events::getDefaultContent();

        $this->template->contents = View::forge('admin/events/edit.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('events.read')) {
            throw new HttpNoAccessException;
        }

        $this->data['events'] = Events::getByCode('events', $code);

        $username = \Auth::get('username');

        // 41: 権限LV.3
        // OMC権限（LV.3）は自分の書いた記事のみ表示
        if (Auth::member(41) && $this->data['events']['username'] != $username) {
            throw new HttpNoAccessException;
        }

        $this->data['past'] = Events::isPast($code);
        $this->data['sections'] = Sections::lists();

        if ($event_remind_mail_template = EventRemindMailTemplates::getByEventCode($code)) {
            $this->data['remind_mail_template'] = $event_remind_mail_template;
        } else {
            $this->data['remind_mail_template'] = array(
                'status' => 0,
                'subject' => EventRemindMailTemplates::getDefaultSubject(),
                'body' => EventRemindMailTemplates::getDefaultBody(),
            );
        }

        if ($event_thank_mail_template = EventThanksMailTemplates::getByEventCode($code)) {
            $this->data['thanks_mail_template'] = $event_thank_mail_template;
        } else {
            $this->data['thanks_mail_template'] = array(
                'status' => 0,
                'subject' => EventThanksMailTemplates::getDefaultSubject(),
                'body' => EventThanksMailTemplates::getDefaultBody(),
            );
        }

        // 将来的に複数登録できるようにしたいが今はとりあえず1個だけしか登録できない仕様
        $this->data['coupons'] = EventCoupons::getRowsByEventCode($code);

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・イベント';
        $this->template->contents = View::forge('admin/events/edit.smarty', $this->data);
    }

    public function action_attend()
    {
        if (!Auth::has_access('applications.read')) {
            throw new HttpNoAccessException;
        }
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);

        $username = \Auth::get('username');

        // 41: 権限LV.3
        if (Auth::member(41)) {
            $this->data['all_events'] = Events::lists02(null, null, null, null, null, null, "desc", $username);
            $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null, $username);
        } else {
            $this->data['all_events'] = Events::lists02(null, null, null, null, null, null, "desc");
            $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
        }

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend.smarty', $this->data);
    }

    public function action_attend_detail($code)
    {
        if (!Auth::has_access('applications.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['events'] = Events::getByCode('events', $code);

        $username = \Auth::get('username');

        // 41: 権限LV.3
        // OMC権限（LV.3）は自分の書いた記事のみ表示
        if (Auth::member(41) && $this->data['events']['username'] != $username) {
            throw new HttpNoAccessException;
        }

        $this->data['applications'] = Applications::get_applications_by_code($code);
        $this->data['cancel_applications'] = Applications::get_cancel_applications_by_code($code);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->contents = View::forge('admin/events/attend_detail.smarty', $this->data);
    }

    public function action_memberlist($code)
    {
        if (!Auth::has_access('applications.read') || !$this->is_from_company()) {
            throw new HttpNoAccessException;
        }
        $events = Events::getByCode('events', $code);

        $username = \Auth::get('username');

        // 41: 権限LV.3
        // OMC権限（LV.3）は自分の書いた記事のみ表示
        if (Auth::member(41) && $events['username'] != $username) {
            throw new HttpNoAccessException;
        }

        $csv_name = Date("Y-m-d") . '.csv';
        $response = new Response();

        // content-type: csv
        $response->set_header('Content-Type', 'application/csv');

        // ファイル名をセット
        $response->set_header('Content-Disposition', 'attachment; filename="'. $csv_name .'"');

        // キャッシュをなしに
        $response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response->set_header('Pragma', 'no-cache');

        $applications = \Model\Applications::get_applications_by_code($code);


        $data = array();
        $data[] = array(
            "名前",
            "年齢",
            "ワカラナイド",
            "参加回数",
            "メールアドレス",
        );
        foreach ($applications as $application) {

            if ($application["birthday"] && $application["birthday"] != '0000-00-00') {
                $application["birthday"] = floor((date('Ymd') - (str_replace("-", "", $application["birthday"])))/10000);
            } else {
                $application["birthday"] = "";
            }

            if ($application["application_count"] > 0) {
                $application["application_count"]--;
            }

            $data[] = array(
                $application["name"],
                $application["birthday"],
                $application["not_know"],
                $application["application_count"],
                $application["email"],
            );
        }

        // 名前、年齢, 分からないど, 女子会参加回数

        // CSVを出力
        $csv = Format::forge($data)->to_csv();
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        echo $csv;

        // Response
        return $response;
    }
}
