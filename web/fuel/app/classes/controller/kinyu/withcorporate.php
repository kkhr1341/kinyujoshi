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
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
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
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
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

        $this->template->title = '緑とアートに囲まれる、キャッシュレス旅。 | 今日も、キャッシュレス。';
        $this->template->ogimg = '/images/withcorporate/paypay/article02/article2_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withcorporate/article02.smarty', $this->data);
    }

    public function action_article03()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless2019':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo_paypay':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = 'ゆとりができたら見えてきた、私なりの復興支援。 | 今日も、キャッシュレス。';
        $this->template->ogimg = '/images/withcorporate/paypay/article03/article3_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withcorporate/article03.smarty', $this->data);
    }

    public function action_article04()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = 'エシカルをテーマに吉祥寺と国分寺でショッピング。 | 今日も、キャッシュレス。';
        $this->template->ogimg = '/images/withcorporate/paypay/article04/article4_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withcorporate/article04.smarty', $this->data);
    }

    public function action_article05()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'cashless':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'kinjo':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = 'かわいくて作り置きOKなお弁当作りにチャレンジ。 | 今日も、キャッシュレス。';
        $this->template->ogimg = '/images/withcorporate/paypay/article05/article5_og.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'キャッシュレス,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withcorporate/article05.smarty', $this->data);
    }
}
