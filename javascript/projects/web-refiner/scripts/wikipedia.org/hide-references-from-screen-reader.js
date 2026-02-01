/**
 * Hide Wikipedia References from Screen Readers (and Readability.js)
 * Adds aria-hidden="true" to the references section on Wikipedia articles
 */

'use strict';
(function () {
  function hideReferences() {
    const refElement = document.querySelector('.reflist .references');
    if (refElement) {
      refElement.setAttribute('aria-hidden', 'true');
    }
  }

  // Run once after the page loads
  window.addEventListener('load', hideReferences);
})();
