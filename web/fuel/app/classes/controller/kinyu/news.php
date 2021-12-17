<?php

use \Model\News;
use \Model\Blogs;
use \Model\Blogstocks;
use \Model\Events;
use \Model\Authors;
use \Model\User;

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

        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        } else {
        }
        $this->template->contents = View::forge('kinyu/news/index.smarty', $this->data)
            ->set_safe('pagination', $pagination);
    }

    const EVENT_DISPLAY_LIMIT = 6;

    public function action_detail($code)
    {
        $this->data['news'] = News::findByCode($code);
        $this->data['top_events'] = Events::lists(1, 7, true, 0);

        $this->data['event_display_limit'] = self::EVENT_DISPLAY_LIMIT;
        $this->data['events'] = Events::lists(1, null, true, null, 'asc');

        $this->data['top_blogs02'] = Blogs::lists02(1, 5, true);
        
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
            // Basic認証
            $this->set_basic_auth($authentication_user, $authentication_password);

            $this->data['viewable'] = true;
        }

        $this->template->title = $this->data['news']['title'];
        $this->template->description = $this->data['news']['title'];


        //$this->template->ogimg = $this->data['news']['main_image'];

        if ($this->data['news']['main_image'] == '') {
            $this->template->ogimg = 'https://kinyu-joshi.jp/images/submain.png';
        } else {
            $this->template->ogimg = $this->data['news']['main_image'];
        } 

        $this->data['top_news'] = News::lists(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/news/detail.smarty', $this->data);
        $this->template->sidebar = View::forge('kinyu/news/side.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->canonical = \Uri::base() . 'news/' . $this->data['news']['code'];

    }
}