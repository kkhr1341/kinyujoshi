<?php
return array(
	'_root_'  => 'kinyu/top',  // The default route
	//'_root_'  => 'maintenance/top',
	'_404_'   => '/404',    // The main 404 route
	'_500_'   => '/500',    // The main 404 route
	'page/(:any)'   => 'page/top/$1',

	//メンテナンス
	'maintenance'  => 'maintenance/top',

	//◆メンバー登録/ログイン部分
	'login_regist'   => 'login/regist',
	'regist_email'   => 'login/regist_email',
	'regist_sns'   => 'login/regist_sns',
	'resetting_pass' => 'login/resetting_pass',
	'resetting_pass_exuser' => 'login/resetting_pass_exuser',
	'regist_complete' => 'login/complete',

	//テスト環境
	'testindex' => 'kinyu/top/testindex',
	'testsp' => 'kinyu/top/testspindex',

	// きんゆう女子。
	'kinyu'   => 'kinyu/top',

	// はじめての方へ
	'start'   => 'kinyu/start/index',

	//aboutページ
	'about' => 'kinyu/about/index',
	'about_main' => 'kinyu/about/about_main',
	'about_contents' => 'kinyu/about/about_contents',
	'about_story' => 'kinyu/about/about_story',
	'about_policy' => 'kinyu/about/about_policy',
	'about_design' => 'kinyu/about/about_design',
	'about_hensyubu' => 'kinyu/about/about_hensyubu',

	'report'   => 'kinyu/blog/index',
	'report/(:num)'   => 'kinyu/blog/index/$1',
	'report/(:any)'   => 'kinyu/blog/detail/$1',
	'welcome/blog/(:any)'   => 'kinyu/blog/welcome/$1',
	'rsss'   => 'kinyu/rss/index',
	'rss/(:num)'   => 'kinyu/rss/index/$1',
	'rss/(:any)'   => 'kinyu/rss/detail/$1',

	//myplan
	'myway' => 'kinyu/myway/index',

	//未公開
	'gallery' => 'kinyu/gallery/index',
	//'event/schedule'   => 'kinyu/event/schedule',
	//'event/(:num)'   => 'kinyu/event/index/$1',
	//'event/(:any)'   => 'kinyu/event/detail/$1',
	//'welcome/event'   => 'kinyu/event/welcome',

	//イベント関連
	'joshikai'   => 'kinyu/event/index',
	'joshikai_past'   => 'kinyu/event/past',
	'joshikai/(:any)'   => 'kinyu/event/detail/$1',
	'joshikai_tickets/(:any)'   => 'kinyu/event/tickets/$1',
	'joshikai_payment_card/(:any)'   => 'kinyu/event/tickets_card/$1',
	'joshikai_payment_cash/(:any)'   => 'kinyu/event/tickets_cash/$1',
	'joshikai_complete'   => 'kinyu/event/complete',

	//ニュース
	'news'   => 'kinyu/news/index',
	'news/1'   => 'kinyu/news/index',
	'news/(:num)'   => 'kinyu/news/index/$1',
	'news/(:any)'   => 'kinyu/news/detail/$1',

	//お問い合わせ
	'contact' => 'kinyu/inquiry',
	'contact/complete' => 'kinyu/inquiry/complete',

    //退会完了ページ
    'withdrawal/complete' => 'kinyu/withdrawal/complete',

	//会員登録
	'regist' => 'kinyu/regist',
	'regist/complete' => 'kinyu/regist/complete',

	//きんゆうのワカラナイをリクエスト
	'request' => 'kinyu/kuchikomi',
	'request/complete' => 'kinyu/kuchikomi/complete',

	// 会社概要
	'company' => 'kinyu/company/index',

	//利用規約
	'service' => 'kinyu/company/service',

	//プライバシーポリシー
	'privacy' => 'kinyu/company/privacy',

	//特定商取引法に基づく表記
	'legal' => 'kinyu/company/legal',

		//企業用ページ
	'business' => 'kinyu/company/business',

	//キャンペーン
	'school' => 'kinyu/campaign/school',
	'school_jpx' => 'kinyu/campaign/school_public',
	'conference' => 'kinyu/campaign/conference',
	'map' => 'kinyu/campaign/map',
	'oom-reit' => 'kinyu/campaign/ooedoonsen_joshikai',
	'ooam-joshikai2018' => 'kinyu/campaign/ooedojoshikai_2018',
	'celebration' => 'kinyu/campaign/celebration_20171206',
	'daijoshikai2018' => 'kinyu/campaign/daijoshikai2018',
	'school_jpx02' => 'kinyu/campaign/school_02',

	'blog/page/(:any)'   => 'kinyu/blog/page/index/$1',
	'event/page/(:any)'   => 'kinyu/event/page/index/$1',
	'project'   => 'kinyu/project/index',
	'project/(:num)'   => 'kinyu/project/index/$1',
	'project/(:any)'   => 'kinyu/project/detail/$1',

	// きんゆうマップ
	'kinyu_map' => 'kinyu/campaign/kinyu_map',
	'map_ooedoito' => 'kinyu/kinyumap/ooedo_ito',

	//マイページ - トップ
	'my'   => 'my/top',
	//マイページ - プロフィール、女子会リスト
	'my/profile'   => 'my/profile/index',
	'my/account'   => 'my/account/index',
	'my/joshikai' => 'my/events/joshikailist',
	'my/joshikai/(:any)' => 'my/events/joshikaidetail/$1',
	'my/member_joshikai' => 'my/events/member_joshikai',

	'admin'   => 'admin/top',
	//管理画面admin - 会員リスト
	'admin/registlist' => 'admin/registlist/index',
	'admin/registlist/create' => 'admin/registlist/create',
	'admin/registlist/(:any)'   => 'admin/registlist/detail/$1',
	//管理画面admin - 女子会
	'admin/report' => 'admin/blogs/index',
	'admin/report/create' => 'admin/blogs/create',
	'admin/report/edit/(:any)' => 'admin/blogs/edit/$1',
	//管理画面admin - 女子会
	'admin/joshikai' => 'admin/events/index',
	'admin/joshikai/create' => 'admin/events/create',
	'admin/joshikai/edit/(:any)' => 'admin/events/edit/$1',
	'admin/joshikai/attend' => 'admin/events/attend',
	'admin/joshikai/attend/(:any)' => 'admin/events/attend_detail/$1',
	//管理画面admin - ニュース
	'admin/news' => 'admin/news/index',
	'admin/news/create' => 'admin/news/create',
	'admin/news/edit/(:any)' => 'admin/news/edit/$1',
	//管理画面admin - 女子会リマインドメール
	'admin/remindmailtemplates' => 'admin/remindmailtemplates/index',
	'admin/remindmailtemplates/edit/(:any)' => 'admin/remindmailtemplates/edit/$1',
	//管理画面admin - 会員リスト
	'my/projects/courses/create/(:any)'   => 'my/projects/courses_create/$1',
	'my/projects/courses/edit/(:any)'   => 'my/projects/courses_edit/$1',
	'my/projects/blog/create/(:any)'   => 'my/projects/blog_create/$1',
	'my/projects/blog/edit/(:any)'   => 'my/projects/blog_edit/$1',
	//管理画面admin - お問い合わせリスト
	'admin/inquiries' => 'admin/inquiries/index',
);
