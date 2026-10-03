const root = document.documentElement;
const systemDark = window.matchMedia('(prefers-color-scheme: dark)');
const toggles = document.querySelectorAll('[data-theme-toggle]');

const readChoice = () => {
    try {
        const choice = localStorage.getItem('theme');
        return choice === 'light' || choice === 'dark' ? choice : null;
    } catch {
        return null;
    }
};
const currentTheme = () => root.dataset.theme ?? (systemDark.matches ? 'dark' : 'light');
const render = () => toggles.forEach((toggle) => toggle.setAttribute('aria-pressed', String(currentTheme() === 'dark')));

toggles.forEach((toggle) => {
    toggle.hidden = false;
    toggle.addEventListener('click', () => {
        const next = currentTheme() === 'dark' ? 'light' : 'dark';
        root.dataset.theme = next;
        try { localStorage.setItem('theme', next); } catch { /* The choice still applies until the page is closed. */ }
        render();
    });
});

systemDark.addEventListener('change', render);
window.addEventListener('storage', (event) => {
    if (event.key !== 'theme') return;
    const choice = readChoice();
    if (choice) root.dataset.theme = choice;
    else delete root.dataset.theme;
    render();
});
render();
