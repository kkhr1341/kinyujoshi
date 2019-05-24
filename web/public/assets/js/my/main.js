$(function() {

  $('#toggle').click(function() {
     //$(this).toggleClass('activemenu');
    $('#overlay').fadeIn(500);
    if($('#hnave').hasClass('off')){
      $('#hnave').removeClass('off');
      $('#hnave').css('transform','translate3d(0px, 0px, 0px)');
      //$('.body-inner').css('position','fixed');
    }else{
      $('#overlay').fadeOut(500);
      $('#hnave').addClass('off');
      $('#hnave').css('transform','translate3d(-300px, 0px, 0px)');
      $('.body-el').css('position','relative');
    }
  });

  $('#hnavi-close').click(function() {
    $('#overlay').fadeOut(500);
    $('#hnave').addClass('off');
    $('#hnave').css('transform','translate3d(-300px, 0px, 0px)');
    $('.body-el').css('position','relative');
  });    

  $('#pc-tsubuyaki').on('click',function(){
    if($('#slideL').hasClass('off')){
      $('#slideL').removeClass('off');
      $('#slideL').animate({'marginRight':'310px'},300).addClass('on');
    }else{
      $('#slideL').addClass('off');
      $('#slideL').animate({'marginRight':'0px'},300);
    }
  });
  $('.pc-kuchikomi-close-btn').on('click',function(){
      $('#slideL').addClass('off');
      $('#slideL').animate({'marginRight':'0px'},300);
  });

  $(window).load(function() {
    setTimeout(function() {
      $(".left-pos").animate({left: '-10px' }, {queue:false,duration:2000});
      $(".right-pos").animate({right: '-10px' }, {queue:false,duration:2000});
    },3000); //扉部分
  });

});


//テキスト関連
jQuery(function($) {
  $('.admin-normal-joshikai li .text-box .title-text').each(function() {
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
});