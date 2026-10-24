chrome.commands.onCommand.addListener((command) => {
  if (command === 'toggle-nav') {
    chrome.tabs.query({ active: true, currentWindow: true }, async (tabs) => {
      if (tabs[0]?.id) {
        const contexts = await chrome.runtime.getContexts({
          contextTypes: ['TAB'],
          tabIds: [tabs[0].id],
        });
        if (
          contexts.some((context) =>
            context.documentUrl?.startsWith(
              chrome.runtime.getURL('src/new-tab/index.html')
            )
          )
        ) {
          chrome.runtime.sendMessage({
            action: 'toggle-nav',
            tabId: tabs[0].id,
          });
        } else {
          chrome.scripting.executeScript({
            target: { tabId: tabs[0].id },
            files: ['src/ui/content.js'],
            world: 'ISOLATED',
          });
        }
      }
    });
  }
});

chrome.runtime.onMessage.addListener((msg) => {
  if (msg?.action === 'open-tab' && typeof msg.url === 'string') {
    chrome.tabs.create({ url: msg.url, active: msg.active !== false });
  }
});
