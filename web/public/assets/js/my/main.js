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