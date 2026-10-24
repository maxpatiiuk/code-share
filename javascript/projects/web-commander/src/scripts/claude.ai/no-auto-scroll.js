'use strict';

/** @typedef {'scrollTo' | 'scroll' | 'scrollBy' | 'scrollIntoView' | 'scrollIntoViewIfNeeded'} PatchedMethod */
/** @typedef {(this: Element, ...args: unknown[]) => unknown} ElementMethod */
/** @typedef {'pushState' | 'replaceState'} HistoryMethod */

(() => {
  const SELECTOR = '[data-autoscroll-container="true"]';
  const NAV_GRACE_MS = 2500;
  const BYPASS = Symbol.for('maxpatiiuk.scroller.bypass');
  /** @type {Record<symbol, unknown>} */
  const flags = /** @type {Record<symbol, unknown>} */ (
    /** @type {unknown} */ (globalThis)
  );

  /** @type {typeof globalThis & { __allowAutoScroll?: boolean }} */
  const g = /** @type {typeof globalThis & { __allowAutoScroll?: boolean }} */ (
    globalThis
  );

  /** @type {Record<PatchedMethod, ElementMethod | undefined>} */
  const proto =
    /** @type {Record<PatchedMethod, ElementMethod | undefined>} */ (
      /** @type {unknown} */ (Element.prototype)
    );

  let navAt = performance.now();
  const markNav = () => {
    navAt = performance.now();
  };

  // SPA navigation → allow the app's initial scroll-to-bottom
  /** @type {readonly HistoryMethod[]} */
  const HISTORY_METHODS = ['pushState', 'replaceState'];
  for (const name of HISTORY_METHODS) {
    const orig = history[name];
    /**
     * @this {History}
     * @param {Parameters<History['pushState']>} args
     */
    history[name] = function (...args) {
      markNav();
      return orig.apply(this, args);
    };
  }
  addEventListener('popstate', markNav);

  /** @returns {boolean} */
  const isAllowed = () =>
    flags[BYPASS] === true ||
    g.__allowAutoScroll === true ||
    performance.now() - navAt < NAV_GRACE_MS;

  /**
   * @param {unknown} el
   * @returns {boolean}
   */
  const isContainer = (el) => el instanceof Element && el.matches(SELECTOR);

  /**
   * @param {unknown} el
   * @returns {boolean}
   */
  const isDescendant = (el) =>
    el instanceof Element && el.parentElement?.closest(SELECTOR) != null;

  /**
   * @param {PatchedMethod} name
   * @param {(el: unknown) => boolean} matches
   */
  const wrap = (name, matches) => {
    const orig = proto[name];
    if (typeof orig !== 'function') return;
    /**
     * @this {Element}
     * @param {unknown[]} args
     */
    proto[name] = function (...args) {
      return matches(this) && !isAllowed() ? undefined : orig.apply(this, args);
    };
  };

  /** @type {readonly PatchedMethod[]} */
  const CONTAINER_METHODS = ['scrollTo', 'scroll', 'scrollBy'];
  /** @type {readonly PatchedMethod[]} */
  const DESCENDANT_METHODS = ['scrollIntoView', 'scrollIntoViewIfNeeded'];

  CONTAINER_METHODS.forEach((n) => wrap(n, isContainer));
  DESCENDANT_METHODS.forEach((n) => wrap(n, isDescendant));

  const desc = Object.getOwnPropertyDescriptor(Element.prototype, 'scrollTop');
  if (desc?.set) {
    const originalSet = desc.set;
    Object.defineProperty(Element.prototype, 'scrollTop', {
      ...desc,
      /**
       * @this {Element}
       * @param {number} v
       */
      set(v) {
        if (isContainer(this) && !isAllowed()) return;
        originalSet.call(this, v);
      },
    });
  }
})();
