const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('.carousel-track');
    const controls = carousel.querySelector('[data-carousel-controls]');
    const previous = controls.querySelector('[data-direction="previous"]');
    const next = controls.querySelector('[data-direction="next"]');

    function updateControls() {
        const maximum = track.scrollWidth - track.clientWidth;
        controls.hidden = maximum < 2;
        previous.disabled = track.scrollLeft <= 2;
        next.disabled = track.scrollLeft >= maximum - 2;
    }

    function move(direction) {
        const card = track.querySelector('.carousel-card');
        if (!card) return;
        const step = card.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap);
        track.scrollBy({ left: direction * step, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
    }

    previous.addEventListener('click', () => move(-1));
    next.addEventListener('click', () => move(1));
    track.addEventListener('keydown', (event) => {
        if (event.target !== track) return;
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            move(event.key === 'ArrowLeft' ? -1 : 1);
        }
    });
    track.addEventListener('scroll', updateControls, { passive: true });
    new ResizeObserver(updateControls).observe(track);
    updateControls();
});
