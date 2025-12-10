document.addEventListener('DOMContentLoaded', () => {
  const swiperConfigs = [
    {
      selector: '.swiper:not(.sea-collection-swiper):not(.land-collection-swiper):not(.city-collection-swiper):not(.service-image-carousel)',
      options: {
        cssMode: true,
        slidesPerView: 3,
        spaceBetween: 24,
        navigation: {
          nextEl: '.villa-slider:not(.collection-slider) .villa-arrow.next',
          prevEl: '.villa-slider:not(.collection-slider) .villa-arrow.prev',
        },
        scrollbar: {
          el: '.swiper-scrollbar',
          draggable: true,
        },
        breakpoints: {
          0: { slidesPerView: 1, spaceBetween: 12 },
          600: { slidesPerView: 2, spaceBetween: 16 },
          992: { slidesPerView: 3, spaceBetween: 24 },
        },
      }
    },
    {
      selector: '.sea-collection-swiper',
      options: {
        cssMode: true,
        slidesPerView: 3,
        spaceBetween: 24,
        navigation: {
          nextEl: '.sea-slider .sea-next',
          prevEl: '.sea-slider .sea-prev',
        },
        scrollbar: { el: '.sea-collection-swiper .swiper-scrollbar', draggable: true },
        breakpoints: {
          0: { slidesPerView: 1, spaceBetween: 12 },
          600: { slidesPerView: 2, spaceBetween: 16 },
          992: { slidesPerView: 3, spaceBetween: 24 },
        },
      }
    },
    {
      selector: '.land-collection-swiper',
      options: {
        cssMode: true,
        slidesPerView: 3,
        spaceBetween: 24,
        navigation: {
          nextEl: '.land-slider .land-next',
          prevEl: '.land-slider .land-prev',
        },
        scrollbar: { el: '.land-collection-swiper .swiper-scrollbar', draggable: true },
        breakpoints: {
          0: { slidesPerView: 1, spaceBetween: 12 },
          600: { slidesPerView: 2, spaceBetween: 16 },
          992: { slidesPerView: 3, spaceBetween: 24 },
        },
      }
    },
    {
      selector: '.city-collection-swiper',
      options: {
        cssMode: true,
        slidesPerView: 3,
        spaceBetween: 24,
        navigation: {
          nextEl: '.city-slider .city-next',
          prevEl: '.city-slider .city-prev',
        },
        scrollbar: { el: '.city-collection-swiper .swiper-scrollbar', draggable: true },
        breakpoints: {
          0: { slidesPerView: 1, spaceBetween: 12 },
          600: { slidesPerView: 2, spaceBetween: 16 },
          992: { slidesPerView: 3, spaceBetween: 24 },
        },
      }
    }
  ];

  swiperConfigs.forEach(config => {
    const el = document.querySelector(config.selector);
    if (el) {
      new Swiper(el, config.options);
    }
  });
});
