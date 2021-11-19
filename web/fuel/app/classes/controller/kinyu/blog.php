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
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 20, null, null);
        } else {
            $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 40, null, null);
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
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/blog/index.smarty', $this->data)
            ->set_safe('pagination', $pagination);
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
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        // $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
        // $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        // $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        // $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        // if (Agent::is_mobiledevice()) {
        //     $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        // }
        $this->template->contents = View::forge('kinyu/blog/search.smarty', $this->data)
            ->set_safe('pagination', $pagination);

        Asset::css(array('kinyu/font-awesome.min.css',), array(), 'layout', false);
    }

    const EVENT_DISPLAY_LIMIT = 6;

    public function action_detail($code)
    {
        // 最新を取得
        $this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
        $this->data['blog'] = Blogs::getByCodeWithProfile($code);
        $this->data['event_display_limit'] = self::EVENT_DISPLAY_LIMIT;
        $this->data['events'] = Events::lists(1, null, true, null, 'asc');

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

        // 非公開設定の場合
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

          // 非公開設定の場合でBasic認証通ってる場合は、限定公開設定であったとしても強制的に閲覧できるようにする
          $this->data['viewable'] = true;
        }

        $this->template->title = $this->data['blog']['title'];
        $this->template->description = $this->data['blog']['description'];
        $this->template->ogimg = $this->data['blog']['main_image'];
        //template
        $this->data['top_blogs'] = Blogs::lists(1, 6, true);
        $this->data['top_blogs02'] = Blogs::lists02(1, 5, true);
        $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
        $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
        $this->data['after_login_url'] = \Uri::base() . 'report/' . $this->data['blog']['code'];

        $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data + array(
          'title'       => $this->data['blog']['title'],
          'user_code' => $this->temporaryLinkShareableBy($username) ? $username : null,
          'auth_code' => $this->generateTemporaryLinkAuthCode($this->data['blog']['code'], $username),
          'posted_me'   => $this->data['posted_me']
        ));

        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->sidebar = View::forge('kinyu/blog/side.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        // $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        // $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        // $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        // $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

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

        $this->template->meta = $meta;
        $this->template->canonical = \Uri::base() . 'report/' . $this->data['blog']['code'];

        $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_spafter.smarty', $this->data);

        // if (Agent::is_mobiledevice()) {
        //     $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        //     $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_spafter.smarty', $this->data);
        // } else {
        //     $this->template->detail_report_after = View::forge('kinyu/blog/detail_report_after.smarty', $this->data);
        // }
    }

    private function generateTemporaryLinkAuthCode($blog_code, $user_code) {
      $salt = 'WZ6xFt53uGP9SygA';
      $str = $blog_code .':'. $user_code .':'. $salt;
      return strtr(rtrim(base64_encode(pack('H*', hash('CRC32', $str))), '='), '+/', '-_');
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
      $user_code = isset($_GET['u']) ? $_GET['u'] : '';
      $auth_code = isset($_GET['k']) ? $_GET['k'] : '';

      // 一般公開設定をしているか
      if ( $blog['publish'] == '1' ) {
        return true;
      }

      // ログイン済み
      if (Auth::check()) {
        return true;
      }

      // オフィシャルメンバー権限以上を持つユーザーのみ7日間の限定公開URLを発行できる
      if ($blog['status'] == 1 && $auth_code === $this->generateTemporaryLinkAuthCode($code, $user_code)) {
        // 簡易負荷対策: 認証コードを通してからでないとDBへのアクセスをしない
        if( $this->temporaryLinkShareableBy($user_code) ) {
          if( time() <= $this->calc_past_time($blog['open_date'], 30 * 86400) ) {
            return true;
          }
        }
      }

      // 公開期限
      if ($blog['secret'] == 0) {
        // 公開中でも公開日より1ヶ月経過した場合、非公開にする
        // 1ヶ月経過すると自動的に公開にし1ヶ月経過しないと非公開にする
        if( time() < $this->calc_past_time($blog['open_date'], 30 * 86400) ) {
          return false;
        }
        return true;
      }
      return false;
    }
}
