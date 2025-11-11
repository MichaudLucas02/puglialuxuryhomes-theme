document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-mobile-slider]').forEach((slider) => {
    const track  = slider.querySelector('.discover-track');
    if (!track) return;

    const slides = Array.from(track.querySelectorAll('.discover-container-mobile'));
    if (!slides.length) return;

    // Ensure a dots wrapper exists
    let dotsWrap = slider.querySelector('.discover-dots');
    if (!dotsWrap) {
      dotsWrap = document.createElement('div');
      dotsWrap.className = 'discover-dots';
      slider.appendChild(dotsWrap);
    }

    // Build dots
    const dots = slides.map((_, i) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'dot' + (i === 0 ? ' active' : '');
      b.setAttribute('aria-label', 'Go to slide ' + (i + 1));
      b.addEventListener('click', () => scrollToIndex(i));
      dotsWrap.appendChild(b);
      return b;
    });

    // Ensure arrows exist (you can also hardcode them in HTML)
    let prev = slider.querySelector('.discover-arrow.prev');
    let next = slider.querySelector('.discover-arrow.next');
    if (!prev) {
      prev = document.createElement('button');
      prev.type = 'button';
      prev.className = 'discover-arrow prev';
      prev.setAttribute('aria-label', 'Previous slide');
      prev.textContent = '‹';
      slider.appendChild(prev);
    }
    if (!next) {
      next = document.createElement('button');
      next.type = 'button';
      next.className = 'discover-arrow next';
      next.setAttribute('aria-label', 'Next slide');
      next.textContent = '›';
      slider.appendChild(next);
    }

    let active = 0;

    function scrollToIndex(n) {
      const idx = Math.max(0, Math.min(slides.length - 1, n));
      track.scrollTo({ left: slides[idx].offsetLeft, behavior: 'smooth' });
    }

    // Sync active dot based on which slide center is closest to track center
    let ticking = false;
    function onScroll() {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(() => {
        const center = track.scrollLeft + track.clientWidth / 2;
        let best = Infinity, idx = 0;
        slides.forEach((s, i) => {
          const c = s.offsetLeft + s.clientWidth / 2;
          const d = Math.abs(c - center);
          if (d < best) { best = d; idx = i; }
        });
        active = idx;
        dots.forEach((d, i) => d.classList.toggle('active', i === active));
        ticking = false;
      });
    }

    prev.addEventListener('click', () => scrollToIndex(active - 1));
    next.addEventListener('click', () => scrollToIndex(active + 1));

    // Keyboard: left/right when the slider has focus
    slider.setAttribute('tabindex', '0');
    slider.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft')  { e.preventDefault(); scrollToIndex(active - 1); }
      if (e.key === 'ArrowRight') { e.preventDefault(); scrollToIndex(active + 1); }
    });

    // Hide controls if only one slide
    if (slides.length < 2) {
      dotsWrap.style.display = 'none';
      prev.style.display = 'none';
      next.style.display = 'none';
    }

    track.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);

    onScroll(); // initial
  });
});
