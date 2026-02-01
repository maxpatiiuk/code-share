'use strict';
(async () => {
  const dataUrl = chrome.runtime.getURL(
    'private-scripts/teams.microsoft.com/priorityData.json'
  );
  /**
   * Pre-requisite: create private-scripts/teams.microsoft.com/priorityData.json
   * @type {{ priorityContacts: string[], priorityKeywords: string[] }}
   */
  let priorityData = { priorityContacts: [], priorityKeywords: [] };
  try {
    const response = await fetch(dataUrl);
    if (response.ok) {
      priorityData = await response.json();
    }
  } catch (error) {
    console.warn('Priority data not found or invalid.', error);
  }
  const priorityContacts = new Set(priorityData.priorityContacts);
  const priorityKeywords = new Set(priorityData.priorityKeywords);

  const maxSnoozePeriod = 1000 * 60 * 60 * 2;
  const NativeNotification = window.Notification;
  const queue = [];
  let timeout = undefined;

  function ProxyNotification(title, options = {}) {
    const requireInteraction =
      options.body?.includes('is calling you') ||
      options.body?.includes('started the meeting');
    const isPriorityContact =
      requireInteraction ||
      title.includes('@mentioned you') ||
      includesSet(priorityContacts, title) ||
      includesSet(priorityContacts, options.body);
    const isPriority =
      isPriorityContact || includesSet(priorityKeywords, options.body);
    const newOptions = {
      ...options,
      requireInteraction,
      silent: !isPriorityContact,
    };

    if (isPriority) {
      queue.splice(0);
      clearTimeout(timeout);
      timeout = undefined;
      return new NativeNotification(title, newOptions);
    }

    const stub = makeStub(title, newOptions);
    queue.push(stub);
    timeout ??= setTimeout(flushQueue, maxSnoozePeriod);
    return stub;
  }
  Object.assign(ProxyNotification, NativeNotification);
  ProxyNotification.prototype = NativeNotification.prototype;

  Object.defineProperty(window, 'Notification', {
    value: ProxyNotification,
    writable: false,
    configurable: false,
  });

  const reWord = /[a-z0-9-]+/giu;
  function includesSet(set, text) {
    const words = new Set(text?.toLowerCase().match(reWord) ?? []);
    return !set.isDisjointFrom(words);
  }

  function makeStub(title, options) {
    const stub = new EventTarget();
    stub.title = title;
    stub.options = options;
    Object.assign(stub, options);
    Object.setPrototypeOf(stub, NativeNotification.prototype);
    stub.close = () => {
      if (stub._native) stub._native.close();
      else {
        stub.dispatchEvent(new Event('close'));
        const queueIndex = queue.indexOf(stub);
        if (queueIndex >= 0) queue.splice(queueIndex, 1);
      }
    };
    return stub;
  }

  function flushQueue() {
    timeout = undefined;
    while (queue.length) {
      const stub = queue.shift();
      stub._native = new NativeNotification(stub.title, stub.options);

      ['show', 'click', 'close', 'error'].forEach((eventName) =>
        stub._native.addEventListener(eventName, (event) => {
          Object.defineProperties(event, 'target', {
            value: stub,
            writable: true,
            configurable: true,
          });
          stub.dispatchEvent(event);
        })
      );
    }
  }
})();
