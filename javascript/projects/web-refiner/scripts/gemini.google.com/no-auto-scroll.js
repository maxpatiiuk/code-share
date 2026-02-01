'use strict';
(() => {
  const originalScrollIntoView = Element.prototype.scrollIntoView;

  const BLOCKED_SELECTORS = [
    'PENDING-REQUEST',
    '.conversation-container',
    '.message-actions-hover-boundary',
  ];

  /**
   * @param  {...unknown} args
   */
  Element.prototype.scrollIntoView = function (...args) {
    const isBlocked = BLOCKED_SELECTORS.some((selector) => {
      if (selector.startsWith('.')) {
        return this.classList.contains(selector.substring(1));
      }
      return this.tagName === selector;
    });

    if (isBlocked) {
      return;
    }

    return originalScrollIntoView.apply(this, args);
  };
})();
