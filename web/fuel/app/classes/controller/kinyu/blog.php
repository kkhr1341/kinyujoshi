<?php

use \Model\Blogs;
use \Model\Blogstocks;
use \Model\Events;
use \Model\Authors;
use \Model\User;

class Controller_Kinyu_Blog extends Controller_Kinyubase
{

    const AUTHENTICATION_USER = 'kinyu-report';

    const AUTHENTICATION_PASSWORD = 'iYszQGhE';

    public function action_index($page = 1)
    {

        if (Agent::is_mobiledevice()) {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 30, null, null);
        } else {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 60, null, null);
        }

        foreach($this->data['blogs']['datas'] as &$blogs) {
          $blogs['viewable'] = $this->viewable($blogs['code']);
        }
        unset($blogs);

        $pagination = $this->data['blogs']['pagination'];
        $this->template->title = 'レポート一覧｜きんゆう女子。';
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

        Asset::css(array('kinyu/font-awesome.min.css',), array(), 'layout', false);
    }

    public function action_search($page = 1)
    {

        if (Agent::is_mobiledevice()) {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/search?search_text=' . Input::get('search_text'), Input::get('page', 1), 'page', 30, Input::get('search_text'), null);
        } else {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/search?search_text=' . Input::get('search_text'), Input::get('page', 1), 'page', 60, Input::get('search_text'), null);
        }
        $pagination = $this->data['blogs']['pagination'];
        $this->template->search_text = Input::get('search_text');
        $this->template->title = Input::get('search_text') . 'を含むレポート｜きんゆう女子。';
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
        $this->template->contents = View::forge('kinyu/blog/search.smarty', $this->data)
            ->set_safe('pagination', $pagination);

        Asset::css(array('kinyu/font-awesome.min.css',), array(), 'layout', false);
    }

    public function action_detail($code)
    {
        // 最新を取得
        $this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
        $this->data['blog'] = Blogs::getByCodeWithProfile($code);

        $this->data['posted_me'] = false;
        if ($this->data['blog']['author_code']) {
            $author = Authors::getByCode('authors', $this->data['blog']['author_code']);
            $this->data['author_info'] = $author;
            $this->data['posted_me'] = \Auth::get('username') === $author["username"];
            $this->template->author = View::forge('kinyu/common/author.smarty', $author);
        } else {
            $this->template->author = '';
        }

        $username = \Auth::get('username');
        $this->data['stocked'] = Blogstocks::stocked($code, $username);
        $this->data['viewable'] = $this->viewable($code);
        $this->data['top_events'] = Events::lists(1, 7, true, false);

        if ($this->data['blog'] === false) {
            Response::redirect('error/404');
        }

        if ($this->data['blog']['status'] == 0) {

            if ($this->data['blog']['authentication_user'] && $this->data['blog']['authentication_password']) {
                $authentication_user     = $this->data['blog']['authentication_user'];
                $authentication_password = $this->data['blog']['authentication_password'];
            } else {
                $authentication_user     = self::AUTHENTICATION_USER;
                $authentication_password = self::AUTHENTICATION_PASSWORD;
            }

            // Basic認証
            $this->set_basic_auth($authentication_user, $authentication_password);
        }

        $this->template->title = $this->data['blog']['title'];
        $this->template->description = $this->data['blog']['description'];
        $this->template->ogimg = $this->data['blog']['main_image'];
        //template
        $this->data['top_blogs'] = Blogs::lists(1, 6, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->data['after_login_url'] = \Uri::base() . 'report/' . $this->data['blog']['code'];

        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data + array(
          'title'       => $this->data['blog']['title'],
          'author_code' => $this->data['blog']['author_code'],
          'posted_me'   => $this->data['posted_me']
        ));
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if ($this->data['blog']['kind'] == "わたしを知る") {
            $this->template->contents = View::forge('kinyu/blog/detail_myway.smarty', $this->data);
        } else {
            $this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
        }

        $meta = array(
            array(
                'name' => 'description',
                'content' => $this->data['blog']['description'],
            ),
            array(
                'property' => 'og:locale',
                'content' => 'ja_JP',
            ),
            array(
                'property' => 'og:type',
                'content' => 'article',
            ),
            array(
                'property' => 'og:title',
                'content' => $this->data['blog']['title'],
            ),
            array(
                'property' => 'og:description',
                'content' => $this->data['blog']['description'],
            ),
            array(
                'property' => 'og:url',
                'content' => Uri::current(),
            ),
            array(
                'property' => 'og:site_name',
                'content' => 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ',
            ),
            array(
                'property' => 'article:publisher',
                'content' => 'https://www.facebook.com/kinyujyoshi/',
            ),
            array(
                'property' => 'fb:app_id',
                'content' => '831295686992946',
            ),
            array(
                'property' => 'og:image',
                'content' => preg_replace("/(.+)\/(.+\.jpg|.+\.jpeg|.+\.JPG|.+\.png|.+\.gif)$/", "$1/thumb_$2", $this->data['blog']['main_image'])
            ),
            array(
                'property' => 'og:image:width',
                'content' => '1200'
            ),
            array(
                'property' => 'og:image:height',
                'content' => '630'
            ),
            array(
                'property' => 'twitter:card',
                'content' => 'summary_large_image',
            ),
            array(
                'property' => 'twitter:site',
                'content' => '@kinyu_joshi',
            ),
        );

        if ($this->data['blog']['secret'] == 1) {
            $meta[] = array(
                'name' => 'robots',
                'content' => 'noindex',
            );
        }

        $this->template->meta = $meta;

        $this->template->canonical = \Uri::base() . 'report/' . $this->data['blog']['code'];

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_spafter.smarty', $this->data);
        } else {
            $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_after.smarty', $this->data);
        }
    }

    private function temporaryLinkShareableBy($user_code)
    {
      $user = User::getByUserName($user_code);
      return $user['group'] >= 30;
    }

    private function calc_past_time($datetime_str, $offset)
    {
      $datetime = new DateTime($datetime_str, new DateTimeZone('Asia/Tokyo'));
      $unix_timestamp = $datetime->format('U');
      return $unix_timestamp + $offset;
    }

    private function viewable($code)
    {
        $blog = Blogs::getByCode('blogs', $code);
        $user_code = isset($_GET['c']) ? $_GET['c'] : '';

        // ログイン済み
        if (Auth::check()) {
          return true;
        }

        // オフィシャルメンバー権限以上を持つユーザーのみ3日間の限定公開URLを発行できる
        if ($blog['status'] == 1 && $this->temporaryLinkShareableBy($user_code)) {
          if( time() <= $this->calc_past_time($blog['open_date'], 365 * 86400) ) {
            return true;
          }
        }

        // 公開期限
        if ($blog['secret'] == 0) {
          // 公開中でも公開日より1ヶ月経過した場合、非公開にする
          if( time() >= $this->calc_past_time($blog['open_date'], 30 * 86400) ) {
            return false;
          }
          return true;
        }
        return false;
    }
}
