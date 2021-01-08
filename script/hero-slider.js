const mySwiper = new Swiper('.swiper-container', {
    effect: 'coverflow',
    loop: true,
    speed: 600,
    // centeredSlides: true,
    grabCursor: true,
    breakpoints: {
        780: {
            slidesPerView: 3,
        }
    },
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',  //ページネーションの要素のセレクタ
        type: 'bullets',
        clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  })