<?php

class Controller_Error_500 extends Controller_Kinyubase
{

    public function action_index($e)
    {
        $this->template->title = '大変申し訳ございません。お探しのページは存在しないようです。';
        $this->template->description = '大変申し訳ございません。お探しのページは存在しないようです。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/error/500.smarty', $this->data);
    }
}
