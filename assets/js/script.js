document.addEventListener('DOMContentLoaded', () => {
  const el = document.querySelector('.swiper');
  if (!el) return;

  new Swiper(el, {
    cssMode: true,             // 🚫 no transforms => no blur
    slidesPerView: 3,
    spaceBetween: 24,
    // pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.villa-slider .villa-arrow.next', prevEl: '.villa-slider .villa-arrow.prev' },
    scrollbar: { el: '.swiper-scrollbar', draggable: true },

    // <-- added breakpoints -->
    breakpoints: {
      // Mobile — 1 slide
      0: {
        slidesPerView: 1,
        spaceBetween: 12
      },
      // Small tablets — 2 slides
      600: {
        slidesPerView: 2,
        spaceBetween: 16
      },
      // Desktop — 3 slides
      992: {
        slidesPerView: 3,
        spaceBetween: 24
      }
    }
  });
});
