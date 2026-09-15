const productDialog = document.getElementById('product-dialog');

if (productDialog && typeof productDialog.showModal === 'function') {
    let opener;
    let backdropPressed = false;

    document.querySelectorAll('[data-product-card]').forEach((card) => {
        const trigger = card.querySelector('[data-product-open]');
        if (!trigger) return;
        trigger.setAttribute('aria-haspopup', 'dialog');
        trigger.setAttribute('aria-controls', productDialog.id);
        card.classList.add('product-card-interactive');
        let pointerStart;
        card.addEventListener('pointerdown', (event) => {
            pointerStart = { x: event.clientX, y: event.clientY };
        }, { passive: true });
        card.addEventListener('click', (event) => {
            const dragged = event.detail !== 0 && pointerStart
                && Math.hypot(event.clientX - pointerStart.x, event.clientY - pointerStart.y) > 8;
            pointerStart = null;
            if (dragged) {
                event.preventDefault();
                return;
            }
            if (event.target.closest('a, button, [data-product-details]')) return;
            if (window.getSelection()?.toString() && !event.target.closest('[data-product-open]')) return;
            event.preventDefault();
            if (productDialog.open) return;

            for (const field of ['brand', 'title', 'description', 'price']) {
                productDialog.querySelector(`[data-dialog-${field}]`).textContent = card.querySelector(`[data-product-${field}]`)?.textContent ?? '';
            }
            for (const field of ['image', 'stock', 'details']) {
                const content = card.querySelector(`[data-product-${field}]`).cloneNode(true);
                if (field === 'image' && content.tagName === 'IMG') {
                    content.className = 'product-dialog-image';
                    content.loading = 'eager';
                }
                productDialog.querySelector(`[data-dialog-${field}]`).replaceChildren(content);
            }
            opener = trigger;
            productDialog.showModal();
            productDialog.scrollTop = 0;
            document.documentElement.classList.add('product-dialog-open');
        });
    });

    const outsideDialog = (event) => {
        const bounds = productDialog.getBoundingClientRect();
        return event.target === productDialog && (event.clientX < bounds.left || event.clientX > bounds.right
            || event.clientY < bounds.top || event.clientY > bounds.bottom);
    };
    productDialog.addEventListener('pointerdown', (event) => { backdropPressed = outsideDialog(event); });
    productDialog.addEventListener('click', (event) => {
        if (backdropPressed && outsideDialog(event)) productDialog.close();
        backdropPressed = false;
    });
    productDialog.addEventListener('close', () => {
        document.documentElement.classList.remove('product-dialog-open');
        opener?.focus({ preventScroll: true });
    });
}
