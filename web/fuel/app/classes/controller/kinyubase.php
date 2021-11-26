<?php
/**
 * The Base Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Profiles;
use \Model\InsightQuestions;
use \Model\InsightQuestionLabels;

class Controller_Kinyubase extends Controller_Template
{

    const INSIGHT_QUESTION_ID = '1'; // インサイト取得質問ID

    public $template = 'main.smarty';
    public $data;


    private function profile()
    {
        $this->template->profile = [];
        if (Auth::check()) {
            // ログイン中なのでプロフィールを取得する
            $username = Auth::get('username');
            $profile = Profiles::get($username);
            $this->template->profile = $profile;
        } else {
            \Session::set('referrer', \Input::referrer());
        }
    }

    public function before()
    {

        parent::before();

        $this->profile();
        $group = Auth::group();
        $this->data['roles'] = $group->get_roles();
        $this->template->roles = $this->data['roles'];

        list(, $userid) = Auth::get_user_id();

        $this->template->ga = View::forge('parts/ga', array(
            'userid' => $userid
        ));

        $this->template->authenticated = Auth::check() ? 1 : 0;

        // ポップアップ広告
        $question = InsightQuestions::findById(self::INSIGHT_QUESTION_ID);
        $question_labels = InsightQuestionLabels::lists(self::INSIGHT_QUESTION_ID);
        $this->template->insight_correct_popup = View::forge('kinyu/common/insight_correct_popup.smarty', array(
            'question' => $question,
            'labels' => $question_labels,
        ));

        // ログイン後のリダイレクトURL
        if ($after_login_url = Input::get("after_login_url")) {
            \Session::set('after_login_url', $after_login_url);
        }

        Asset::add_path('assets/css', 'css');
        Asset::add_path('assets/js', 'js');
        Asset::css(array(
            //'kinyu/font.css',
            'kinyu/animate.css',
            'kinyu/redactor.css',
            'kinyu/font-awesome.min.css',
            //'kinyu/bootstrap-datetimepicker.min.css',
            //'kinyu/bootstrap01.css',
            "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css",
            //'kinyu/bootstrap-select.min.css',
            'kinyu/toastr.css',
            // 'kinyu/base.css',
            // 'kinyu/bg.css',
            // 'kinyu/style.css',
            // 'kinyu/layout.css',
            // 'kinyu/responsive.css',
            // 'kinyu/kuchikomi.css',

            'kinyu/swiper.min.css',
            //'kinyu/jumboShare.css',
            //'kinyu/drawer.css',

            'base.css',
            // 'kinyu/bg.css',
            //'style.css',
            //'edit_style.css',
            // 'responsive.css',
            // 'slick.css',
            // 'tablet.css'
            'common.css',
            'header.css',
            'footer.css',
            'event_kessai.css'
        ), array(), 'layout', false);

        Asset::js(array(
            'jquery-2.1.4.min.js',
            'bootstrap.min.js',
            'moment.js',
            //'bootstrap-datetimepicker.min.js',
            'bootcards.min.js',
            'bootbox.min.js',
            //'php.full.min.js',
            'toastr.min.js',
            'loader.js',
            'ajax.js',
            'redactor.js',
            'payment.js',
            //'video.js',
            'imagemanager.js',
            //'inlinestyle.js',
            //'source.js',
            //'table.js',
            'filemanager.js',
            //'textdirection.js',
            //'bootstrap-select.min.js',
            //'ja.js',
            //'tool.js',
            //'jquery.smoothScroll.min.js',
            //'jumboShare.js',
            //'kinyu/smooth-scroll.js',

            // 必要
            //'kinyu/jquery.infinitescroll.min.js',
            //'kinyu/slick.min.js',
            'kinyu/main.js',
            'kinyu/scrollreveal.min.js',
            // 必要
            'kinyu/flipsnap.min.js',
            'kinyu/slide.js',
            'kinyu/swiper.min.js',
            // ポップアップ広告
//            'kinyu/popup.js',
            //'kinyu/jquery.bxslider.min.js',
            //'https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js'
            //'kinyu/drawer.min.js'
        ), array(), 'layout', false);

        //set_exception_handler(function ($e) {
        //    $this->error($e->getMessage());
        //});

        \View_Smarty::parser()->registerPlugin('function', 'to_thumb', array($this,'smarty_function_to_thumb'));

    }

    public function smarty_function_to_thumb($params, $smarty)
    {
        $filepath = $params['file'];

        $files = explode('/', $filepath);

        $filename = array_pop($files);
        $filename = preg_replace("/(.+\.jpg|.+\.jpeg|.+\.JPG|.+\.png|.+\.gif)$/", $params['type'] . "_$1", $filename);

        if (count($files) == 0) {
            return $filename;
        }
        return implode('/', $files) . '/' . $filename;

    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function error($MESSAGES)
    {

        $response = array(
            'api_status' => 'error',
            'message' => $MESSAGES,
        );

        echo json_encode($response);
        exit();
    }

    protected function set_basic_auth($user, $password)
    {
        switch (true) {
            case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
            case $_SERVER['PHP_AUTH_USER'] !== $user:
            case $_SERVER['PHP_AUTH_PW']   !== $password:
                header('WWW-Authenticate: Basic realm="Enter username and password."');
                header('Content-Type: text/plain; charset=utf-8');
                die('このページを見るにはログインが必要です');
        }
    }
}
