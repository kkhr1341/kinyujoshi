<?php

class Controller_Kinyu_Withk extends Controller_Kinyubase
{
    public function action_with_bloomoibrillia()
    {
        $this->template->title = 'with×き -東京建物 Brillia Bloomoi-';
        $this->template->ogimg = '/images/withcorporate/bloomoibrillia/ogp.jpg';
        $this->template->description = '東京建物 Brillia Bloomoiさんと3回に渡って行った”住まいを見つめ直す企画会議”そこで出たアイディアを盛り込んだマンション「Brillia 四谷三丁目」が完成しました♪';
        $this->template->keyword = 'きんゆう女子,女子会,東京建物,ブリリアブルーモア,不動産';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withk/with_bloomoibrillia.smarty', $this->data);
    }
}