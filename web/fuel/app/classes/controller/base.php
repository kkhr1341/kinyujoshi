<?php
/**
 * The Base Controller.
 *
 * @package  app
 * @extends  Controller
 */
use \Model\Profiles;

class Controller_Base extends Controller_Template
{

	public $template = 'mypage.smarty';
	public $data;

	private function profile() {
		if (Auth::check()) {
			// ログイン中なのでプロフィールを取得する
			$username = Auth::get('username');
			$profile = Profiles::get($username);
			$this->template->profile = $profile;
		}
	}
	
	/**
	 * メールを送信する
	 */
	public static function mail($title, $message, $to) {
	
		\Config::load('const', true);
		$email = \Email::forge();
		$email->from(\Config::get('const.MAIL_FROM'), \Config::get('MAIL_FROM_TEXT'));
		$email->to($to);
		$email->subject($title);
		$email->body($message);
		$email->send();
	
		return true;
	}

	/**
	 * メールを送信する
	 */
	public static function mail_with_urlattach($title, $message, $to, $urls=array()) {
	
		\Config::load('const', true);
		$email = \Email::forge();
		$email->from(\Config::get('const.MAIL_FROM'), \Config::get('MAIL_FROM_TEXT'));
		$email->to($to);
		$email->subject($title);
		$email->body($message);
	
		$file_paths = array();
		echo "---";
	
		foreach($urls as $key => $url) {
			$microtime = md5(microtime());
			$file_name = "/tmp/{$microtime}.png";
			$file_paths[] = $file_name;
			file_put_contents($file_name, file_get_contents($url));
			$email->attach($file_name);
		}
	
		$email->send();
	
		foreach($file_paths as $key => $file_path) {
			unlink($file_path);
		}
	
		return true;
	}
	
	public function before() {

		if (!Auth::check()) {
			$this->template = 'main.smarty';
		}
		else {
			$this->template = 'main.smarty';
		}
		parent::before();
		$this->profile();
		
		
		$this->template->title = 'SUNYDAY LUNCH!';

// 		Asset::url("//sundaylunch.jp");
		Asset::add_path('assets/css', 'css');
		Asset::add_path('assets/js', 'js');

		Asset::css(array('bootstrap.min.css', 'main.css'), array(), 'layout', false);
		
		Asset::js(array('jquery-2.1.4.min.js', 'bootstrap.min.js', 'bootcards.min.js', 'loader.js', 'ajax.js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js', 'jquery.japan-map.min.js'), array(), 'layout', false);

		
		set_exception_handler (function ($e) {
			$this->error($e->getMessage());
		});
		

		
	}
	
	public function after($response) {
		$response = parent::after($response);
		return $response;
	}

	/**
	 * APIの正常系レスポンスを返す
	 */
	public function ok($DATA=null, $MESSAGES=null) {

		$response = array(
				'api_status' => "ok",
				'data' => $DATA
		);
		
		echo json_encode($response);
		exit();
	}
	
	/**
	 * APIのエラーレスポンスを返す
	 */
	public function error($MESSAGES) {
	
		$response = array(
				'api_status' => 'error',
				'message' => $MESSAGES,
		);
	
		echo json_encode($response);
		exit();
	}
	
}
