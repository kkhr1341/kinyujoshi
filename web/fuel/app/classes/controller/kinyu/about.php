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
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/about/index.smarty', $this->data);
    }

    //きんゆう女子。って？
    public function action_about_main()
    {
        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。って？｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
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
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
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
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/about/about_story.smarty', $this->data);
    }

    //運営ポリシー
    public function action_about_policy()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。でできること｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/about/about_policy.smarty', $this->data);
    }

    //デザインについて
    public function action_about_design()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'デザインコンセプト｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/about/about_design.smarty', $this->data);
    }

    //きんゆう女子。編集部について
    public function action_about_hensyubu()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。でできること｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/about/about_hensyubu.smarty', $this->data);
    }

    public function action_edit_index()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。とは...？｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/about/edit_index.smarty', $this->data);
    }

    public function action_myplan()
    {

        $this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        $this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きんゆう女子。とは...？｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/about/myplan.smarty', $this->data);
    }
}
