document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-slider]').forEach((el) => {
    const slides = Array.from(el.querySelectorAll('.slide'));
    if (slides.length <= 1) return;

    let i = 0, timer;
    const prev = el.querySelector('.prev');
    const next = el.querySelector('.next');
    const dots = Array.from(el.querySelectorAll('.dot'));

    const set = (idx) => {
      slides[i].classList.remove('active');
      if (dots[i]) { dots[i].classList.remove('active'); dots[i].setAttribute('aria-selected','false'); }
      i = (idx + slides.length) % slides.length;
      slides[i].classList.add('active');
      if (dots[i]) { dots[i].classList.add('active'); dots[i].setAttribute('aria-selected','true'); }
    };

    prev?.addEventListener('click', () => { set(i - 1); reset(); });
    next?.addEventListener('click', () => { set(i + 1); reset(); });
    dots.forEach((d) => d.addEventListener('click', () => { set(parseInt(d.dataset.index, 10)); reset(); }));

    const autoplayMs = 5000;
    const start = () => { timer = setInterval(() => set(i + 1), autoplayMs); };
    const stop  = () => { if (timer) clearInterval(timer); };
    const reset = () => { stop(); start(); };

    el.addEventListener('mouseenter', stop);
    el.addEventListener('mouseleave', start);

    set(0);
    start();
  });
});
