<?php
/**
 * The Base Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Profiles;

class Controller_Maintenancebase extends Controller_Template
{

    public $template = 'maintenance.smarty';
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

        // ログイン後のリダイレクトURL
        if ($after_login_url = Input::get("after_login_url")) {
            \Session::set('after_login_url', $after_login_url);
        }

        Asset::add_path('assets/css', 'css');
        Asset::add_path('assets/js', 'js');
        Asset::css(array(
            //'kinyu/font.css',
            //'kinyu/animate.css',
            'kinyu/redactor.css',
            //'kinyu/font-awesome.min.css',
            //'kinyu/bootstrap-datetimepicker.min.css',
            'kinyu/toastr.css',
            //'kinyu/bootstrap-select.min.css',
            'kinyu/bootstrap01.css',

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
            'slick.css',
            'kinyu/bg.css',
            //'style.css',
            'edit_style.css',
            'responsive.css',
            'tablet.css'
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
            'kinyu/slick.min.js',
            'kinyu/instafeed.min.js',
            'kinyu/main.js',
            // 必要
            'kinyu/swiper.min.js',
            'kinyu/jquery.bxslider.min.js',
            //'https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js'
            //'kinyu/drawer.min.js'
        ), array(), 'layout', false);

        set_exception_handler(function ($e) {
            $this->error($e->getMessage());
        });


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
}
