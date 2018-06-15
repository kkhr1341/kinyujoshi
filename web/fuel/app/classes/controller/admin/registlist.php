<?php

use \Model\Sections;
use \Model\regist;
use \Model\Registlist;
use \Model\ParticipatedApplications;

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

        $username = Registlist::getUsername($code);
        if ($username) {
            $this->data['participated_events'] = ParticipatedApplications::lists($username);
        } else {
            $this->data['participated_events'] = array();
        }

        $this->data['registel'] = Regist::getByCodeWithurl($code);
        $this->template->contents = View::forge('admin/registlist/detail.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
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
        echo Format::forge($data)->to_csv();

        // Response
        return $response;
    }
}