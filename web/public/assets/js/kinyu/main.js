
//メニュー開閉処理
$(function() {
  var state = false;
  var scrollpos;
  $(".open-navigation").click(function() {
    $(".main-navigation").toggleClass("active");
    $(".kinyu-container").toggleClass("sssss");
    $(".main-navigation").fadeToggle();
    if(state == false) {
      scrollpos = $(window).scrollTop();
      $('body').addClass('fixed').css({'top': -scrollpos});
      $('.main-navigation').addClass('open');
      state = true;
    } else {
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      $('.main-navigation').removeClass('open');
      state = false;
    }
  });
});

//スクロール関係の処理
// $(function() {
//   //現在位置のスクロール位置を取得
//   $(window).scroll(function() {
//     // 現在のスクロール位置
//     var now_scroll = jQuery(this).scrollTop();
//     // スクロールポイント01の座標を指定

//     var scroll_01 = $("#scroll-point01");
//     var sidebar_fix_point = $("#sidebar_fix_point");

//     if(now_scroll > 500) {
//       $(".pc-top-side").addClass("top_fixed");
//     }  else if (now_scroll < 500) {
//       $(".pc-top-side").removeClass("top_fixed");
//     }

//     if(now_scroll > 230) {
//       $(".pc-side").addClass("fixed");
//     }  else if (now_scroll < 230) {
//       $(".pc-side").removeClass("fixed");
//     }

//     var wT = $(window).height();
//     var wH = $('body').height() - wT;

//     if(wH == now_scroll) {
//       $(".footer-sub-box").fadeIn(500);
//     } else {
//     }

//     if(500 < now_scroll) {
//       $(".page-top").fadeIn();
//     } else if(now_scroll > 200){
//       $(".page-top").fadeOut();
//     } else if(now_scroll == 0) {
//       $(".page-top").fadeOut();
//     }

//   });
//   // $('.drawer').drawer();
// });

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

// ページ内スムーズスクロール
$(function() {
  var ua = navigator.userAgent.toUpperCase();
  if(ua.indexOf('IPHONE') != -1 || (ua.indexOf('ANDROID') != -1 && ua.indexOf('MOBILE') != -1)) {
    // スマホ
    $('a[href^=#]').click(function() {
      var speed = 500; // スクロール速度(ミリ秒)
      var href = $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top-46;
      $('html').animate({scrollTop:position}, speed, 'swing');
      return false;
    });
  } else {
    // スマホ
    $('a[href^=#]').click(function() {
      var speed = 500; // スクロール速度(ミリ秒)
      var href = $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top-150;
      $('html').animate({scrollTop:position}, speed, 'swing');
      return false;
    });
  }
});

//画像のみ右クリック禁止
$(function(){
    $("img").on("contextmenu", function(){
        return false;
    })
});

//ヘッダー検索窓（スマホ）
$(function(){
  $("#kinyu-sp-header-search-open").click(function() {
    $(".kinyu-sp-header-search").fadeIn(500);
  });
  $(".kinyu-sp-header-search .close-block").click(function() {
    $(".kinyu-sp-header-search").fadeOut(500);
  });
});

$(function(){
    $('.js-track').click(function(e) {
        gtag('event', 'click', {
            'event_category': $(this).data('category'),
            'event_label': $(this).attr('href'),
            'event_action': $(this).attr('action'),
            'event_value': $(this).attr('value'),
        });
    });
});
