<?php

class Controller_Kinyu_Withk extends Controller_Kinyubase
{
    public function action_with_bloomoibrillia()
    {

        // switch (true) {
        //     case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        //     case $_SERVER['PHP_AUTH_USER'] !== 'brillia':
        //     case $_SERVER['PHP_AUTH_PW']   !== 'bloomoi':
        //     header('WWW-Authenticate: Basic realm="Enter username and password."');
        //     header('Content-Type: text/plain; charset=utf-8');
        //     die('このページを見るにはログインが必要です');
        // }

        $this->template->title = 'with×き -東京建物 Brillia Bloomoi-';
        $this->template->ogimg = '/images/content/og-fb.jpg';
        $this->template->description = '';

        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withk/with_bloomoibrillia.smarty', $this->data);
    }
}