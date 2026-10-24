'use strict';

document.addEventListener('@maxpatiiuk/web-commander:close-tab', () => {
  chrome.runtime.sendMessage({ action: 'close-tab' });
});
