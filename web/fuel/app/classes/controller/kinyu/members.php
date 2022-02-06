<?php

use \Model\User;
use \Model\Profiles;
use \Model\Applications;
use \Model\Events;
use \Model\ParticipatedApplications;

class Controller_Kinyu_Members extends Controller_Kinyubase
{
  public function before()
  {
    if (!Auth::check()) {
      $after_login_url = \Uri::current() ? \Uri::current() : '/members';
      \Auth::logout();
      Response::redirect('/login?after_login_url=' . $after_login_url);
      exit();
    }
    // Asset::css(array(
    //   'kinyu/redactor.css',
    //   'kinyu/font-awesome.min.css',
    //   'kinyu/toastr.css',
    //   'kinyu/bootstrap01.css',
    //   "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css",
    //   //'kinyu/swiper.min.css',
    //   //'base.css',
    //   'kinyu/bg.css',
    //   'edit_style.css',
    //   'responsive.css',
    //   'slick.css',
    //   'tablet.css'
    // ), array(), 'layout', false);
    parent::before();
  }

  public function after($response)
  {
    return parent::after($response);
  }

  public function action_index()
  {
    $this->template->title = 'メンバー一覧 ｜きんゆう女子。';
    $this->template->description = 'メンバー一覧';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->keyword = 'きんゆう女子,メンバー詳細,お金,投資,初心者';
    $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
    $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);

    $results = User::getPublishProfileUsers( '/members', Input::get('page', 1), 'page', 20 );
    $this->data['users'] = $results['users'];


    $this->template->contents = View::forge('kinyu/members/index.smarty', $this->data)
         ->set_safe('pagination', $results['pagination']);
  }

  public function action_detail()
  {
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->title = 'メンバー詳細 ｜きんゆう女子。';
    $this->template->description = 'メンバー詳細';
    $this->template->keyword = 'きんゆう女子,メンバー詳細,お金,投資,初心者';
    $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
    $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);

    $user_id = $this->param('id');
    $user = User::getByUserId($user_id);
    $public_profile = Profiles::get($user['username']);

    // どちらも存在しないのはあり得ない
    if( !isset($user) && !isset($public_profile) ) {
      return Response::redirect('/members');
    }

    // 存在しないか公開設定をしていなければ404
    if( (int)$public_profile['disable'] == 1 || (int)$public_profile['publish'] == 0 ) {
      return Response::redirect('/members');
    }

    $this->template->title = $public_profile['nickname'] . 'さんのプロフィール ｜きんゆう女子。';
    $this->template->description = $public_profile['nickname'] . 'さんのプロフィール ｜きんゆう女子。';

    // $joinable_events = Events::joinedEvents($user["username"], false);

    $this->data['public_profile'] = $public_profile;
    $this->data['user'] = $user;
    $this->data['joinable_events'] = [];
    $this->data['joined_events'] = ParticipatedApplications::lists($user["username"]);

    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->my_side = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

    $meta = array(
      array(
        'name' => 'description',
        'content' => $public_profile['introduction']
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
        'content' => $public_profile['nickname'] . 'さんのプロフィール ｜きんゆう女子。'
      ),
      array(
        'property' => 'og:description',
        'content' => $public_profile['nickname'] . 'さんのプロフィール ｜きんゆう女子。'
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
        'content' => "https://kinyu-joshi.jp/images/kinyu-logo_630x630.png"
      ),
      array(
        'property' => 'twitter:site',
        'content' => '@kinyu_joshi',
      ),
    );
    $this->template->meta = $meta;
    $this->template->contents = View::forge('kinyu/members/detail.smarty', $this->data);
  }
}
