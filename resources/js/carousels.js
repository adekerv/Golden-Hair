const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('.carousel-track');
    const controls = carousel.querySelector('[data-carousel-controls]');
    const previous = controls?.querySelector('[data-direction="previous"]');
    const next = controls?.querySelector('[data-direction="next"]');
    const status = carousel.querySelector('[data-carousel-status]');
    if (!track || !controls || !previous || !next) return;

    function updateControls() {
        const maximum = Math.max(0, track.scrollWidth - track.clientWidth);
        if (maximum < 2 && controls.contains(document.activeElement)) {
            track.focus({ preventScroll: true });
        }
        controls.hidden = maximum < 2;
        // Keep the controls focusable when reaching an edge of the list.
        previous.setAttribute('aria-disabled', String(track.scrollLeft <= 2));
        next.setAttribute('aria-disabled', String(track.scrollLeft >= maximum - 2));
    }

    function updateStatus() {
        if (!status) return;
        const cards = Array.from(track.querySelectorAll('.carousel-card'));
        const bounds = track.getBoundingClientRect();
        const visible = cards.map((card, index) => ({ bounds: card.getBoundingClientRect(), number: index + 1 }))
            .filter((card) => card.bounds.right > bounds.left + 2 && card.bounds.left < bounds.right - 2);
        status.textContent = visible.length
            ? `Articles ${visible[0].number} à ${visible.at(-1).number} sur ${cards.length}`
            : '';
    }

    function move(direction) {
        const card = track.querySelector('.carousel-card');
        if (!card) return;
        const step = card.getBoundingClientRect().width + (parseFloat(getComputedStyle(track).gap) || 0);
        track.scrollBy({ left: direction * step, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
    }

    previous.addEventListener('click', () => {
        if (previous.getAttribute('aria-disabled') !== 'true') move(-1);
    });
    next.addEventListener('click', () => {
        if (next.getAttribute('aria-disabled') !== 'true') move(1);
    });
    track.addEventListener('keydown', (event) => {
        if (event.target !== track || event.altKey || event.ctrlKey || event.metaKey) return;
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            move(event.key === 'ArrowLeft' ? -1 : 1);
        } else if (event.key === 'Home' || event.key === 'End') {
            event.preventDefault();
            track.scrollTo({ left: event.key === 'Home' ? 0 : track.scrollWidth, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
        }
    });
    let announcementTimer;
    track.addEventListener('scroll', () => {
        updateControls();
        clearTimeout(announcementTimer);
        announcementTimer = setTimeout(updateStatus, 180);
    }, { passive: true });
    const resize = () => { updateControls(); updateStatus(); };
    if ('ResizeObserver' in window) new ResizeObserver(resize).observe(track);
    else window.addEventListener('resize', resize);
    resize();
});
