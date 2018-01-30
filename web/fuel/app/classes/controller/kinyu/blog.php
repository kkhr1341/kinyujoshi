<?php

use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_Blog extends Controller_Kinyubase
{

    public function action_index($page = 1)
    {

        if (Agent::is_mobiledevice()) {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 30);
        } else {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 60);
        }
        $pagination = $this->data['blogs']['pagination'];
        $this->template->title = '記事一覧｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、なかなか聞けないお金の話。 先延ばしにしがちなお金の計画。 私には無関係と思っている金融の話など、お金に関する様々な情報を配信しています。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

        $this->data['top_blogs'] = Blogs::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
        $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/blog/index.smarty', $this->data)
            ->set_safe('pagination', $pagination);
    }

    public function action_detail($code)
    {
        // 最新を取得
        $this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
        $this->data['blog'] = Blogs::getByCodeWithProfile($code);
        $this->data['top_events'] = Events::lists(1, 7, true);

        if ($this->data['blog'] === false) {
            Response::redirect('error/404');
        }

        if ($this->data['blog']['status'] == 0) {
            $iddate = $this->data['blog']['code'];
            switch (true) {
                case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
                case $_SERVER['PHP_AUTH_USER'] !== 'kinyu-report':
                case $_SERVER['PHP_AUTH_PW'] !== 'iYszQGhE':
                    header('WWW-Authenticate: Basic realm="Enter username and password."');
                    header('Content-Type: text/plain; charset=utf-8');
                    die('このページを見るにはログインが必要です');
            }
        }

        $this->template->title = $this->data['blog']['title'];
        $this->template->description = $this->data['blog']['description'];
        $this->template->ogimg = $this->data['blog']['main_image'];
        //template
        $this->data['top_blogs'] = Blogs::lists(1, 6, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if ($this->data['blog']['kind'] == "わたしを知る") {
            $this->template->contents = View::forge('kinyu/blog/detail_myway.smarty', $this->data);
        } else {
            $this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
        }

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_spafter.smarty', $this->data);
        } else {
            $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_after.smarty', $this->data);
        }
    }
}