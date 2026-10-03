import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../../resources/js/theme.js', import.meta.url), 'utf8');

function fixture({ systemDark = false, stored = null, storage = true } = {}) {
    const listeners = {};
    const windowListeners = {};
    const saved = {};
    const root = { dataset: stored ? { theme: stored } : {} };
    const toggle = {
        hidden: true,
        pressed: null,
        setAttribute(name, value) { if (name === 'aria-pressed') this.pressed = value; },
        addEventListener(name, callback) { listeners[name] = callback; },
    };
    const localStorage = storage
        ? { getItem: (key) => saved[key] ?? null, setItem: (key, value) => { saved[key] = value; } }
        : { getItem() { throw new Error('blocked'); }, setItem() { throw new Error('blocked'); } };
    const media = { matches: systemDark, addEventListener: (name, callback) => { media.change = callback; } };
    vm.runInNewContext(source, {
        localStorage,
        window: { matchMedia: () => media, addEventListener: (name, callback) => { windowListeners[name] = callback; } },
        document: { documentElement: root, querySelectorAll: () => [toggle] },
    });
    return { root, toggle, saved, media, click: () => listeners.click(), storageEvent: (event) => windowListeners.storage(event) };
}

test('the toggle is revealed and reflects the system preference', () => {
    const light = fixture();
    assert.equal(light.toggle.hidden, false);
    assert.equal(light.toggle.pressed, 'false');
    assert.equal(fixture({ systemDark: true }).toggle.pressed, 'true');
});

test('clicking switches to the opposite theme and remembers the choice', () => {
    const f = fixture({ systemDark: true });
    f.click();
    assert.equal(f.root.dataset.theme, 'light');
    assert.equal(f.saved.theme, 'light');
    assert.equal(f.toggle.pressed, 'false');
    f.click();
    assert.equal(f.root.dataset.theme, 'dark');
    assert.equal(f.toggle.pressed, 'true');
});

test('an explicit choice wins over the system preference', () => {
    const f = fixture({ systemDark: true, stored: 'light' });
    assert.equal(f.toggle.pressed, 'false');
});

test('blocked storage does not break switching', () => {
    const f = fixture({ storage: false });
    assert.doesNotThrow(f.click);
    assert.equal(f.root.dataset.theme, 'dark');
});

test('a choice made in another tab is applied and clearing it returns to the system theme', () => {
    const f = fixture();
    f.saved.theme = 'dark';
    f.storageEvent({ key: 'theme' });
    assert.equal(f.root.dataset.theme, 'dark');
    assert.equal(f.toggle.pressed, 'true');
    delete f.saved.theme;
    f.storageEvent({ key: 'theme' });
    assert.equal(f.root.dataset.theme, undefined);
    assert.equal(f.toggle.pressed, 'false');
    f.storageEvent({ key: 'other' });
});
