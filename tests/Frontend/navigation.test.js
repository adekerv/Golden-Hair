import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../../resources/js/navigation.js', import.meta.url), 'utf8');

function fixture(href) {
    const events = {};
    let focused = false;
    const target = { setAttribute() {}, focus() { focused = true; } };
    const menu = { open: true, querySelector: () => ({}), addEventListener: (name, callback) => { events[name] = callback; } };
    const location = { origin: 'https://golden.test', pathname: '/' };
    vm.runInNewContext(source, {
        URL,
        window: { location, matchMedia: () => ({ addEventListener() {} }) },
        document: { querySelector: () => menu, getElementById: (id) => id === 'produits' ? target : null, addEventListener() {} },
    });
    return { menu, click: () => events.click({ target: { closest: () => ({ href }) } }), focused: () => focused };
}

test('menu closes and focuses the destination for an in-page link', () => {
    const f = fixture('https://golden.test/#produits');
    f.click();
    assert.equal(f.menu.open, false);
    assert.equal(f.focused(), true);
});

test('links without anchors or with malformed anchors do not throw', () => {
    for (const href of ['https://golden.test/', 'https://golden.test/#%invalid', 'https://example.com/#produits']) {
        const f = fixture(href);
        assert.doesNotThrow(f.click);
        assert.equal(f.menu.open, false);
        assert.equal(f.focused(), false);
    }
});
