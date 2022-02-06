<?php

class Controller_Kinyu_Campaign extends Controller_Kinyubase
{

    public function action_school()
    {
        $this->template->title = '私立きんゆう女子。学院｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-gakuin.jpg';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/campaign/school.smarty', $this->data);
    }

    public function action_school_public()
    {
        $this->template->title = 'きんゆう女子。学院｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/school_public/og-school_public.png';
        $this->template->description = 'きんゆう女子。学院は、私立きんゆう女子。学院の姉妹校です♪ きんゆう女子学院にも科目があります。きんゆう女子学院では、文系科目をメインにバランスよく多角的に金融の全体像から考え方、普段の生活に役立つことを学びます。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/campaign/school_public.smarty', $this->data);
    }


    // 第2回きんゆう女子。学院
    public function action_school_02()
    {
        $this->template->title = '第2回 きんゆう女子。学院｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/school_public/og-school_public02.jpg';
        $this->template->description = 'きんゆう女子。学院は、私立きんゆう女子。学院の姉妹校です♪ きんゆう女子。学院にも科目があります。きんゆう女子。学院では、文系科目をメインにバランスよく多角的に金融の全体像から考え方、普段の生活に役立つことを学びます。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/campaign/school_02.smarty', $this->data);
    }

    public function action_conference()
    {
        // Basic認証
        $this->set_basic_auth('kinyu_conference', 'N8vJc4RD');

        $this->template->title = '第1回 週末投資宣言♪｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-conference.jpg';
        $this->template->description = '宣誓！わたしたちは、投資の本質を知り正々堂々とおかねを増やすことを誓います！わたしたちは、週末時間をゆたかで楽しい人生にするために。正しいおかねの知識と意識を身につけ前向きに投資をしていきます。投資の一歩手前の準備をしっかりしてすてきな投資家になり、経済に参加します。このイベントでは、その誓いを宣言し第一歩を踏み出すきっかけを自ら作ります。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/campaign/conference.smarty', $this->data);
    }

    public function action_daijoshikai2018()
    {

        $this->template->title = 'ひみつの大女子会♪ 2018｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/daijoshikai2018/daijoshikai2018_fb.jpg';
        $this->template->description = '東証さんってどんなところ？金運スポットやワクワクがいっぱい？無機質な数字ばっかり？ニュース番組などでみかける、くるくる回る掲示板。テレビでは見たことはあるけれど、建物の中はどんなところ？実は平日16:00までは誰でも見学ができる東証さん。タイミングを合わせれば、企業の上場するシーンも見学することもできます。そんな東証さんの夜の時間帯に、おじゃまして贅沢に貸し切って、大納会・大発会ならぬ、大女子会を開催します。';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/campaign/daijoshikai2018.smarty', $this->data);
    }

    public function action_ooedoonsen_joshikai()
    {

        $this->template->title = '大江戸温泉できんゆう女子会。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/ooedo_joshikai/oom-reit-og.jpg';
        $this->template->description = '今回の特別女子会は、ついに実現！みんなで日帰り温泉で女子会♪テーマは、不動産投資信託（REIT：りーと）についてです。よくワカラナイままにしていた、投資信託についてもふれます。まずは、単語からお勉強しましょう！。';
        $this->template->keyword = 'きんゆう女子,お金,リート,温泉,大江戸温泉';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/campaign/ooedoonsen_joshikai.smarty', $this->data);
    }

    public function action_ooedojoshikai_2018()
    {

        $this->template->title = '【伊東編】大江戸温泉できんゆう女子。会';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/ooedo_joshikai2018/main-og.jpg';
        $this->template->description = '今回の特別女子会は、ついに実現！みんなで日帰り温泉で女子会♪テーマは、不動産投資信託（REIT：りーと）についてです。よくワカラナイままにしていた、投資信託についてもふれます。まずは、単語からお勉強しましょう！。';
        $this->template->keyword = 'きんゆう女子,お金,リート,温泉,大江戸温泉';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/campaign/ooedojoshikai_2018.smarty', $this->data);
    }

    public function action_celebration_20171206()
    {
        $this->template->title = 'kinjo1000！Celebration｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/celebration/og-fb.jpg';
        $this->template->description = '';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/campaign/celebration_20171206.smarty', $this->data);
    }

    public function action_oyakudachi()
    {
        if (!Auth::check()) {
      $after_login_url = \Uri::current() ? \Uri::current() : '/my';
      \Auth::logout();
      Response::redirect('/login?after_login_url=' . $after_login_url);
      exit();
    }
        $this->template->title = '金融機関さんのお役立ち情報';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/content/celebration/og-fb.jpg';
        $this->template->description = '';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/campaign/oyakudachi.smarty', $this->data);
    }
}