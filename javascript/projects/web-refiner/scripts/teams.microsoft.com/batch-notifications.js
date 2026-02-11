'use strict';
/**
 * @typedef {Notification & {
 *   _native?: Notification,
 *   options?: NotificationOptions,
 *   title?: string
 * }} StubNotification
 */
(async () => {
  // Can't use chrome.runtime.getURL as we run in world:MAIN. Must run in
  // world:MAIN because we need to override window.Notifications
  const dataUrl =
    'chrome-extension://ijagjceofmifbnefgdjgmoojkbaopgnj/private-scripts/teams.microsoft.com/priorityData.json';
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
  /** @type {StubNotification[]} */
  const queue = [];
  /** @type {number | undefined} */
  let timeout = undefined;

  /**
   * @param {string} title
   * @param {NotificationOptions} [options]
   * @returns {Notification}
   */
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
  /**
   * @param {Set<string>} set
   * @param {string | undefined} text
   * @returns {boolean}
   */
  function includesSet(set, text) {
    const words = new Set(text?.toLowerCase().match(reWord) ?? []);
    return !set.isDisjointFrom(words);
  }

  /**
   * @param {string} title
   * @param {NotificationOptions} options
   * @returns {StubNotification}
   */
  function makeStub(title, options) {
    /** @type {StubNotification} */
    const stub = /** @type {StubNotification} */ (
      /** @type {unknown} */ (new EventTarget())
    );
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
      if (!stub) continue;
      stub._native = new NativeNotification(stub.title, stub.options);
      const native = stub._native;
      if (!native) continue;

      ['show', 'click', 'close', 'error'].forEach((eventName) =>
        native.addEventListener(eventName, (event) => {
          Object.defineProperty(event, 'target', {
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
