document.querySelectorAll('[data-hairstyle-card]').forEach((card) => {
    const image = card.querySelector('[data-hairstyle-photo]');
    const views = card.querySelectorAll('[data-hairstyle-view]');
    if (!image || views.length < 2) return;

    views.forEach((view) => {
        view.addEventListener('click', (event) => {
            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button > 0) return;
            event.preventDefault();
            image.src = view.href;
            image.alt = view.dataset.imageAlt;
            views.forEach((option) => option.setAttribute('aria-current', String(option === view)));
        });
    });
});
