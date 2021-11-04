//swiper.js→ PC/SP切り替え

$(function () {

 new Swiper('.pickup-top-slide', {
    slidesPerView: 2,
    autoplay: 5000,
    speed: 1000,
    loop: true,
    pagination: false,
    // 1スライドごとの余白
    spaceBetween: 0
  });

 new Swiper('.event-top-slide', {
    slidesPerView: 3,
    // autoplay: 5000,
    speed: 1000,
    // loop: true,
    pagination: false,
    // 1スライドごとの余白
    spaceBetween: 0
  });

});
