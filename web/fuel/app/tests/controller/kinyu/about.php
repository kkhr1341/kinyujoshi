<?php

/**
 * Tests for Controller_Kinyu_About
 *
 * @group  App
 */
class Test_Controller_Kinyu_About extends \TestCase
{
    public function test_index_status(){
        $response = Request::forge('kinyu/about')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

    public function test_about_contents_status(){
        $response = Request::forge('kinyu/about/about_contents')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

    public function test_about_story_status(){
        $response = Request::forge('kinyu/about/about_story')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

    public function test_about_policy_status(){
        $response = Request::forge('kinyu/about/about_policy')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

    public function test_about_design_status(){
        $response = Request::forge('kinyu/about/about_design')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

    public function test_about_hensyubu_status(){
        $response = Request::forge('kinyu/about/about_hensyubu')
            ->set_method('GET')
            ->execute()
            ->response();
        $test = $response->status; // ステータスコードを取得
        $expected = 200;
        $this->assertEquals($expected, $test);
    }

//    public function test_edit_index_status(){
//        $response = Request::forge('kinyu/edit_index')
//            ->set_method('GET')
//            ->execute()
//            ->response();
//        $test = $response->status; // ステータスコードを取得
//        $expected = 200;
//        $this->assertEquals($expected, $test);
//    }

//    public function test_myplan_status(){
//        $response = Request::forge('kinyu/myplan')
//            ->set_method('GET')
//            ->execute()
//            ->response();
//        $test = $response->status; // ステータスコードを取得
//        $expected = 200;
//        $this->assertEquals($expected, $test);
//    }
}