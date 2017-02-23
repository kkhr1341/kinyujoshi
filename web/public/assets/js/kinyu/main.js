$(function() {
  // ナビ・ツールチップ 
  var toolheight01 = $(".kinyu-main-menu li:nth-child(1n) .tool-chip").innerHeight();
  var toolheight02 = $(".kinyu-main-menu li:nth-child(2n) .tool-chip").innerHeight();
  var toolheight03 = $(".kinyu-main-menu li:nth-child(3n) .tool-chip").innerHeight();
  var toolheight04 = $(".kinyu-main-menu li:nth-child(4n) .tool-chip").innerHeight();
  var toolheight05 = $(".kinyu-main-menu li:nth-child(5n) .tool-chip").innerHeight();
  var toolheight06 = $(".kinyu-main-menu li:nth-child(6n) .tool-chip").innerHeight();

  // メニュー部分のコンテンツ
  var menucontentheight01 = $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(1n) p").innerHeight();
  var menucontentheight02 = $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(2n) p").innerHeight();
  var menucontentheight03 = $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(3n) p").innerHeight();
  var menucontentheight04 = $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(4n) p").innerHeight();
  var menucontentheight05 = $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(1n) p").innerHeight();
  var menucontentheight06 = $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(2n) p").innerHeight();
  var menucontentheight07 = $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(3n) p").innerHeight();

  // css
  $(".kinyu-main-menu li:nth-child(1n) .tool-chip").css('margin-top',-toolheight01 / 2);
  $(".kinyu-main-menu li:nth-child(2n) .tool-chip").css('margin-top',-toolheight02 / 2);
  $(".kinyu-main-menu li:nth-child(3n) .tool-chip").css('margin-top',-toolheight03 / 2);
  $(".kinyu-main-menu li:nth-child(4n) .tool-chip").css('margin-top',-toolheight04 / 2);
  $(".kinyu-main-menu li:nth-child(5n) .tool-chip").css('margin-top',-toolheight05 / 2);
  $(".kinyu-main-menu li:nth-child(6n) .tool-chip").css('margin-top',-toolheight06 / 2);

  $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(1n) p").css('margin-top',-menucontentheight01 / 2);
  $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(2n) p").css('margin-top',-menucontentheight02 / 2);
  $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(3n) p").css('margin-top',-menucontentheight03 / 2);
  $(".navi_kinyu-menu-li01 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(4n) p").css('margin-top',-menucontentheight04 / 2);
  $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(1n) p").css('margin-top',-menucontentheight05 / 2);
  $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(2n) p").css('margin-top',-menucontentheight06 / 2);
  $(".navi_kinyu-menu-li02 .navi_kinyu-menu-block .navi_kinyu-menu-block-el:nth-child(3n) p").css('margin-top',-menucontentheight07 / 2);
  //$(".kinyu-top-introlist .inner").css('margin-top',-maintitleww / 2);
  // マウスオーバーの指定
  // $(".kinyu-main-manu li:nth-child(1n)").mouseover(function(){
  //   $(this).children(".tool-chip").fadeIn(100);
  // }).mouseout(function(){
  //   $(this).children(".tool-chip").fadeOut(100);
  // });

  // $(".kinyu-main-manu li").mouseover(function(){
  //   $(this).children(".tool-chip").css('display','block');
  // }).mouseout(function(){
  //   $(this).children(".tool-chip").css('display','none');
  // });
});

$(function() {

  var ua = navigator.userAgent.toUpperCase();
  if(ua.indexOf('IPHONE') != -1 || (ua.indexOf('ANDROID') != -1 && ua.indexOf('MOBILE') != -1)) {
    // スマホ
    var state = false;
    var scrollpos;
    $(".kinyu-sp-header-menu").click(function() {
      $(".kinyu-sp-header-menu").toggleClass("active");
      $(".kinyu-main").toggleClass("sssss");
      $(".kinyu-sp-navi").fadeToggle(800);
      $(".navi_contents-block").slideToggle(500);

      if(state == false) {
        scrollpos = $(window).scrollTop();
        $('body').addClass('fixed').css({'top': -scrollpos});
        $('.kinyu-sp-navi').addClass('open');
        state = true;
      } else {
        $('body').removeClass('fixed').css({'top': 0});
        window.scrollTo( 0 , scrollpos );
        $('.kinyu-sp-navi').removeClass('open');
        state = false;
      }
    });

  } else {
    //PC
    var state = false;
    var scrollpos;
    $(".menu-trigger").click(function() {
      $(".menu-trigger").toggleClass("active");
      $(".navi_contents-block").slideToggle(500);

      setTimeout(function(){
        if(state == false) {
          scrollpos = $(window).scrollTop();
          $('body').addClass('fixed').css({'top': -scrollpos});
          $('.navi_contents-block').addClass('open');
          state = true;
        } else {
          $('body').removeClass('fixed').css({'top': 0});
          window.scrollTo( 0 , scrollpos );
          $('.navi_contents-block').removeClass('open');
          state = false;
        }
      },200);
    });
  }
});

//テキスト関連
jQuery(function($) {

  $('.news-sp-block .text-area .news-title').each(function() {
    var $target = $(this);
 
    // オリジナルの文章を取得する
    var html = $target.html();
 
    // 対象の要素を、高さにautoを指定し非表示で複製する
    var $clone = $target.clone();
    $clone
      .css({
        display: 'none',
        position : 'absolute',
        overflow : 'visible'
      })
      .width($target.width())
      .height('auto');
 
    // DOMを一旦追加
    $target.after($clone);
 
    // 指定した高さになるまで、1文字ずつ消去していく
    while((html.length > 0) && ($clone.height() > $target.height())) {
      html = html.substr(0, html.length - 1);
      $clone.html(html + '...');
    }
    // 文章を入れ替えて、複製した要素を削除する
    $target.html($clone.html());
    $clone.remove();
  });

  $('.kinyu-top-introlist-news .text-area .news-title').each(function() {
    var $target = $(this);
    // オリジナルの文章を取得する
    var html = $target.html();
    // 対象の要素を、高さにautoを指定し非表示で複製する
    var $clone = $target.clone();
    $clone
      .css({
        display: 'none',
        position : 'absolute',
        overflow : 'visible'
      })
      .width($target.width())
      .height('auto');
    // DOMを一旦追加
    $target.after($clone);
    // 指定した高さになるまで、1文字ずつ消去していく
    while((html.length > 0) && ($clone.height() > $target.height())) {
      html = html.substr(0, html.length - 1);
      $clone.html(html + '...');
    }
    // 文章を入れ替えて、複製した要素を削除する
    $target.html($clone.html());
    $clone.remove();
  });

  $('.news-sp-block .text-area .news-title').each(function() {
    var $target = $(this);
 
    // オリジナルの文章を取得する
    var html = $target.html();
 
    // 対象の要素を、高さにautoを指定し非表示で複製する
    var $clone = $target.clone();
    $clone
      .css({
        display: 'none',
        position : 'absolute',
        overflow : 'visible'
      })
      .width($target.width())
      .height('auto');
 
    // DOMを一旦追加
    $target.after($clone);
 
    // 指定した高さになるまで、1文字ずつ消去していく
    while((html.length > 0) && ($clone.height() > $target.height())) {
      html = html.substr(0, html.length - 1);
      $clone.html(html + '...');
    }
    // 文章を入れ替えて、複製した要素を削除する
    $target.html($clone.html());
    $clone.remove();
  });

  var ua = navigator.userAgent.toUpperCase();
  if(ua.indexOf('IPHONE') != -1 || (ua.indexOf('ANDROID') != -1 && ua.indexOf('MOBILE') != -1)) {
  
    // スマホ
    $(".kinyu-top-list-title").each(function(){
      var txt = $(this).text();
      if(txt.length > 32){
        txt = txt.substr(0, 32);
        $(this).text(txt + "...");
      }
    });

    } else {

    $(".kinyu-top-introlist-pickup .kinyu-top-list-title").each(function(){
      var txt = $(this).text();
      if(txt.length > 50){
        txt = txt.substr(0, 50);
        $(this).text(txt + "...");
      }
    });
  
    $(".kinyu-top-list-title").each(function(){
      var txt = $(this).text();
      if(txt.length > 36){
        txt = txt.substr(0, 36);
        $(this).text(txt + "...");
      }
    });

  }
});

//ページ読み込み時のアニメーション
$(document).ready(function(){

  var state = false;
  var scrollpos;

  if(state == false) {
    scrollpos = $(window).scrollTop();
    $('body').addClass('fixed').css({'top': -scrollpos});
    state = true;
  } else {
    $('body').removeClass('fixed').css({'top': 0});
    window.scrollTo( 0 , scrollpos );
    state = false;
  }

  var ua = navigator.userAgent.toUpperCase();
  if(ua.indexOf('IPHONE') != -1 || (ua.indexOf('ANDROID') != -1 && ua.indexOf('MOBILE') != -1)) {

    //スマホ
    $(".kinyu-main-animation-sub").fadeIn(1000);
      $(".kinyu-main-animation-title").fadeIn(1000);
    setTimeout(function(){
      $(".kinyu-main-animation-inner").fadeOut(500);  
    },2000);
    setTimeout(function(){
      $(".kinyu-main-animation").fadeOut(1000);
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      state = false;
    },2500);

  } else {

    //pc
    $(".kinyu-main-animation-sub").fadeIn(800);
    setTimeout(function(){
      $(".kinyu-main-animation-title").fadeIn(800);
    },500);
    setTimeout(function(){
      $(".kinyu-main-animation-inner").fadeOut(500);  
    },1500);
    setTimeout(function(){
      $(".kinyu-main-animation").fadeOut(1000);
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      state = false;
    },2000);
  }
});

// // メニューの開閉ボタン
// $(function() {//$(".header-menu").fadeIn(1000);

// 	$('#toggle').click(function() {
//    	 //$(this).toggleClass('activemenu');
//    	$('#overlay').fadeIn(500);
//     if($('#hnave').hasClass('off')){
//       $('#hnave').removeClass('off');
//       $('#hnave').css('transform','translate3d(0px, 0px, 0px)');
//       //$('.body-inner').css('position','fixed');
//     }else{
//       $('#overlay').fadeOut(500);
//       $('#hnave').addClass('off');
//       $('#hnave').css('transform','translate3d(-300px, 0px, 0px)');
//       $('.body-el').css('position','relative');
//     }
// 	});

//   $('#hnavi-close').click(function() {
//     $('#overlay').fadeOut(500);
//     $('#hnave').addClass('off');
//     $('#hnave').css('transform','translate3d(-300px, 0px, 0px)');
//     $('.body-el').css('position','relative');
//   });    

//   $('#pc-tsubuyaki').on('click',function(){
//     if($('#slideL').hasClass('off')){
//       $('#slideL').removeClass('off');
//       $('#slideL').animate({'marginRight':'310px'},300).addClass('on');
//     }else{
//       $('#slideL').addClass('off');
//       $('#slideL').animate({'marginRight':'0px'},300);
//     }
//   });
//   $('.pc-kuchikomi-close-btn').on('click',function(){
//       $('#slideL').addClass('off');
//       $('#slideL').animate({'marginRight':'0px'},300);
//   });
// });

// $(function() {
//   $('.kuchikomi-bottom-box').click(function() {
//     $('.nyoki').slideDown();
//   });
//   $('.kuchikomi-close-btn').click(function() {
//     $('.nyoki').slideUp();
//   });
// });

// $(function() {
//   $('.kuchikomi-popup-close-btn').click(function() {
//     $('.kuchikomi-after-popup').fadeOut();
//   });
// });

//スクロール関係の処理
$(function() {
  //現在位置のスクロール位置を取得
  $(window).scroll(function() {
    // 現在のスクロール位置
    var now_scroll = jQuery(this).scrollTop();
    // スクロールポイント01の座標を指定

    var scroll_01 = $("#scroll-point01");
    var sidebar_fix_point = $("#sidebar_fix_point");

    if(now_scroll > 500) {
      $(".pc-top-side").addClass("top_fixed");
    }  else if (now_scroll < 500) {
      $(".pc-top-side").removeClass("top_fixed");
    }

    if(now_scroll > 230) {
      $(".pc-side").addClass("fixed");
    }  else if (now_scroll < 230) {
      $(".pc-side").removeClass("fixed");
    }

    var wT = $(window).height();
    var wH = $('body').height() - wT;

    if(wH == now_scroll) {
      $(".footer-sub-box").fadeIn(500);
    } else {
    }

    if(500 < now_scroll) {
      $(".page-top").fadeIn();
    } else if(now_scroll > 200){
      $(".page-top").fadeOut();
    } else if(now_scroll == 0) {
      $(".page-top").fadeOut();
    }

	});
  // $('.drawer').drawer();
});

$(function() {
  $('.radio_box label').on('click', function(){
    $('.radio_box input[type="radio"]').prop('checked', true);
  });
});

$(function() {
  $('.radio_box_02 label').on('click', function(){
    $('.radio_box_02 input[type="radio"]').prop('checked', true);
  });
});

// インスタグラム
// $(document).ready(function() {
//     var userFeed = new Instafeed({
//         get: 'user', //ユーザーから取得
//         userId: '3007140595', //ユーザーID(数字のみのもの)
//         sortBy:'random', //並び順をランダムに
//         links: true , //画像リンク取得
//         limit: 20, //取得する画像数を設定
//         resolution: 'standard_resolution', //画像サイズを設定
//         template: '<li><a href="{{link}}" target="_blank" style="background: url({{image}}) center center / cover no-repeat;"></a></li>',
//         //template: '<li><a href="{{link}}" target="_blank"><img src="{{image}}"></a><span>{{caption}}</span><span>like:{{likes}},comments:{{comments}}</span></li>',
//         accessToken: '3007140595.1e3d504.e017055f3cc649ddacf9758314e4628a' //アクセストークン(ローカル)
//         //accessToken: '3138253426.c590f97.dbb4ca68d4c44bd0a2e811a5adbe5fea' //アクセストークン(サーバー)
//     });
//     userFeed.run();
// });

// ページ内スムーズスクロール
$(function() {
  $('a[href^=#]').click(function() {
      // スクロールの速度
      var speed = 800; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});


// リセアパルトマン・画像ランダム表示
$(function() {
  var img = new Array();
  img[0] = "images/banner/lycee/lycee01.jpg";
  img[1] = "images/banner/lycee/lycee02.jpg";
  img[2] = "images/banner/lycee/lycee03.jpg";
  img[3] = "images/banner/lycee/lycee04.jpg";
  n = Math.floor(Math.random()*img.length);
});


