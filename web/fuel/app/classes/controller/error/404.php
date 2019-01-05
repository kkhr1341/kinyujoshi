<?php

class Controller_Error_404 extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->template->title = '大変申し訳ございません。お探しのページは存在しないようです。';
        $this->template->description = '大変申し訳ございません。お探しのページは存在しないようです。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
        $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/error/404.smarty', $this->data);
    }
}
