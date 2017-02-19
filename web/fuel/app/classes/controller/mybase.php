<?php
/**
 * The Base Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Profiles;

class Controller_Mybase extends Controller_Template
{

	public $template = 'my.smarty';
	public $data;

	
	private function profile() {
		if (Auth::check()) {
			// ログイン中なのでプロフィールを取得する
			$username = Auth::get('username');
			$profile = Profiles::get($username);
			$this->template->profile = $profile;
// 			print_r($profile);
// 			exit();
		}
	}
	
	public function before() {

// 		$this->template->content = View::forge('my.smarty', $this->data);
		parent::before();
		
		
		if (!Auth::check()) {
			\Auth::logout();
			Response::redirect('/login');
			exit();
		}
		$this->profile();

		$group = Auth::group();
		$this->data['roles'] = $group->get_roles();
// 		$this->data['profile'] = Auth::get_profile_fields();
// 		$this->data['profile']['image_big'] = str_replace("square", "large", $this->data['profile']['image']);

		$this->template->roles = $this->data['roles'];
// 		$this->template->profile = $this->data['profile'];
		
		Asset::add_path('assets/css', 'css');
		Asset::add_path('assets/js', 'js');
		Asset::css(array(
							'kinyu/font.css',
							'kinyu/bootstrap01.css',
							'kinyu/animate.css',
							'kinyu/redactor.css',
							'kinyu/font-awesome.min.css',
							'kinyu/bootstrap-datetimepicker.min.css',
							'kinyu/toastr.css',
							'kinyu/bootstrap-select.min.css',
							'kinyu/base.css',
							'kinyu/bg.css',
							'kinyu/style.css',
							'kinyu/layout.css',
							'kinyu/responsive.css',
							'kinyu/gakuin.css',
							'kinyu/kuchikomi.css',
							'kinyu/swiper.min.css',
							'kinyu/jumboShare.css',
							'kinyu/drawer.css',
							'my/my.css',
							'my/layout.css',
							'my/responsive.css'
		), array(), 'layout', false);
		
		Asset::js(array(
							'jquery-2.1.4.min.js',
							'bootstrap.min.js',
							'moment.js',
							'bootstrap-datetimepicker.min.js',
							'bootcards.min.js',
							'bootbox.min.js',
							'php.full.min.js',
							'toastr.min.js',
							'loader.js',
							'ajax.js',
							'redactor.js',
							'video.js',
							'imagemanager.js',
							'inlinestyle.js',
							'source.js',
							'table.js',
							'filemanager.js',
							'textdirection.js',
							'bootstrap-select.min.js',
							'ja.js',
							'tool.js',
							'kinyu/drawer.min.js',
							// 'kinyu/main.js',
							'my/main.js'
		), array(), 'layout', false);

		set_exception_handler (function ($e) {
			$this->error($e->getMessage());
		});
		
	}
	
	public function after($response) {
		$response = parent::after($response);
		return $response;
	}


	public function error($MESSAGES) {
	
		$response = array(
				'api_status' => 'error',
				'message' => $MESSAGES,
		);
	
		echo json_encode($response);
		exit();
	}
}
