<?php

/**
 * Tests for Controller_Kinyu_About
 *
 * @group  App
 */
class Test_Controller_Api_Applications extends \TestCase
{

//    protected function tearDown()
//    {
//        parent::tearDown();
//
//        test::clean();
//    }
    /**
     * @test
     */
    public function 女子会申し込み失敗のテスト()
    {
        $_POST["cardselect"] = "0";
        $response = Request::forge('api/applications/create')
            ->set_method("POST")
            ->execute()
            ->response();
        $response = json_decode($response->body);
        $this->assertEquals('error', $response->api_status);
    }
//    /**
//     * @test
//     */
//    public function 女子会申し込み成功のテスト()
//    {
//        $_POST["cardselect"] = "0";
//        $_POST["event_code"] = "0";
//        $_POST["name"] = "0";
//        $_POST["email"] = "0";
//        $_POST["token"] = "0";
////        test::double('Fuel\Core\Config', ['get' => function ($arg) {
//////            if ($arg === 'foo.bar') {
//////                return 'foo.bar';
//////            } else {
//////                return 'baz';
//////            }
////            return 'baz';
////        }]);
//        $response = Request::forge('api/applications/create')
//            ->set_method("POST")
//            ->execute()
//            ->response();
//        $response = json_decode($response->body);
//        $this->assertEquals('error', $response->api_status);
//    }
}