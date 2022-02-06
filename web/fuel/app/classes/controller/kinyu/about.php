<?php

use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_About extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。ストーリー｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/index.smarty', $this->data);
    }

    //きんゆう女子。って？
    public function action_about_main()
    {
        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。コミュニティについて｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_main.smarty', $this->data);
    }

    //できること
    public function action_about_contents()
    {
        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。でできること｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_contents.smarty', $this->data);
    }

    //生まれたストーリー
    public function action_about_story()
    {
        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = '生まれたストーリー｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_story.smarty', $this->data);
    }

    //デザインについて
    public function action_about_design()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'デザインコンセプト｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_design.smarty', $this->data);
    }

    //コミュニティマネジメント
    public function action_about_Community()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'コミュニティマネジメント｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_community.smarty', $this->data);
    }

    //インサイトポリシー
    public function action_about_Insight()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'インサイトポリシー｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_insight.smarty', $this->data);
    }

    //これまでの歩み
    public function action_about_history()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'これまでの歩み｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/about_history.smarty', $this->data);
    }

    public function action_edit_index()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。コミュニティについて｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/about/edit_index.smarty', $this->data);
    }

}
