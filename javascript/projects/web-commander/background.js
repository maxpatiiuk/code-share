chrome.commands.onCommand.addListener((command) => {
  if (command === 'toggle-nav') {
    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
      if (tabs[0]?.id) {
        chrome.scripting.executeScript({
          target: { tabId: tabs[0].id },
          files: ['content.js'],
          world: 'ISOLATED',
        });
      }
    });
  }
});

chrome.runtime.onMessage.addListener((msg) => {
  if (msg?.action === 'open-tab' && typeof msg.url === 'string') {
    chrome.tabs.create({ url: msg.url, active: msg.active !== false });
  }
});
