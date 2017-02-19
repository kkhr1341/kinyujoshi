<?php

use \Model\Blogs;
use \Model\Projects;
use \Model\Courses;
use \Model\Addresses;
use \Model\Wp;

class Controller_Kinyu_Project extends Controller_Kinyubase
{

	public function action_index($page=1) {
		
		$this->data['projects'] = Projects::all('kinyu', '/kinyu/project/', $page, 3, 5);
		$pagination = $this->data['projects']['pagination'];
		$this->data['pagination'] = $pagination::instance('mypagination');
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/index.smarty', $this->data);
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_reports($project_code) {

		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['courses'] = Courses::get_courses($project_code);
		$this->data['blogs'] = Blogs::lists(1, null, 1, null, $project_code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/reports.smarty', $this->data);
	}

	public function action_comments($project_code) {

		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['courses'] = Courses::get_courses($project_code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/comments.smarty', $this->data);
	}

	public function action_report($project_code, $code) {

		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['courses'] = Courses::get_courses($project_code);
		$this->data['blog'] = Blogs::getByCode('blogs', $code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/report.smarty', $this->data);
	}
	
	public function action_detail($code) {
		$this->data['project'] = Projects::getByCode('projects', $code);
		$this->data['courses'] = Courses::get_courses($code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		
// 		print_r($this->data['courses']);
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/detail.smarty', $this->data);
	}
	
	public function action_course($project_code, $course_code, $address_code=null) {

		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['course'] = Courses::getByCode('courses', $course_code);
		$this->data['addresses'] = Addresses::lists(Auth::get('username'));
		$this->data['address_code'] = $address_code;
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/course.smarty', $this->data);
	}

	public function action_comp($project_code, $course_code) {
		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['course'] = Courses::getByCode('courses', $course_code);
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/project/comp.smarty', $this->data);
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_complete($project_code, $course_code, $address_code) {
		$wp = new Wp();
		$result = $wp->course_buy(Auth::get('username'), $project_code, $course_code, $address_code);
		Response::redirect("kinyu/project/course/comp/{$project_code}/{$course_code}");
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}
	
	public function action_confirm($project_code, $course_code, $address_code=null) {

		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['course'] = Courses::getByCode('courses', $course_code);
		$this->data['address'] = Addresses::getByCode('addresses', $address_code);
		$this->data['address_code'] = $address_code;
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

		$wp = new Wp();
		$customer = $wp->get_wpcustomer(Auth::get('username'));
		$active_card = [
				'exp_month' => @$customer->active_card->exp_month,
				'exp_year' => @$customer->active_card->exp_year,
				'last4' => @$customer->active_card->last4,
				'type' => @$customer->active_card->type,
				'name' => @$customer->active_card->name,
		];
		$this->data['active_card'] = $active_card;
		
		$this->template->contents = View::forge('kinyu/project/confirm.smarty', $this->data);
	}
	
	public function action_payment($project_code, $course_code, $address_code=null) {

		$wp = new Wp();
		
		// カードの登録があれば、結びつける
		if (\Input::post('wptoken') != "") {
			$res = $wp->set_card(Auth::get('username'), \Input::post('wptoken'));
		}
		
		$this->data['project'] = Projects::getByCode('projects', $project_code);
		$this->data['course'] = Courses::getByCode('courses', $course_code);
		$this->data['addresses'] = Addresses::lists(Auth::get('username'));
		$this->data['address_code'] = $address_code;
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
		$customer = $wp->get_wpcustomer(Auth::get('username'));
		$active_card = [
				'exp_month' => @$customer->active_card->exp_month,
				'exp_year' => @$customer->active_card->exp_year,
				'last4' => @$customer->active_card->last4,
				'type' => @$customer->active_card->type,
				'name' => @$customer->active_card->name,
		];
		$this->data['active_card'] = $active_card;
// 		print_r($customer->active_card);
		
// 		print_r($this->data['customer']->active_card);
// 		print_r($this->data['customer']);
// 		exit();
		
		
		/*
		 * WebPay\Data\CustomerResponse Object
(
    [attributes:protected] => Array
        (
            [id] => cus_9hkb4ZbpEboK09I
            [object] => customer
            [livemode] => 
            [created] => 1451975078
            [active_card] => 
            [description] => goroakimoto
            [email] => goro@akimoto.me
            [recursions] => Array
                (
                )

            [deleted] => 
        )
		 */
		
		$this->template->contents = View::forge('kinyu/project/payment.smarty', $this->data);
	}
}
