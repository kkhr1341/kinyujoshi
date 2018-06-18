<?php

use \Model\Events;
use \Model\EventDisplayTopPages;
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
        $this->data['past_events'] = Events::lists02();
        $this->data['closed_events'] = Events::lists(0, null, null, null, "desc", null);
        $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
        $this->data['all_events'] = Events::lists03();
        $this->data['display_top_event'] = EventDisplayTopPages::get();
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
        $this->data['past'] = Events::isPast($code);
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
        $this->data['all_events'] = Events::lists02(null, null, null, null, null, null, "desc");
       //  $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1, null, null, null, "desc", null);
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

    public function action_memberlist($code)
    {
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
            "参加回数"
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
