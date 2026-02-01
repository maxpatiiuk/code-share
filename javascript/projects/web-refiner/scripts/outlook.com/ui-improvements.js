/**
 * Locks Outlook’s favicon to the “mail‑seen” icon by neutering link.href
 * assignments to reduce distractions.
 */

'use strict';
(() => {
  // Freeze icon. Don't display unread icon to not distract
  const icon = document.querySelector(`link[rel="shortcut icon"]`);
  if (!icon) return;
  const hrefDesc = Object.getOwnPropertyDescriptor(
    HTMLLinkElement.prototype,
    'href'
  );
  Object.defineProperty(icon, 'href', {
    configurable: true,
    enumerable: true,
    get: hrefDesc.get,
    set(val) {
      if (val.includes('unseen')) return;
      hrefDesc.call(this, val);
    },
  });
})();
