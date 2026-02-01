/**
 * Automatically click "Open in Browser" button for Teams links.
 */

'use strict';
(() => {
  function clickButtonWhenAvailable() {
    const button = document.getElementById('openTeamsClientInBrowser');
    if (button) {
      button.click();
    } else {
      // Retry after a short delay if the button isn't available yet
      setTimeout(clickButtonWhenAvailable, 500);
    }
  }

  clickButtonWhenAvailable();
})();
