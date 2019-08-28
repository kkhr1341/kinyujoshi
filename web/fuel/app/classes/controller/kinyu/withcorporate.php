<?php

class Controller_Kinyu_Withcorporate extends Controller_Kinyubase
{

    public function action_paypay()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless2019':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo_paypay':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = 'Say Farewell to Cash | 今日も、キャッシュレス。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-cashless.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        } else {
        }
        $this->template->contents = View::forge('kinyu/withcorporate/paypay.smarty', $this->data);
    }

    public function action_article01()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless2019':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo_paypay':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = '行ったことのない、おいしいパン屋さん巡り。〜 麻布十番から渋谷までお散歩 〜 | 今日も、キャッシュレス。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/withcorporate/paypay/article/article1_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        } else {
        }
        $this->template->contents = View::forge('kinyu/withcorporate/article01.smarty', $this->data);
    }

    public function action_article02()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless2019':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo_paypay':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = '行緑とアートに囲まれる、キャッシュレス旅。 | 今日も、キャッシュレス。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/withcorporate/paypay/article/article1_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        } else {
        }
        $this->template->contents = View::forge('kinyu/withcorporate/article02.smarty', $this->data);
    }
}
