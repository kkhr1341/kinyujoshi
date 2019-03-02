//swiper.js→ PC/SP切り替え

$(function () {

    if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {

        //　スマホ
        new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            slidesPerView: 1,
            loop: true,
            paginationClickable: true,
            nextButton: '.swiper-button-next01',
            prevButton: '.swiper-button-prev01',
        });

        // var swiper = new Swiper('.swiper-container03', {
        //     pagination: '.swiper-pagination03',
        //     slidesPerView: 3,
        //     paginationClickable: true,
        //     autoplay: 8000,
        //     speed: 800,
        //     nextButton: '.swiper-button-next03',
        //     prevButton: '.swiper-button-prev03',
        //     spaceBetween: 0
        // });
        new Swiper('.swiper-container03', {
            slidesPerView: 'auto',
            autoplay: 5000,
            speed: 1000,
            loop: true,
            pagination: false,
            // 1スライドごとの余白
            spaceBetween: 0
        });

        new Swiper('.swiper-container02', {
            pagination: '.swiper-pagination02',
            slidesPerView: 1,
            paginationClickable: true,
            autoplay: 3000,
            speed: 800,
            nextButton: '.swiper-button-next02',
            prevButton: '.swiper-button-prev02',
            spaceBetween: 0,
            onSlideChangeEnd: function (a) {
                var slider = $(".swiper-container02");
                // 広告が半分でもユーザーに表示されていたら表示トラッキング
                var displayPosition = slider.offset().top + (slider.height() / 2) - $('.sp header').height();
                if (window.scrollY >= 0 && displayPosition >= window.scrollY) {
                    var index = a.snapIndex;
                    var link = $(a.slides[index]).find('.js-track').attr('href');
                    var matches = link.match('^https://funds-i.jp/special/imadeki/');
                    if (matches && matches.length > 0) {
                        gtag('event', 'click', {
                            'event_category': 'pr',
                            'event_label': 'fundsi-slide-sp',
                            'event_action': 'view',
                            'event_value': 1,
                        });
                    }
                }
            }
        });
        $('.js-slide-fundsi-sp').click(function () {
            gtag('event', 'click', {
                'event_category': 'pr',
                'event_label': 'fundsi-slide-sp',
                'event_action': 'link',
                'event_value': 1,
            });
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

        new Swiper('.swiper-container03', {
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

        new Swiper('.swiper-container02', {
            effect: 'fade',
            pagination: '.swiper-pagination02',
            slidesPerView: 1,
            autoplay: 3000,
            speed: 1000,
            paginationClickable: true,
            nextButton: '.swiper-button-next02',
            prevButton: '.swiper-button-prev02',
            spaceBetween: 0,
            onSlideChangeEnd: function (a) {
                var slider = $(".swiper-container02");
                // 広告が半分でもユーザーに表示されていたら表示トラッキング
                var displayPosition = slider.offset().top + (slider.height() / 2) - $('header').height();
                if (window.scrollY >= 0 && displayPosition >= window.scrollY) {
                    var index = a.snapIndex;
                    var link = $(a.slides[index]).find('.js-track').attr('href');
                    var matches = link.match('^https://funds-i.jp/special/imadeki/');
                    if (matches && matches.length > 0) {
                        gtag('event', 'click', {
                            'event_category': 'pr',
                            'event_label': 'fundsi-slide-pc',
                            'event_action': 'view',
                            'event_value': 1,
                        });
                    }
                }
            }
        });
        $('.js-slide-fundsi-pc').click(function () {
            gtag('event', 'click', {
                'event_category': 'pr',
                'event_label': 'fundsi-slide-pc',
                'event_action': 'link',
                'event_value': 1,
            });
        });
    }

});
