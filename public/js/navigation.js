// Progressive enhancement: links remain visible when JavaScript is disabled.
const navigation = document.querySelector('.navigation');
const toggle = document.querySelector('.menu-toggle');
const links = document.querySelector('#navigation-links');

if (navigation && toggle && links) {
    const mobile = window.matchMedia('(max-width: 48rem)');

    function setOpen(open) {
        toggle.setAttribute('aria-expanded', String(open));
        links.hidden = mobile.matches && !open;
    }

    function syncLayout() {
        // Return focus before hiding a focused link or the menu button.
        if (mobile.matches && links.contains(document.activeElement)) {
            toggle.hidden = false;
            toggle.focus();
        } else if (!mobile.matches && document.activeElement === toggle) {
            links.hidden = false;
            links.querySelector('a').focus();
        }
        toggle.hidden = !mobile.matches;
        setOpen(false);
    }

    toggle.addEventListener('click', () => {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    navigation.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobile.matches) {
            setOpen(false);
            toggle.focus();
        }
    });

    links.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link || !mobile.matches) return;
        setOpen(false);
        const hash = new URL(link.href).hash;
        const target = hash ? document.querySelector(hash) : null;
        if (target) {
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        } else {
            toggle.focus();
        }
    });

    mobile.addEventListener('change', syncLayout);
    syncLayout();
}
