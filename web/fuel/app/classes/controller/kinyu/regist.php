<?php

use \Model\Categories;

class Controller_Kinyu_Regist extends Controller_Kinyubase
{

    public function action_index()
    {

        $this->template->title = 'メンバー登録｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-regist.jpg';
        $this->template->description = "きんゆう女子の。の会員登録フォームです。積極的にコミュニティに参加したい！きんゆう女子。のメンバー登録フォームです。初めて女子会に参加する際にこちらを登録してください！";
        $this->template->keyword = 'メンバー登録,お金,投資,初心者,貯金';
        $this->data['categories'] = Categories::lists();

        $this->data['userdata'] = \Session::get_flash('userdata');

        $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
        $this->template->singlepage_footer = View::forge('kinyu/template/singlepage_footer.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/regist/index.smarty', $this->data);

    }

    public function action_complete()
    {
        $this->template->title = 'メンバー登録｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-regist.jpg';
        $this->template->description = "きんゆう女子の。の会員登録フォームです。積極的にコミュニティに参加したい！きんゆう女子。のメンバー登録フォームです。初めて女子会に参加する際にこちらを登録してください！";
        $this->template->keyword = 'メンバー登録,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);

        $this->template->singlepage_footer = View::forge('kinyu/template/singlepage_footer.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/regist/complete.smarty', $this->data);
    }
}


