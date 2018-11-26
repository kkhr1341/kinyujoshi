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
});