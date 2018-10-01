//ページ読み込み時のアニメーション
$(document).ready(function(){

  var today = new Date();

  var topAnimationDisplayTime = document.cookie.replace(/(?:(?:^|.*;\s*)top_animation_display_time\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  topAnimationDisplayTime = parseInt(topAnimationDisplayTime, 10) + (60 * 60 * 24 * 1000);

  if (today.getTime() < topAnimationDisplayTime) {
      $("#kinyu-main-animation-inner").hide();
      $("#kinyu-main-animation").hide();
      return;
  }

  document.cookie = "top_animation_display_time=" + today.getTime();

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
    $("#kinyu-main-animation-sub").fadeIn(1000);
    setTimeout(function(){
      $("#kinyu-main-animation-title").fadeIn(1000);
    },500);
    setTimeout(function(){
      $("#kinyu-main-animation-inner").fadeOut(800);  
    },2000);
    setTimeout(function(){
      $("#kinyu-main-animation").fadeOut(1500);
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      state = false;
    },2500);

  } else {

    //pc
    $("#kinyu-main-animation-sub").fadeIn(800);
    setTimeout(function(){
      $("#kinyu-main-animation-title").fadeIn(800);
    },500);
    setTimeout(function(){
      $("#kinyu-main-animation-inner").fadeOut(500);  
    },1500);
    setTimeout(function(){
      $("#kinyu-main-animation").fadeOut(1000);
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      state = false;
    },2000);
  }
});