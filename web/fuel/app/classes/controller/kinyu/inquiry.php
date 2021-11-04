<?php

use \Model\Categories;

class Controller_Kinyu_Inquiry extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->template->title = 'お問い合わせ｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
        $this->data['categories'] = Categories::lists();

        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/inquiry/index.smarty', $this->data);

    }

    public function action_complete()
    {
        $this->template->title = 'お問い合わせ完了｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/inquiry/complete.smarty', $this->data);
    }
}


