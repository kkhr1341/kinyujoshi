<?php

use \Model\Pages;

class Controller_Kinyu_Page extends Controller_Kinyubase
{

    public function action_index($code)
    {
        $this->data['page'] = Pages::getByCode('pages', $code);
        $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/page/index.smarty', $this->data);
        $this->template->description = 'きんゆう女子。は、どの金融機関にも属さない金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}