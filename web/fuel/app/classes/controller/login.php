<?php

class Controller_Login extends Controller_KinyuBase
{
	public function action_index() {

    // switch (true) {
    //   case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
    //   case $_SERVER['PHP_AUTH_USER'] !== 'kinyu-admin':
    //   case $_SERVER['PHP_AUTH_PW']   !== '1234567890':
    //   header('WWW-Authenticate: Basic realm="Enter username and password."');
    //   header('Content-Type: text/plain; charset=utf-8');
    //   die('このページを見るにはログインが必要です');
    // }
		
		if (!Auth::check()) {
      //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
			//$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    	//$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
			$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'ログイン｜きんゆう女子。';
    	$this->template->description = 'ログイン｜きんゆう女子';
      $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
      $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
        $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/index.smarty', $this->data);
      } else {
        $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
      }
      $this->template->contents = View::forge('login/index.smarty', $this->data);

		}
		else {
			Response::redirect('/my');
		}
	}

  public function action_regist() {

    // switch (true) {
    //   case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
    //   case $_SERVER['PHP_AUTH_USER'] !== 'kinyu-admin':
    //   case $_SERVER['PHP_AUTH_PW']   !== '1234567890':
    //   header('WWW-Authenticate: Basic realm="Enter username and password."');
    //   header('Content-Type: text/plain; charset=utf-8');
    //   die('このページを見るにはログインが必要です');
    // }
    
    if (!Auth::check()) {
      //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
      //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'ログイン｜きんゆう女子。';
      $this->template->description = 'ログイン｜きんゆう女子';
      $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
      $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
        $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/index.smarty', $this->data);
      } else {
        $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
      }
      $this->template->contents = View::forge('login/regist.smarty', $this->data);

    }
    else {
      Response::redirect('/my');
    }
  }

  public function action_regist_email() {

    // switch (true) {
    //   case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
    //   case $_SERVER['PHP_AUTH_USER'] !== 'kinyu-admin':
    //   case $_SERVER['PHP_AUTH_PW']   !== '1234567890':
    //   header('WWW-Authenticate: Basic realm="Enter username and password."');
    //   header('Content-Type: text/plain; charset=utf-8');
    //   die('このページを見るにはログインが必要です');
    // }
    
    if (!Auth::check()) {
      //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
      //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'ログイン｜きんゆう女子。';
      $this->template->description = 'ログイン｜きんゆう女子';
      $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
      $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
        $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/index.smarty', $this->data);
      } else {
        $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
        //$this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
      }
      $this->template->contents = View::forge('login/regist_email.smarty', $this->data);

    }
    else {
      Response::redirect('/my');
    }
  }

}