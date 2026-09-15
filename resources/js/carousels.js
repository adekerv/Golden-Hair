const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('.carousel-track');
    const controls = carousel.querySelector('[data-carousel-controls]');
    const previous = controls?.querySelector('[data-direction="previous"]');
    const next = controls?.querySelector('[data-direction="next"]');
    const status = carousel.querySelector('[data-carousel-status]');
    if (!track || !controls || !previous || !next) return;
    const cards = Array.from(track.querySelectorAll('.carousel-card'));
    let maximum = 0;
    let positions = [];
    let destination = null;
    let controlsFrame = null;
    let announcementTimer;

    function updateControls() {
        const position = destination ?? track.scrollLeft;
        if (maximum < 2 && controls.contains(document.activeElement)) {
            track.focus({ preventScroll: true });
        }
        controls.hidden = maximum < 2;
        // Keep the controls focusable when reaching an edge of the list.
        previous.setAttribute('aria-disabled', String(position <= 2));
        next.setAttribute('aria-disabled', String(position >= maximum - 2));
    }

    function updateStatus() {
        if (!status) return;
        const bounds = track.getBoundingClientRect();
        const visible = cards.map((card, index) => ({ bounds: card.getBoundingClientRect(), number: index + 1 }))
            .filter((card) => card.bounds.right > bounds.left + 2 && card.bounds.left < bounds.right - 2);
        const message = visible.length
            ? `Articles ${visible[0].number} à ${visible.at(-1).number} sur ${cards.length}`
            : '';
        if (status.textContent !== message) status.textContent = message;
    }

    function goTo(position) {
        destination = Math.max(0, Math.min(position, maximum));
        updateControls();
        track.scrollTo({ left: destination, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
    }

    function move(direction) {
        const position = destination ?? track.scrollLeft;
        // Navigate from the intended destination so rapid clicks are not lost mid-animation.
        const target = direction > 0
            ? positions.find((offset) => offset > position + 2) ?? maximum
            : positions.findLast((offset) => offset < position - 2) ?? 0;
        goTo(target);
    }

    function settle() {
        clearTimeout(announcementTimer);
        // A scrollend event from a superseded animation must not discard a newer destination.
        if (destination !== null && Math.abs(track.scrollLeft - destination) > 2) return;
        destination = null;
        updateControls();
        updateStatus();
    }

    function interrupt() {
        if (destination !== null) track.scrollTo({ left: track.scrollLeft, behavior: 'instant' });
        destination = null;
        updateControls();
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
            goTo(event.key === 'Home' ? 0 : maximum);
        }
    });
    track.addEventListener('pointerdown', interrupt, { passive: true });
    track.addEventListener('wheel', interrupt, { passive: true });
    track.addEventListener('scroll', () => {
        if (controlsFrame === null) {
            controlsFrame = requestAnimationFrame(() => {
                controlsFrame = null;
                updateControls();
            });
        }
        clearTimeout(announcementTimer);
        announcementTimer = setTimeout(settle, 180);
    }, { passive: true });
    track.addEventListener('scrollend', settle);
    reducedMotion.addEventListener('change', () => {
        if (reducedMotion.matches && destination !== null) goTo(destination);
    });
    const resize = () => {
        interrupt();
        maximum = Math.max(0, track.scrollWidth - track.clientWidth);
        const left = track.getBoundingClientRect().left;
        const padding = parseFloat(getComputedStyle(track).paddingLeft) || 0;
        positions = cards.map((card) => Math.max(0, Math.min(
            card.getBoundingClientRect().left - left + track.scrollLeft - padding, maximum,
        )));
        updateControls();
        updateStatus();
    };
    if ('ResizeObserver' in window) new ResizeObserver(resize).observe(track);
    else window.addEventListener('resize', resize);
    resize();
});
