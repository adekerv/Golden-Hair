import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../../resources/js/product-filter.js', import.meta.url), 'utf8');

function fixture(categories, { catalog = true } = {}) {
    let focused = null;
    const cards = categories.map((category, index) => {
        const trigger = { focus() { focused = index; } };
        return { dataset: { category }, hidden: false, querySelector: () => trigger };
    });
    const buttons = ['all', ...new Set(categories.filter(Boolean))].map((value) => ({
        dataset: { productFilter: value },
        pressed: null,
        setAttribute(name, state) { if (name === 'aria-pressed') this.pressed = state; },
        addEventListener(name, callback) { this.click = callback; },
    }));
    const more = { textContent: '', addEventListener(name, callback) { this.click = callback; } };
    const parts = {
        filters: { hidden: true },
        moreWrap: { hidden: true },
        status: { textContent: '' },
    };
    const root = {
        querySelector: (selector) => ({
            '[data-product-filters]': parts.filters,
            '[data-product-more-wrap]': parts.moreWrap,
            '[data-product-more]': more,
            '[data-product-status]': parts.status,
        })[selector],
        querySelectorAll: (selector) => (selector === '[data-product-card]' ? cards : buttons),
    };
    vm.runInNewContext(source, { document: { querySelector: () => (catalog ? root : null) } });
    const visible = () => cards.filter((card) => !card.hidden).length;
    const button = (value) => buttons.find((candidate) => candidate.dataset.productFilter === value);
    return { cards, buttons, button, more, visible, focused: () => focused, ...parts };
}

const catalogue = [...Array(12).fill('coiffage'), ...Array(5).fill('lavage'), ...Array(7).fill('soins'), ...Array(4).fill('barbe')];

test('the first twelve products show with the filters revealed and a count', () => {
    const f = fixture(catalogue);
    assert.equal(f.visible(), 12);
    assert.equal(f.filters.hidden, false);
    assert.equal(f.moreWrap.hidden, false);
    assert.equal(f.more.textContent, 'Afficher plus de produits (16 restants)');
    assert.equal(f.status.textContent, '12 produits affichés sur 28');
    assert.equal(f.button('all').pressed, 'true');
    assert.equal(f.button('barbe').pressed, 'false');
});

test('show more reveals twelve at a time, moves focus to the first new product, then disappears', () => {
    const f = fixture(catalogue);
    f.more.click();
    assert.equal(f.visible(), 24);
    assert.equal(f.focused(), 12);
    assert.equal(f.more.textContent, 'Afficher plus de produits (4 restants)');
    f.more.click();
    assert.equal(f.visible(), 28);
    assert.equal(f.focused(), 24);
    assert.equal(f.moreWrap.hidden, true);
    assert.equal(f.status.textContent, '28 produits affichés sur 28');
});

test('choosing a category shows only its products and resets the page size', () => {
    const f = fixture(catalogue);
    f.more.click();
    f.button('barbe').click();
    assert.equal(f.visible(), 4);
    assert.deepEqual(f.cards.filter((card) => !card.hidden).map((card) => card.dataset.category), Array(4).fill('barbe'));
    assert.equal(f.moreWrap.hidden, true);
    assert.equal(f.status.textContent, '4 produits affichés sur 4');
    assert.equal(f.button('barbe').pressed, 'true');
    assert.equal(f.button('all').pressed, 'false');

    f.button('all').click();
    assert.equal(f.visible(), 12);
    assert.equal(f.moreWrap.hidden, false);
});

test('a category larger than a page can be expanded', () => {
    const f = fixture([...Array(15).fill('coiffage'), 'barbe']);
    f.button('coiffage').click();
    assert.equal(f.visible(), 12);
    assert.equal(f.more.textContent, 'Afficher plus de produits (3 restants)');
    f.more.click();
    assert.equal(f.visible(), 15);
});

test('singular wording is used for a single product', () => {
    const f = fixture(['coiffage', 'barbe']);
    f.button('barbe').click();
    assert.equal(f.status.textContent, '1 produit affiché sur 1');
});

test('products without a category appear only under all', () => {
    const f = fixture(['coiffage', '', 'barbe']);
    assert.equal(f.visible(), 3);
    f.button('coiffage').click();
    assert.deepEqual(f.cards.map((card) => card.hidden), [false, true, true]);
});

test('without a catalogue nothing happens', () => {
    assert.doesNotThrow(() => fixture([], { catalog: false }));
});
