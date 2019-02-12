<?php

use \Model\News;
use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_News extends Controller_Kinyubase
{

    const AUTHENTICATION_USER = 'kinyu-news';

    const AUTHENTICATION_PASSWORD = 'iYszQGhE';

    public function action_index($page = 1)
    {
        $this->data['news'] = News::all(null, '/news/', $page, 2, 10);
        $pagination = $this->data['news']['pagination'];
        $this->template->title = 'お知らせ｜きんゆう女子。';
        $this->template->description = "きんゆう女子。のニュースでは、きんゆう女子。に関する様々なニュースを配信しています。";
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
        } else {
        }
        $this->template->contents = View::forge('kinyu/news/index.smarty', $this->data)
            ->set_safe('pagination', $pagination);
    }

    public function action_detail($code)
    {
        $this->data['news'] = News::findByCode($code);
        $this->data['top_events'] = Events::lists(1, 7, true, 0);

        if ($this->data['news'] === false) {
            Response::redirect('error/404');
        }

        if ($this->data['news']['status'] == 0) {

            if ($this->data['news']['authentication_user'] && $this->data['news']['authentication_password']) {
                $authentication_user     = $this->data['news']['authentication_user'];
                $authentication_password = $this->data['news']['authentication_password'];
            } else {
                $authentication_user     = self::AUTHENTICATION_USER;
                $authentication_password = self::AUTHENTICATION_PASSWORD;
            }

            switch (true) {
                case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
                case $_SERVER['PHP_AUTH_USER'] !== $authentication_user:
                case $_SERVER['PHP_AUTH_PW'] !== $authentication_password:
                    header('WWW-Authenticate: Basic realm="Enter username and password."');
                    header('Content-Type: text/plain; charset=utf-8');
                    die('このページを見るにはログインが必要です');
            }
        }

        $this->template->title = $this->data['news']['title'];
        $this->template->description = $this->data['news']['title'];

        if ($this->data['news']['main_image'] == '') {
            $this->template->ogimg = 'https://kinyu-joshi.jp/Zimages/submain.png';
        } else if {
            $this->template->ogimg = $this->data['news']['main_image'];
        }
        $this->data['top_news'] = News::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->detail_news_after = View::forge('kinyu/news/detail_news_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/news/detail.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        $this->template->canonical = \Uri::base() . 'news/' . $this->data['news']['code'];

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->detail_news_after = View::forge('kinyu/news/detail_news_spafter.smarty', $this->data);
        } else {
            $this->template->detail_news_after = View::forge('kinyu/news/detail_news_after.smarty', $this->data);
        }
    }
}