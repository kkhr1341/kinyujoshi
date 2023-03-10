//swiper.js→ PC/SP切り替え

$(function () {

  //swiper.js→ PC/SP切り替え
  function device() {
    var ua = navigator.userAgent;

    //スマホ
    if(ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0){
      new Swiper('.pickup-top-slide', {
        autoplay: false,
        loop: false,
        spaceBetween: 0,
        nextButton: '.pickup-top-next',
        prevButton: '.pickup-top-prev',
        pagination: '.swiper-pagination',
        paginationClickable: true,
      });

     new Swiper('.sidebar-event-slide', {
        slidesPerView: 1,
        autoplay: false,
        loop: false,
        pagination: false,
        spaceBetween: 10,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        pagination: '.sidebar-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.event-top-slide', {
        slidesPerView: 1.2,
        autoplay: false,
        loop: false,
        pagination: false,
        spaceBetween: 28,
        nextButton: false,
        prevButton: false,
        pagination: '.event-top-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.my-event-top-slide', {
        slidesPerView: 1.2,
        autoplay: false,
        loop: false,
        pagination: false,
        spaceBetween: 24,
        nextButton: false,
        prevButton: false,
        pagination: '.my-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.main-project-slide', {
        slidesPerView: 2.2,
        autoplay: false,
        loop: false,
        pagination: false,
        spaceBetween: 20,
        nextButton: false,
        prevButton: false,
        pagination: '.main-project-swiper-pagination',
        paginationClickable: true
      });

    //タブレット
    }else if(ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0){
      new Swiper('.pickup-top-slide', {
        slidesPerView: 1,
        autoplay: 5000,
        speed: 1500,
        loop: true,
        effect: "fade",
        pagination: false,
        spaceBetween: 0,
        nextButton: '.pickup-top-next',
        prevButton: '.pickup-top-prev',
        pagination: '.pickup-top-swiper-pagination',
        paginationClickable: true,
      });

     new Swiper('.sidebar-event-slide', {
        slidesPerView: 1,
        autoplay: 5000,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 0,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
      });

     new Swiper('.event-top-slide', {
        slidesPerView: 2.2,
        autoplay: false,
        loop: false,
        pagination: false,
        spaceBetween: 28,
        nextButton: false,
        prevButton: false,
        pagination: '.event-top-swiper-pagination',
        paginationClickable: true,
        pagination: '.sidebar-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.my-event-top-slide', {
        slidesPerView: 2,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 24,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        pagination: '.my-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.main-project-slide', {
        slidesPerView: 5,
        autoplay: 5000,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 32,
        nextButton: '.main-projext-next',
        prevButton: '.main-projext-prev',
        pagination: '.main-project-swiper-pagination',
        paginationClickable: true
      });

    //PC
    }else{
      new Swiper('.pickup-top-slide', {
        slidesPerView: 1,
        autoplay: 5000,
        speed: 1500,
        loop: true,
        effect: "fade",
        pagination: false,
        spaceBetween: 0,
        nextButton: '.pickup-top-next',
        prevButton: '.pickup-top-prev',
        pagination: '.pickup-top-swiper-pagination',
        paginationClickable: true,
      });

     new Swiper('.sidebar-event-slide', {
        slidesPerView: 1,
        autoplay: 5000,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 0,
        nextButton: '.sidebar-event-next',
        prevButton: '.sidebar-event-prev',
        pagination: '.sidebar-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.event-top-slide', {
        slidesPerView: 3,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 28,
        nextButton: '.event-top-slide-next',
        prevButton: '.event-top-slide-prev',
        pagination: '.event-top-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.my-event-top-slide', {
        slidesPerView: 2,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 24,
        nextButton: '.my-event-top-slide-next',
        prevButton: '.my-event-top-slide-prev',
        pagination: '.my-event-swiper-pagination',
        paginationClickable: true
      });

     new Swiper('.main-project-slide', {
        slidesPerView: 5,
        autoplay: 5000,
        speed: 1000,
        loop: false,
        pagination: false,
        spaceBetween: 32,
        nextButton: '.main-projext-next',
        prevButton: '.main-projext-prev',
        pagination: '.main-project-swiper-pagination',
        paginationClickable: true
      });
    }



  }

  window.onload = function() {
      document.getElementById("device").innerHTML = device();
    }

});
