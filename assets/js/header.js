document.addEventListener('DOMContentLoaded', () => {
    const topHeader = document.querySelector('.top-header');
    const bottomHeader = document.querySelector('.bottom-header');
    if (!topHeader || !bottomHeader) return;

    const onScroll = () => {
        const y = Math.max(0, window.scrollY || window.pageYOffset);
        const atTop = y <= 10;

        bottomHeader.classList.toggle('hidden', !atTop);

        topHeader.classList.toggle('scrolled', !atTop);

    }

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true})
})