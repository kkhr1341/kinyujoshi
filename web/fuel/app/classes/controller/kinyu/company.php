<?php

use \Model\Companies;

class Controller_Kinyu_Company extends Controller_Kinyubase
{

  // 会社概要
	public function action_index() {
		$this->data['company'] = Companies::get();
		$this->template->title = '運営会社｜きんゆう女子。';
    $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
		$this->template->contents = View::forge('kinyu/company/index.smarty', $this->data);
	}

  // プライバシーポリシー
  public function action_privacy() {
    //$this->data['company'] = Companies::get();
    $this->template->title = 'プライバシーポリシー｜きんゆう女子。';
    $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/company/privacy.smarty', $this->data);
  }

  // 利用規約
  public function action_service() {
    $this->data['company'] = Companies::get();
    $this->template->title = '利用規約｜きんゆう女子。';
    $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/company/service.smarty', $this->data);
  }
  // 利用規約
  public function action_legal() {
    $this->data['company'] = Companies::get();
    $this->template->title = '特定商取引法に基づく表記｜きんゆう女子。';
    $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/company/legal.smarty', $this->data);
  }


}
