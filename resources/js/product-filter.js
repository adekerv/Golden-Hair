const catalog = document.querySelector('[data-product-catalog]');

if (catalog) {
    const pageSize = 12;
    const cards = Array.from(catalog.querySelectorAll('[data-product-card]'));
    const filters = catalog.querySelector('[data-product-filters]');
    const buttons = Array.from(catalog.querySelectorAll('[data-product-filter]'));
    const moreWrap = catalog.querySelector('[data-product-more-wrap]');
    const more = catalog.querySelector('[data-product-more]');
    const status = catalog.querySelector('[data-product-status]');
    let category = 'all';
    let limit = pageSize;

    const render = () => {
        const matching = cards.filter((card) => category === 'all' || card.dataset.category === category);
        cards.forEach((card) => {
            const position = matching.indexOf(card);
            card.hidden = position === -1 || position >= limit;
        });
        const shown = Math.min(limit, matching.length);
        const remaining = matching.length - shown;
        buttons.forEach((button) => button.setAttribute('aria-pressed', String(button.dataset.productFilter === category)));
        if (moreWrap) moreWrap.hidden = remaining <= 0;
        if (more) more.textContent = `Afficher plus de produits (${remaining} restant${remaining > 1 ? 's' : ''})`;
        if (status) status.textContent = `${shown} produit${shown > 1 ? 's' : ''} affiché${shown > 1 ? 's' : ''} sur ${matching.length}`;
        return matching;
    };

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            category = button.dataset.productFilter;
            limit = pageSize;
            render();
        });
    });

    more?.addEventListener('click', () => {
        const previouslyShown = limit;
        limit += pageSize;
        // Keyboard users continue from the first newly revealed product instead of losing their place.
        render()[previouslyShown]?.querySelector('[data-product-open]')?.focus();
    });

    if (filters) filters.hidden = false;
    render();
}
