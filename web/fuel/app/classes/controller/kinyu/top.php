<?php

use \Model\Blogs;
use \Model\Blogstocks;
use \Model\News;
use \Model\Events;
use \Model\EventDisplayTopPages;
use \Model\Projects;

class Controller_Kinyu_Top extends Controller_Kinyubase
{
    const EVENT_DISPLAY_LIMIT = 6;
    const AUTHENTICATION_USER = 'kinyu-report';
    const AUTHENTICATION_PASSWORD = 'iYszQGhE';

    public function action_index($page = 1)
    {
        $this->data['news'] = News::lists(1, 1, true);

        $this->data['event_display_limit'] = self::EVENT_DISPLAY_LIMIT;
        $this->data['events'] = Events::lists(1, null, true, null, 'asc');
        $this->data['eventsnew'] = Events::listsnew(1, null, true, null, 'asc');
        $this->template->title = 'きんゆう女子。- 自由で等身大に生きる。どの金融機関に属さない中立コミュニティ';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        //template
        //$this->data['top_blogs2'] = Blogs::lists02(1, 12, true, null, null, null, null);

        $this->data['blogs'] = Blogs::all('kinyu' + 'investment', '/report/', $page, 2, 20, null, null);
        foreach($this->data['blogs']['datas'] as &$blogs) {
          $blogs['viewable'] = $this->viewable($blogs['code']);
        }
        unset($blogs);

        $this->data['blogs_pick'] = Blogs::lists_picks(1, 5, true);
        $this->data['display_top_event'] = EventDisplayTopPages::get();
        $this->template->reload_animation = View::forge('kinyu/template/reload_animation.smarty', $this->data);
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->side = View::forge('kinyu/common/side.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->pickup_top = View::forge('kinyu/common/top/pickup_top.smarty', $this->data);
        $this->template->mainvisual = View::forge('kinyu/common/top/mainvisual.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->mainproject = View::forge('kinyu/common/top/mainproject.smarty', $this->data);


        // if (Agent::is_mobiledevice()) {
        //     $this->template->mainproject = View::forge('kinyu/common/top/mainproject_sp.smarty', $this->data);
        // } else {
        //     $this->template->mainproject = View::forge('kinyu/common/top/mainproject.smarty', $this->data);
        // }


        $this->template->contents = View::forge('kinyu/index.smarty', $this->data);

        // if (Agent::is_smartphone()) {
        //     $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        //     $this->template->contents = View::forge('kinyu/index.smarty', $this->data);
        //     $this->template->pickup_top = View::forge('kinyu/common/sp_pickup_top.smarty', $this->data);
        // } else {
        //     $this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
        //     $this->template->pickup_top = View::forge('kinyu/common/pc_pickup_top.smarty', $this->data);
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
