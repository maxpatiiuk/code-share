/**
 * Hide Wikipedia References from Screen Readers (and Readability.js)
 * Adds aria-hidden="true" to the references section on Wikipedia articles
 */

'use strict';
(() => {
  Array.from(
    document.querySelectorAll('.mw-references-wrap .references,  sup.reference')
  ).forEach((refElement) => {
    refElement.setAttribute('aria-hidden', 'true');
  });
})();
