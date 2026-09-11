const menu = document.querySelector('[data-mobile-menu]');

if (menu) {
    const summary = menu.querySelector('summary');
    const desktop = window.matchMedia('(min-width: 64rem)');
    const close = (restoreFocus = false) => {
        menu.open = false;
        if (restoreFocus) summary.focus();
    };

    menu.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link) return;
        close();
        const target = document.querySelector(new URL(link.href).hash);
        if (target) {
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.open) close(true);
    });
    document.addEventListener('click', (event) => {
        if (menu.open && !menu.contains(event.target)) {
            close(menu.contains(document.activeElement));
        }
    });
    desktop.addEventListener('change', () => {
        if (desktop.matches) {
            const focusInside = menu.contains(document.activeElement);
            close();
            if (focusInside) document.querySelector('header nav > a').focus();
        }
    });
}
