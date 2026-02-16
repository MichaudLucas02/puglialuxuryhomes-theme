document.addEventListener('DOMContentLoaded', () => {
  const swiperConfigs = [
    {
      selector: '.swiper:not(.sea-collection-swiper):not(.land-collection-swiper):not(.city-collection-swiper):not(.service-image-carousel):not(.villa-card-carousel)',
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

  // Villa card image carousels
  if (typeof Swiper !== 'undefined') {
    document.querySelectorAll('.villa-card-carousel').forEach(function(carousel) {
      var swiperInstance = new Swiper(carousel, {
        nested: true,
        slidesPerView: 1,
        spaceBetween: 0,
        watchOverflow: true,
        pagination: {
          el: carousel.querySelector('.villa-card-carousel__pagination'),
          clickable: true,
        },
        navigation: {
          prevEl: carousel.querySelector('.villa-card-carousel__prev'),
          nextEl: carousel.querySelector('.villa-card-carousel__next'),
        },
      });

      // Prevent arrows and pagination from triggering the parent <a> link
      carousel.querySelectorAll('.villa-card-carousel__prev, .villa-card-carousel__next, .villa-card-carousel__pagination').forEach(function(el) {
        el.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
        });
      });
    });
  }
});
