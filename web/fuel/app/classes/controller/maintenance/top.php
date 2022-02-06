<?php

use \Model\Blogs;
use \Model\News;
use \Model\Events;
use \Model\Projects;

class Controller_Maintenance_Top extends Controller_Maintenancebase
{
    public function action_index()
    {
        $this->template->title = 'メンテナンス | きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        //template
        $this->template->contents = View::forge('maintenance/index.smarty', $this->data);
    }
}