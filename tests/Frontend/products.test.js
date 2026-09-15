import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../../resources/js/products.js', import.meta.url), 'utf8');

function productFixture({ supported = true } = {}) {
    const document = { activeElement: null };
    const element = (textContent = '') => ({
        textContent, events: {}, attributes: {}, children: [], tagName: 'DIV',
        classList: { values: new Set(), add(value) { this.values.add(value); }, remove(value) { this.values.delete(value); } },
        addEventListener(name, callback) { this.events[name] = callback; },
        setAttribute(name, value) { this.attributes[name] = value; },
        replaceChildren(...children) { this.children = children; },
        cloneNode() { return Object.assign(element(this.textContent), { tagName: this.tagName }); },
        closest() { return null; },
        focus(options) { document.activeElement = this; this.focusOptions = options; },
    });
    const fields = ['image', 'brand', 'title', 'description', 'price', 'stock', 'details'];
    const output = Object.fromEntries(fields.map((field) => [field, element()]));
    const dialog = Object.assign(element(), {
        id: 'product-dialog', open: false,
        querySelector(selector) { return output[selector.match(/data-dialog-(\w+)/)[1]]; },
        showModal: supported ? function () { this.open = true; } : undefined,
        close() { this.open = false; this.events.close(); },
        getBoundingClientRect() { return { left: 100, right: 900, top: 100, bottom: 700 }; },
    });
    const cards = ['Mousse', 'Huile'].map((name, index) => {
        const input = Object.fromEntries(fields.map((field) => [field, element(`${name} ${field}`)]));
        input.image.tagName = index ? 'DIV' : 'IMG';
        input.stock.textContent = index ? 'Rupture de stock' : 'En stock';
        const trigger = element();
        trigger.closest = (selector) => selector.includes('data-product-open') ? trigger : null;
        const card = Object.assign(element(), {
            input, trigger,
            querySelector(selector) { return selector === '[data-product-open]' ? trigger : input[selector.match(/data-product-(\w+)/)[1]]; },
        });
        return card;
    });
    document.getElementById = () => dialog;
    document.querySelectorAll = () => cards;
    document.documentElement = element();
    vm.runInNewContext(source, { document, window: { getSelection: () => ({ toString: () => '' }) } });
    const click = (index = 0, overrides = {}) => {
        const event = { target: cards[index].trigger, detail: 0, clientX: 150, clientY: 150,
            preventDefault() { this.prevented = true; }, ...overrides };
        cards[index].events.click?.(event);
        return event;
    };
    return { cards, dialog, output, document, click };
}

test('keyboard activation opens the matching details, image, price and stock', () => {
    const c = productFixture();
    assert.equal(c.click().prevented, true);
    assert.equal(c.dialog.open, true);
    assert.equal(c.output.title.textContent, 'Mousse title');
    assert.equal(c.output.price.textContent, 'Mousse price');
    assert.equal(c.output.stock.children[0].textContent, 'En stock');
    assert.equal(c.output.details.children[0].textContent, 'Mousse details');
    assert.equal(c.output.image.children[0].loading, 'eager');
    assert.equal(c.cards[0].trigger.attributes['aria-haspopup'], 'dialog');
    assert.equal(c.document.documentElement.classList.values.has('product-dialog-open'), true);
});

test('closing restores focus without scrolling and another product replaces all details', () => {
    const c = productFixture();
    c.click();
    c.dialog.close(); // Native Escape and the close form both emit this event.
    assert.equal(c.document.activeElement, c.cards[0].trigger);
    assert.equal(c.cards[0].trigger.focusOptions.preventScroll, true);
    assert.equal(c.document.documentElement.classList.values.has('product-dialog-open'), false);
    c.click(1, { target: c.cards[1] });
    assert.equal(c.output.title.textContent, 'Huile title');
    assert.equal(c.output.stock.children[0].textContent, 'Rupture de stock');
    assert.equal(c.output.image.children.length, 1);
    assert.equal(c.output.image.children[0].tagName, 'DIV');
});

test('swiping across a product does not open its details', () => {
    const c = productFixture();
    c.cards[0].events.pointerdown({ clientX: 400, clientY: 200 });
    c.click(0, { detail: 1, clientX: 150, clientY: 200 });
    assert.equal(c.dialog.open, false);
    c.click();
    assert.equal(c.dialog.open, true);
});

test('backdrop closes only when the gesture starts and ends outside the dialog', () => {
    const c = productFixture();
    c.click();
    const inside = { target: c.dialog, clientX: 500, clientY: 200 };
    const outside = { target: c.dialog, clientX: 20, clientY: 20 };
    c.dialog.events.pointerdown(inside);
    c.dialog.events.click(outside);
    assert.equal(c.dialog.open, true);
    c.dialog.events.pointerdown(outside);
    c.dialog.events.click(outside);
    assert.equal(c.dialog.open, false);
});

test('without dialog support native expandable details are left available', () => {
    const c = productFixture({ supported: false });
    assert.equal(c.cards[0].events.click, undefined);
    assert.equal(c.cards[0].trigger.attributes['aria-haspopup'], undefined);
});
