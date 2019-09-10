/*

PC & スマホ & タブレット共通

*/

//メインビジュアル
ScrollReveal().reveal('.mv-animation-01', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.mv-animation-02', { easing: 'ease', origin: 'bottom', delay: 500, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.mv-animation-03', { easing: 'ease', origin: 'left', delay: 1000, duration: 2500, distance: '50px', opacity: 0, scale: 1 });

//ノーマルアニメーション
ScrollReveal().reveal('.normal-animation-top', { easing: 'ease', origin: 'top', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.normal-animation-bottom', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.normal-animation-left', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.normal-animation-right', { easing: 'ease', origin: 'right', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.normal-animation-fix', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '0px', opacity: 0, scale: 1 });

//リストアニメーション
if (
	navigator.userAgent.indexOf('iPhone') > 0 ||
	navigator.userAgent.indexOf('iPad') > 0 ||
	navigator.userAgent.indexOf('iPod') > 0 ||
	navigator.userAgent.indexOf('Android') > 0 )
{
	/*
	スマホ & タブレットのみ
	*/

	// リストアニメーション
	ScrollReveal().reveal('.list-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-02', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-03', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-04', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-05', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-06', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-07', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-08', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-09', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-10', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//サービス詳細
	ScrollReveal().reveal('.service-details-animation-header01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.service-details-animation-header02', { easing: 'ease', origin: 'right', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//WEB簡単登録
	ScrollReveal().reveal('.web-regist-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.web-regist-animation-02', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//メディカルサポートコンテンツ
	ScrollReveal().reveal('.medical-description-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.medical-description-animation-02', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//ヘルスケアサービス
	ScrollReveal().reveal('.mentalhealt-el-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.mentalhealt-el-animation-02', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//相談解答例
	ScrollReveal().reveal('.doctersme-chat-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.doctersme-chat-animation-02', { easing: 'ease', origin: 'right', duration: 2500, distance: '30px', opacity: 0, scale: 1 });

} else {
	/*
	PCのみ
	*/

	//リストアニメーション
	ScrollReveal().reveal('.list-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-02', { easing: 'ease', origin: 'left', delay: 200, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-03', { easing: 'ease', origin: 'left', delay: 400, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-04', { easing: 'ease', origin: 'left', delay: 600, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-05', { easing: 'ease', origin: 'left', delay: 800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-06', { easing: 'ease', origin: 'left', delay: 1000, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-07', { easing: 'ease', origin: 'left', delay: 1200, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-08', { easing: 'ease', origin: 'left', delay: 1400, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-09', { easing: 'ease', origin: 'left', delay: 1600, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.list-animation-10', { easing: 'ease', origin: 'left', delay: 1800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//サービス詳細
	ScrollReveal().reveal('.service-details-animation-header01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.service-details-animation-header02', { easing: 'ease', origin: 'right', delay: 500, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//WEB簡単登録
	ScrollReveal().reveal('.web-regist-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.web-regist-animation-02', { easing: 'ease', origin: 'left', delay: 800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//メディカルサポートコンテンツ
	ScrollReveal().reveal('.medical-description-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.medical-description-animation-02', { easing: 'ease', origin: 'left', delay: 800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//ヘルスケアサービス
	ScrollReveal().reveal('.mentalhealt-el-animation-01', { easing: 'ease', origin: 'left', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.mentalhealt-el-animation-02', { easing: 'ease', origin: 'bottom', delay: 800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

	//相談解答例
	ScrollReveal().reveal('.doctersme-chat-animation-01', { easing: 'ease', origin: 'left', delay: 400, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
	ScrollReveal().reveal('.doctersme-chat-animation-02', { easing: 'ease', origin: 'right', delay: 800, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

}






//TOP - 背景部分
ScrollReveal().reveal('.logo-animation', { easing: 'ease', origin: 'bottom', duration: 3000, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.intro-bg1', { easing: 'ease', origin: 'bottom', delay: 300, duration: 2500, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.intro-bg2', { easing: 'ease', origin: 'bottom', delay: 600, duration: 2500, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.intro-bg3', { easing: 'ease', origin: 'bottom', delay: 900, duration: 2500, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.intro-bg4', { easing: 'ease', origin: 'bottom', delay: 1200, duration: 2500, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.intro-title-animation', { easing: 'ease', origin: 'bottom', delay: 1500, duration: 3000, distance: '5px', opacity: 0, scale: 1 });

//message-main
ScrollReveal().reveal('.message-animation1', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.message-animation2', { easing: 'ease', origin: 'left', delay: 500, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.message-animation3', { easing: 'ease', origin: 'right', delay: 300, duration: 3000, distance: '50px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.message-animation4', { easing: 'ease', origin: 'right', delay: 800, duration: 3000, distance: '50px', opacity: 0, scale: 1 });

ScrollReveal().reveal('.fix-animation1', { easing: 'ease', origin: 'bottom', duration: 2500, distance: '0px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.fix-animation1-title', { easing: 'ease', origin: 'bottom', delay: 500, duration: 2500, distance: '0px', opacity: 0, scale: 1 });


//キャッシュレス
ScrollReveal().reveal('.cashless-animation1', { easing: 'ease', origin: 'bottom', duration: 3000, distance: '50px', opacity: 0, scale: 1 });

// article
ScrollReveal().reveal('.article-animation-top-left', { easing: 'ease', origin: 'left', delay: 500, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-top-left2', { easing: 'ease', origin: 'left', delay: 1000, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

ScrollReveal().reveal('.article-animation-episode', { easing: 'ease', origin: 'top', delay: 500, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-episode2', { easing: 'ease', origin: 'top', delay: 1000, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-episode3', { easing: 'ease', origin: 'top', delay: 1100, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

ScrollReveal().reveal('.article-animation-left', { easing: 'ease', origin: 'left', delay: 300, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-left1', { easing: 'ease', origin: 'top', delay: 600, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-left2', { easing: 'ease', origin: 'top', delay: 900, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

ScrollReveal().reveal('.article-animation-right', { easing: 'ease', origin: 'right', delay: 300, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-right1', { easing: 'ease', origin: 'top', delay: 600, duration: 2500, distance: '30px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.article-animation-right2', { easing: 'ease', origin: 'top', delay: 900, duration: 2500, distance: '30px', opacity: 0, scale: 1 });

// illust
ScrollReveal().reveal('.illust-animation1', { easing: 'ease', origin: 'right', delay: 800, duration: 3000, distance: '50px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.illust-animation2', { easing: 'ease', origin: 'left', delay: 800, duration: 3000, distance: '50px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.illust-animation-dog1', { easing: 'ease', delay: 1500, duration: 2000, distance: '10px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.illust-animation-dog2', { easing: 'ease', delay: 2500, duration: 2000, distance: '10px', opacity: 0, scale: 1 });
ScrollReveal().reveal('.illust-animation-dog3', { easing: 'ease', delay: 3000, duration: 2000, distance: '10px', opacity: 0, scale: 1 });


$(function(){
	// 設定
	var windowWidth = $(window).width();
	var slideheight = $('.article-container .article-bg').height();
	var $width = windowWidth; // 横幅
	var $height = slideheight; // 高さ
	var $interval = 4000; // 切り替わりの間隔（ミリ秒）
	var $fade_speed = 3000; // フェード処理の早さ（ミリ秒）
	$(".article-container .article-bg-img ul li").css({"position":"relative","overflow":"hidden","width":$width,"height":$height});
	$(".article-container .article-bg-img ul li").hide().css({"position":"absolute","top":0,"left":0});
	$(".article-container .article-bg-img ul li:first").addClass("active").show();
	setInterval(function(){
	var $active = $(".article-container .article-bg-img ul li.active");
	var $next = $active.next("li").length?$active.next("li"):$(".article-container .article-bg-img ul li:first");
	$active.fadeOut($fade_speed).removeClass("active");
	$next.fadeIn($fade_speed).addClass("active");
	},$interval);
});

$(function(){
	// 設定
	var topWidth = $('.article-bg-img1').width();
	var topheight = $('.article-bg-img1').height();
	var $width = topWidth; // 横幅
	var $height = topheight; // 高さ
	var $interval = 3000; // 切り替わりの間隔（ミリ秒）
	var $fade_speed = 2000; // フェード処理の早さ（ミリ秒）
	$(".cashlesslife-list .article-bg-img1 ul li").css({"position":"relative","overflow":"hidden","width":$width,"height":$height});
	$(".cashlesslife-list .article-bg-img1 ul li").hide().css({"position":"absolute","top":0,"left":0});
	$(".cashlesslife-list .article-bg-img1 ul li:first").addClass("active").show();
	setInterval(function(){
	var $active = $(".cashlesslife-list .article-bg-img1 ul li.active");
	var $next = $active.next("li").length?$active.next("li"):$(".cashlesslife-list .article-bg-img1 ul li:first");
	$active.fadeOut($fade_speed).removeClass("active");
	$next.fadeIn($fade_speed).addClass("active");
	},$interval);
});

$(function(){
	// 設定
	var topWidth = $('.article-bg-img2').width();
	var topheight = $('.article-bg-img2').height();
	var $width = topWidth; // 横幅
	var $height = topheight; // 高さ
	var $interval = 3000; // 切り替わりの間隔（ミリ秒）
	var $fade_speed = 2000; // フェード処理の早さ（ミリ秒）
	$(".cashlesslife-list .article-bg-img2 ul li").css({"position":"relative","overflow":"hidden","width":$width,"height":$height});
	$(".cashlesslife-list .article-bg-img2 ul li").hide().css({"position":"absolute","top":0,"left":0});
	$(".cashlesslife-list .article-bg-img2 ul li:first").addClass("active").show();
	setInterval(function(){
	var $active = $(".cashlesslife-list .article-bg-img2 ul li.active");
	var $next = $active.next("li").length?$active.next("li"):$(".cashlesslife-list .article-bg-img2 ul li:first");
	$active.fadeOut($fade_speed).removeClass("active");
	$next.fadeIn($fade_speed).addClass("active");
	},$interval);
});