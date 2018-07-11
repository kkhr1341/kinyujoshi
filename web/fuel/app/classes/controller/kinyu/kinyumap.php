<?php

use \Model\Companies;

class Controller_Kinyu_Kinyumap extends Controller_Kinyubase
{

    // 会社概要
    public function action_ooedo_ito()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'map_ooedoito':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'Spaspa3472':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->data['company'] = Companies::get();
        $this->template->title = '大江戸温泉リートの投資先を見てみよう！｜きんゆう女子。';
        $this->template->description = '大江戸温泉リートの投資先を見てみよう！';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->map_last = View::forge('kinyu/kinyumap/map_last.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/kinyumap/ooedo_ito.smarty', $this->data);
    }

}