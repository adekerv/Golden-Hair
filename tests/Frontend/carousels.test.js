import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../../resources/js/carousels.js', import.meta.url), 'utf8');

function carouselFixture({ reducedMotion = false, width = 300 } = {}) {
    const document = { activeElement: null };
    const element = () => ({
        events: {}, attributes: {},
        addEventListener(name, callback) { this.events[name] = callback; },
        setAttribute(name, value) { this.attributes[name] = value; },
        getAttribute(name) { return this.attributes[name]; },
        focus() { document.activeElement = this; },
    });
    const previous = element();
    const next = element();
    const status = { textContent: '' };
    const controls = {
        hidden: true,
        contains(target) { return target === previous || target === next; },
        querySelector(selector) { return selector.includes('previous') ? previous : next; },
    };
    const track = Object.assign(element(), {
        scrollLeft: 0, clientWidth: width, scrollWidth: 1060,
        getBoundingClientRect() { return { left: 0, right: this.clientWidth }; },
        scrollTo({ left, behavior }) {
            this.lastBehavior = behavior;
            this.scrollLeft = Math.max(0, Math.min(left, this.scrollWidth - this.clientWidth));
            this.events.scroll();
        },
        scrollBy({ left, behavior }) { this.scrollTo({ left: this.scrollLeft + left, behavior }); },
    });
    const cards = Array.from({ length: 4 }, (_, index) => ({
        getBoundingClientRect() { return { left: index * 270 - track.scrollLeft, right: index * 270 + 250 - track.scrollLeft, width: 250 }; },
    }));
    track.querySelector = () => cards[0];
    track.querySelectorAll = () => cards;
    document.querySelectorAll = () => [{ querySelector(selector) {
        return { '.carousel-track': track, '[data-carousel-controls]': controls, '[data-carousel-status]': status }[selector];
    } }];
    let resize;
    class ResizeObserver { constructor(callback) { resize = callback; } observe() {} }
    vm.runInNewContext(source, {
        document, window: { matchMedia: () => ({ matches: reducedMotion }), ResizeObserver }, ResizeObserver,
        getComputedStyle: () => ({ gap: '20px' }), setTimeout: (callback) => callback(), clearTimeout() {},
    });
    const key = (value) => track.events.keydown({ target: track, key: value, preventDefault() {} });
    return { track, previous, next, controls, status, document, resize: () => resize(), key };
}

test('buttons navigate, announce the visible range, and retain focus at the end', () => {
    const c = carouselFixture();
    assert.equal(c.previous.getAttribute('aria-disabled'), 'true');
    c.next.focus();
    for (let i = 0; i < 3; i++) c.next.events.click();
    assert.equal(c.track.scrollLeft, 760);
    assert.equal(c.next.getAttribute('aria-disabled'), 'true');
    assert.equal(c.document.activeElement, c.next);
    assert.equal(c.status.textContent, 'Articles 3 à 4 sur 4');
    c.next.events.click();
    assert.equal(c.track.scrollLeft, 760);
    c.previous.events.click();
    assert.equal(c.track.scrollLeft, 490);
});

test('keyboard navigation supports arrows and Home/End with reduced motion', () => {
    const c = carouselFixture({ reducedMotion: true });
    c.key('ArrowRight');
    assert.equal(c.track.scrollLeft, 270);
    assert.equal(c.track.lastBehavior, 'instant');
    c.key('End');
    assert.equal(c.track.scrollLeft, 760);
    c.key('Home');
    assert.equal(c.track.scrollLeft, 0);
});

test('resizing hides unnecessary controls and moves focus to the list', () => {
    const c = carouselFixture();
    c.next.focus();
    c.track.clientWidth = 1100;
    c.resize();
    assert.equal(c.controls.hidden, true);
    assert.equal(c.document.activeElement, c.track);
    c.track.clientWidth = 300;
    c.resize();
    assert.equal(c.controls.hidden, false);
});
