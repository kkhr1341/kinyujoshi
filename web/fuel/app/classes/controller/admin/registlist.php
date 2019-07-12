<?php

use \Model\Sections;
use \Model\Regist;
use \Model\Registlist;
use \Model\ParticipatedApplications;
use \Model\UserRegistTriggers;

class Controller_Admin_Registlist extends Controller_Adminbase
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
        if (!Auth::has_access('registlist.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();

        $params = Input::get();
        unset($params['page']);

        // 一般ユーザーのみを対象とする
        $params['group'] = array(1, 40);

        $this->data['registlist'] = Regist::all('/admin/registlist/?' . http_build_query($params), Input::get('page', 1), 'page', 30, $params);
        $pagination = $this->data['registlist']['pagination'];

        $this->data['params'] = array(
            'username' => Input::get('username', ''),
            'name' => Input::get('name', ''),
            'email' => Input::get('email', ''),
            'introduction' => Input::get('introduction', ''),
            'edit_inner' => Input::get('edit_inner', ''),
        );

        $this->template->total = $this->data['registlist']['total'];
        $this->template->contents = View::forge('admin/registlist/registlist.smarty', $this->data);
        $this->template->contents->set_safe('pagination', $pagination);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_detail($code)
    {
        if (!Auth::has_access('registlist.read') || !$this->is_from_company()) {
            throw new HttpNoAccessException;
        }

        $this->data['registlist'] = Regist::lists();

        $username = Registlist::getUsername($code);
        if ($username) {
            $this->data['participated_events'] = ParticipatedApplications::lists($username);
            $this->data['regist_triggers'] = UserRegistTriggers::lists($username);
        } else {
            $this->data['participated_events'] = array();
            $this->data['regist_triggers'] = array();
        }

        $this->data['registel'] = Regist::getByCodeWithurl($code);
        $this->template->contents = View::forge('admin/registlist/detail.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('registlist.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
        $this->data['registlist'] = Regist::lists();
        $this->template->contents = View::forge('admin/registlist/create.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_memberlist()
    {
        if (!Auth::has_access('registlist.read') || !$this->is_from_company()) {
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

        $registlist = Regist::lists(1);

        $data = array();
        $data[] = array(
            "登録日",
            "名前",
            "会員ID",
            "診断チャートタイプ",
            "かな",
            "Email",
            "年齢",
            "都道府県",
            "きんゆうワカラナイ度",
            "どこで、きんゆう女子。を知りましたか？",
            "きんゆう女子。で情報発信したいですか？",
            "金融機関で働いていたり、仕事上金融に関わっていますか？",
            "きんゆう女子。コミュニティではどんな発見や出会いがほしい？",
            "きんゆう女子。コミュニティで何を学んだり知りたい？",
            "メンバーになろうと思ったきっかけ",
            "金融に向き合い学び、3年後には何がほしいですか？",
            "個人で発信しているブログやSNSなど",
            "パス設定有",
            "自己紹介",
            "編集部記入欄",
            "削除フラグ",
            "参加女子会",
        );

        foreach ($registlist as $application) {

            if ($application["age"] > 1000) {
                $application["birthday"] = floor((date('Ymd') - (str_replace("-", "", $application["age"])))/10000);
            } elseif ($application["age"] < 1000) {
                $application["birthday"] = floor((date('Ymd') - (str_replace("-", "", $application["age"])))/10000);
            } else {
                $application["birthday"] = $application["age"];
            }

            // 過去に参加した女子会
            $prev_applications = ParticipatedApplications::lists($application["username"]);
            $prev_applications_str = '';
            foreach($prev_applications as $prev_application) {
                $prev_applications_str .= date('Y年m月d日', strtotime($prev_application['event_date'])) . ' ' . $prev_application['title'] . "\n";
            }

            $data[] = array(
                $application["created_at"],
                $application["name"],
                $application["username"],
                $application["type"],
                $application["name_kana"],
                $application["email"],
                $application["birthday"],
                $application["prefecture_name"],
                $application["not_know"],
                $application["where_from"],
                $application["transmission"],
                $application["job_kind"],
                $application["user_want_to_meet_values"],
                $application["user_want_to_learn_values"],
                $application["user_regist_trigger_values"],
                $application["future"],
                $application["url"],
                $application["username"] ? '○': '',
                $application["introduction"],
                $application["edit_inner"],
                $application["disable"] == 0 ? '○': '',
                $prev_applications_str,
            );
        }
        // CSVを出力
        $csv = Format::forge($data)->to_csv();
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        echo $csv;

        // Response
        return $response;
    }
}
