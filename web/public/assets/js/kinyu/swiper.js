//swiper.js→ PC/SP切り替え

if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) 
{

  //　スマホ
  var swiper = new Swiper('.swiper-container', {
      pagination: '.swiper-pagination',
      slidesPerView: 1,
      loop: true,
      paginationClickable: true,
      nextButton: '.swiper-button-next01',
      prevButton: '.swiper-button-prev01',
  });

  var swiper = new Swiper('.swiper-container02', {
      pagination: '.swiper-pagination02',
      slidesPerView: 1,
      paginationClickable: true,
      autoplay: 8000,
      speed: 800,
      nextButton: '.swiper-button-next02',
      prevButton: '.swiper-button-prev02',
      spaceBetween: 0
  });
  var swiper = new Swiper('.swiper-container03', {
      pagination: '.swiper-pagination03',
      slidesPerView: 3,
      paginationClickable: true,
      autoplay: 8000,
      speed: 800,
      nextButton: '.swiper-button-next03',
      prevButton: '.swiper-button-prev03',
      spaceBetween: 0
  });
} else {

  //　PC
  // var swiper = new Swiper('.swiper-container', {
  //     pagination: '.swiper-pagination',
  //     slidesPerView: 1,
  //     autoplay: 5000,
  //     speed: 800,
  //     paginationClickable: true,
  //     nextButton: '.swiper-button-next01',
  //     prevButton: '.swiper-button-prev01',
  // });

  var swiper = new Swiper('.swiper-container02', {
      pagination: '.swiper-pagination02',
      slidesPerView: 1,
      autoplay: 6000,
      speed: 800,
      paginationClickable: true,
      nextButton: '.swiper-button-next02',
      prevButton: '.swiper-button-prev02',
      spaceBetween: 0
  });

  var swiper = new Swiper('.swiper-container03', {
    slidesPerView: 'auto',
    autoplay: 5000,
    speed: 1000,
    loop: true,
    pagination: '.swiper-pagination',

    // ナビゲーションボタン
    nextButton: '.swiper-button-next03',
    prevButton: '.swiper-button-prev03',

    // 1スライドごとの余白
    spaceBetween: 0
  });

}