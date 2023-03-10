<?php

use \Model\Companies;

class Controller_Kinyu_Company extends Controller_Kinyubase
{

    // 会社概要
    public function action_index()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = '運営会社｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/index.smarty', $this->data);
    }

    // 企業向けページ
    public function action_business()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = '企業向けページ｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/business.smarty', $this->data);
    }

    // プライバシーポリシー
    public function action_privacy()
    {
        $this->template->title = 'プライバシーポリシー｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,プライバシーポリシー';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/privacy.smarty', $this->data);
    }

    // 利用規約
    public function action_service()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = 'メンバー規約｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,メンバー規約';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/service.smarty', $this->data);
    }

    // 利用規約
    public function action_legal()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = '特定商取引法に基づく表記｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,特定商取引法に基づく表記';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/legal.smarty', $this->data);
    }

    // サービス参加規約
    public function action_joshikai()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = 'サービス参加規約｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,サービス参加規約';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/joshikai.smarty', $this->data);
    }

    // リンクポリシー
    public function action_link()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = 'リンクポリシー｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,リンクポリシー';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/link.smarty', $this->data);
    }

    // よくある質問
    public function action_faq()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = 'よくあるご質問｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->keyword = 'きんゆう女子,TOE THE LINE,会社概要,よくあるご質問,FAQ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/company/faq.smarty', $this->data);
    }
}
