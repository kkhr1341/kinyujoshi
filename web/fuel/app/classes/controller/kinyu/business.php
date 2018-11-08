<?php

class Controller_Kinyu_Business extends Controller_Kinyubase
{
//    const AUTHENTICATION_USER = 'kinyu';
//
//    const AUTHENTICATION_PASSWORD = 'business';

    public function action_index()
    {

//		$authentication_user     = self::AUTHENTICATION_USER;
//		$authentication_password = self::AUTHENTICATION_PASSWORD;
//
//		switch (true) {
//			case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
//			case $_SERVER['PHP_AUTH_USER'] !== $authentication_user:
//			case $_SERVER['PHP_AUTH_PW'] !== $authentication_password:
//				header('WWW-Authenticate: Basic realm="Enter username and password."');
//				header('Content-Type: text/plain; charset=utf-8');
//				die('このページを見るにはログインが必要です');
//		}

        if (Agent::is_mobiledevice()) {

          switch (true) {
             case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
             case $_SERVER['PHP_AUTH_USER'] !== 'kinyu':
             case $_SERVER['PHP_AUTH_PW']   !== 'business':
             header('WWW-Authenticate: Basic realm="Enter username and password."');
             header('Content-Type: text/plain; charset=utf-8');
             die('このページを見るにはログインが必要です');
          }

        }

        $this->template->title = 'きんゆう女子。コミュニティパートナーをご検討の企業様へ｜きんゆう女子。';
        $this->template->description = "";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/diagnosticchart/og-main.jpg';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);


        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/business/index.smarty', $this->data);
    }

}
