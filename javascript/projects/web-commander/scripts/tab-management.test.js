import assert from 'node:assert/strict';
import { test } from 'node:test';
import { readFile } from 'node:fs/promises';
import { runInNewContext } from 'node:vm';

test('tab cycling commits only on interaction and VS Code tabs follow display/strip order', async () => {
  const listeners = {};
  const event = (name) => ({
    addListener: (listener) => {
      listeners[name] = listener;
    },
  });
  const windows = [
    {
      id: 1,
      focused: true,
      left: 1920,
      top: -143,
      width: 1728,
      height: 1117,
      tabs: [
        { id: 1, windowId: 1, active: true, url: 'https://example.com/' },
        {
          id: 2,
          windowId: 1,
          active: false,
          url: 'http://vscode.localhost:3000/a',
        },
        { id: 3, windowId: 1, active: false, url: 'https://vscode.dev/b' },
        {
          id: 4,
          windowId: 1,
          active: false,
          url: 'https://vscode.dev.example.com/',
        },
      ],
    },
    {
      id: 2,
      focused: false,
      left: 0,
      top: 0,
      width: 1920,
      height: 1080,
      tabs: [{ id: 5, windowId: 2, active: true, url: 'https://vscode.dev/c' }],
    },
  ];
  const displays = [
    {
      id: 'macbook',
      isPrimary: true,
      bounds: { left: 1920, top: -143, width: 1728, height: 1117 },
      workArea: { left: 1920, top: -111, width: 1728, height: 1085 },
    },
    {
      id: 'dell',
      isPrimary: false,
      bounds: { left: 0, top: 0, width: 1920, height: 1080 },
      workArea: { left: 0, top: 0, width: 1920, height: 1080 },
    },
  ];
  const tabs = () => windows.flatMap((window) => window.tabs);
  let stored = {};
  globalThis.chrome = {
    tabs: {
      onActivated: event('activated'),
      onRemoved: event('removed'),
      query: async () => tabs(),
      update: async (id) => {
        const tab = tabs().find((candidate) => candidate.id === id);
        for (const candidate of windows.find(
          (window) => window.id === tab.windowId
        ).tabs)
          candidate.active = candidate.id === id;
        listeners.activated();
        return tab;
      },
    },
    windows: {
      onFocusChanged: event('focused'),
      getAll: async () => windows,
      update: async (id) => {
        for (const window of windows) window.focused = window.id === id;
        listeners.focused();
      },
    },
    runtime: { onMessage: event('message') },
    storage: {
      session: {
        get: async () => structuredClone(stored),
        set: async (value) => {
          stored = structuredClone(value);
        },
      },
    },
    system: { display: { getInfo: async () => structuredClone(displays) } },
  };
  await import('../src/ui/tab-management.js');
  const flush = () => new Promise((resolve) => setImmediate(resolve));
  const activeId = () =>
    windows.find((window) => window.focused).tabs.find((tab) => tab.active).id;
  const message = async (action, values = {}) => {
    listeners.message({ action, ...values }, { tab: { id: activeId() } });
    await flush();
  };
  const visit = async (id) => {
    const tab = await chrome.tabs.update(id);
    await chrome.windows.update(tab.windowId);
    await flush();
  };
  await flush();
  await visit(2);
  await visit(3);
  await message('cycle-tabs');
  assert.equal(activeId(), 2);
  await message('cycle-tabs');
  assert.equal(activeId(), 1);
  await message('cycle-tabs', { reverse: true });
  assert.equal(activeId(), 2);
  await message('tab-interaction');
  assert.deepEqual(stored.tabHistory.recent, [2, 3, 1]);
  await message('cycle-tabs');
  assert.equal(activeId(), 3);
  await import('../src/ui/tab-management.js?restart');
  await flush();
  await message('cycle-tabs');
  assert.equal(activeId(), 1);
  await message('cycle-tabs', { reverse: true });
  assert.equal(activeId(), 3);

  await message('select-vscode-tab', { index: 0 });
  assert.equal(activeId(), 5);
  assert.deepEqual(stored.tabHistory.recent, [5, 2, 3, 1]);
  displays[0].id = 'changed-macbook-id';
  displays[1].id = 'changed-dell-id';
  displays[1].workArea.height -= 32;
  await message('select-vscode-tab', { index: 0 });
  assert.equal(activeId(), 5);
  await message('select-vscode-tab', { index: 1 });
  assert.equal(activeId(), 2);
  await message('select-vscode-tab', { index: 2 });
  assert.equal(activeId(), 3);
  await message('select-vscode-tab', { index: 3 });
  assert.equal(activeId(), 3);
  windows[0].tabs = windows[0].tabs.filter((tab) => tab.id !== 2);
  listeners.removed(2);
  await flush();
  await message('cycle-tabs');
  assert.equal(activeId(), 5);
  displays.pop();
  windows[1].left = 1920;
  windows[1].top = -143;
  await message('select-vscode-tab', { index: 0 });
  assert.equal(activeId(), 3);

  windows[0].left = 2560;
  windows[0].top = 0;
  windows[1].left = 0;
  windows[1].top = 0;
  windows[1].width = 2560;
  windows[1].height = 1440;
  windows.push({
    id: 3,
    focused: false,
    left: -2560,
    top: 0,
    width: 2560,
    height: 1440,
    tabs: [
      {
        id: 6,
        windowId: 3,
        active: true,
        url: 'https://vscode.dev/left-first',
      },
      {
        id: 7,
        windowId: 3,
        active: false,
        url: 'https://vscode.dev/left-second',
      },
    ],
  });
  displays.splice(
    0,
    displays.length,
    {
      id: 'work-right',
      isPrimary: true,
      bounds: { left: 0, top: 0, width: 2560, height: 1440 },
      workArea: { left: 0, top: 32, width: 2560, height: 1408 },
    },
    {
      id: 'work-macbook',
      isPrimary: false,
      bounds: { left: 2560, top: 0, width: 1728, height: 1117 },
      workArea: { left: 2560, top: 32, width: 1728, height: 1085 },
    },
    {
      id: 'work-left',
      isPrimary: false,
      bounds: { left: -2560, top: 0, width: 2560, height: 1440 },
      workArea: { left: -2560, top: 32, width: 2560, height: 1408 },
    }
  );
  for (const [index, tabId] of [6, 7, 5, 3].entries()) {
    await message('select-vscode-tab', { index });
    assert.equal(activeId(), tabId);
  }
  displays[0].bounds.left = -2560;
  displays[2].bounds.left = 0;
  windows[1].left = -2560;
  windows[2].left = 0;
  await message('select-vscode-tab', { index: 0 });
  assert.equal(activeId(), 5);
  delete globalThis.chrome;
});

test('physical Option keys work in editors and input commits only once per visit', async () => {
  const listeners = {};
  const messages = [];
  const target = (prefix) => ({
    addEventListener: (type, listener) => {
      listeners[`${prefix}:${type}`] = listener;
    },
  });
  const document = { ...target('document'), visibilityState: 'visible' };
  class MouseEvent {}
  runInNewContext(
    await readFile(
      new URL('../src/ui/page-actions.js', import.meta.url),
      'utf8'
    ),
    {
      window: target('window'),
      document,
      MouseEvent,
      chrome: {
        runtime: {
          sendMessage: (message) =>
            messages.push(JSON.parse(JSON.stringify(message))),
        },
      },
    }
  );
  const key = (code, values = {}) => {
    const event = {
      code,
      key: 'a',
      altKey: true,
      ctrlKey: false,
      metaKey: false,
      shiftKey: false,
      repeat: false,
      isTrusted: true,
      prevented: false,
      stopped: false,
      preventDefault() {
        this.prevented = true;
      },
      stopImmediatePropagation() {
        this.stopped = true;
      },
      ...values,
    };
    listeners['window:keydown'](event);
    return event;
  };
  for (const [index, code] of [
    'KeyZ',
    'KeyX',
    'KeyC',
    'KeyV',
    'KeyB',
    'KeyN',
    'KeyM',
    'Comma',
    'Period',
  ].entries()) {
    const event = key(code, {
      key: 'macOS Option character',
      target: { tagName: 'TEXTAREA' },
    });
    assert.equal(event.prevented, true);
    assert.equal(event.stopped, true);
    assert.deepEqual(messages.at(-1), { action: 'select-vscode-tab', index });
  }
  key('KeyI');
  assert.deepEqual(messages.at(-1), { action: 'cycle-tabs', reverse: false });
  key('KeyI', { shiftKey: true });
  assert.deepEqual(messages.at(-1), { action: 'cycle-tabs', reverse: true });
  const rearrange = key('KeyI', { ctrlKey: true, metaKey: true });
  assert.equal(rearrange.prevented, true);
  assert.equal(rearrange.stopped, true);
  assert.deepEqual(messages.at(-1), { action: 'rearrange-tabs' });
  for (const [code, direction, windowDirection] of [
    ['KeyN', 'left', 'left'],
    ['KeyM', 'left', 'down'],
    ['Comma', 'right', 'up'],
    ['Period', 'right', 'right'],
  ]) {
    const event = key(code, { ctrlKey: true });
    assert.equal(event.prevented, true);
    assert.deepEqual(messages.at(-1), {
      action: 'move-tab',
      direction,
      betweenWindows: false,
    });
    key(code, { ctrlKey: true, metaKey: true });
    assert.deepEqual(messages.at(-1), {
      action: 'move-tab',
      direction: windowDirection,
      betweenWindows: true,
    });
  }
  const count = messages.length;
  key('KeyN', { ctrlKey: true, repeat: true });
  key('KeyI', { ctrlKey: true, metaKey: true, repeat: true });
  key('KeyI', { repeat: true });
  key('AltLeft', { key: 'Alt' });
  key('ShiftLeft', { key: 'Shift' });
  key('KeyI', { isTrusted: false });
  assert.equal(messages.length, count);
  key('KeyA', { altKey: false });
  key('KeyB', { altKey: false });
  assert.equal(messages.length, count + 1);
  assert.deepEqual(messages.at(-1), { action: 'tab-interaction' });
  listeners['document:visibilitychange']();
  const movement = Object.assign(new MouseEvent(), {
    type: 'pointermove',
    isTrusted: true,
    movementX: 0,
    movementY: 0,
  });
  listeners['window:pointermove'](movement);
  assert.equal(messages.length, count + 1);
  movement.movementX = 1;
  listeners['window:pointermove'](movement);
  assert.equal(messages.length, count + 2);
  key('KeyI');
  listeners['window:wheel']({ type: 'wheel', isTrusted: true });
  assert.deepEqual(messages.at(-1), { action: 'tab-interaction' });
});

test('rearranging and directional moves preserve groups, fullscreen placement, and private boundaries', async () => {
  /** @typedef {{ id: number, url: string, groupId: number, pinned: boolean, active: boolean, incognito: boolean, windowId: number }} MockTab */
  /** @typedef {{ id: number, left: number, top: number, width: number, height: number, state: string, tabs: MockTab[], focused: boolean, incognito: boolean }} MockWindow */
  /** @typedef {{ left: number, top: number, width: number, height: number }} Bounds */
  /** @typedef {{ id: string, bounds: Bounds, workArea: Bounds }} MockDisplay */
  /** @typedef {(message: { action: string, direction?: string, betweenWindows?: boolean }, sender: { tab: { id: number } }) => void} MessageListener */
  const displays = [0, 1000, 2000].map((left, index) => ({
    id: String(index),
    bounds: { left, top: 0, width: 1000, height: 800 },
    workArea: { left, top: 20, width: 1000, height: 780 },
  }));
  const [firstDisplay, secondDisplay, thirdDisplay] = displays;
  assert.ok(firstDisplay && secondDisplay && thirdDisplay);
  /** @type {MockWindow[]} */
  const windows = [];
  /** @type {({ id: number } & Partial<MockWindow>)[]} */
  const updates = [];
  /** @type {number[]} */
  const groupsMoved = [];
  /** @type {MessageListener} */
  let receiveMessage = () => {};
  /** @param {number} id */
  const makeTab = (id, code = false, groupId = -1) => ({
    id,
    url: code ? `https://vscode.dev/${id}` : `https://example.com/${id}`,
    groupId,
    pinned: false,
    active: false,
    incognito: false,
    windowId: 0,
  });
  /** @param {number} id @param {MockDisplay} display @param {MockTab[]} tabs */
  const addWindow = (id, display, tabs, incognito = false) => {
    const window = {
      id,
      ...display.bounds,
      state: 'fullscreen',
      tabs,
      incognito,
      focused: windows.length === 0,
    };
    for (const [index, tab] of tabs.entries()) {
      tab.windowId = id;
      tab.active = index === 0;
      tab.incognito = incognito;
    }
    windows.push(window);
    return window;
  };
  /** @param {number | number[]} ids @param {{ windowId: number, index: number }} options */
  const move = (ids, options) => {
    const destination = windows.find(
      (window) => window.id === options.windowId
    );
    assert.ok(destination, 'destination must still exist');
    const moved = (Array.isArray(ids) ? ids : [ids]).map((id) => {
      const source = windows.find((window) =>
        window.tabs.some((tab) => tab.id === id)
      );
      assert.ok(source, `tab ${id} must still exist`);
      const [tab] = source.tabs.splice(
        source.tabs.findIndex((tab) => tab.id === id),
        1
      );
      assert.ok(tab);
      tab.windowId = destination.id;
      return tab;
    });
    destination.tabs.splice(
      options.index < 0 ? destination.tabs.length : options.index,
      0,
      ...moved
    );
    for (let index = windows.length - 1; index >= 0; index -= 1) {
      if (windows[index]?.tabs.length === 0) windows.splice(index, 1);
    }
    return moved;
  };
  const noopEvent = { addListener() {} };
  const browserApi = {
    tabs: {
      onActivated: noopEvent,
      onRemoved: noopEvent,
      query: async () => windows.flatMap((window) => window.tabs),
      /** @param {number} id */
      update: async (id) => {
        const window = windows.find((candidate) =>
          candidate.tabs.some((tab) => tab.id === id)
        );
        assert.ok(window);
        for (const tab of window.tabs) tab.active = tab.id === id;
        return window.tabs.find((tab) => tab.id === id);
      },
      /** @param {number | number[]} ids @param {{ windowId: number, index: number }} options */
      move: async (ids, options) => {
        for (const id of Array.isArray(ids) ? ids : [ids]) {
          const tab = windows
            .flatMap((window) => window.tabs)
            .find((candidate) => candidate.id === id);
          assert.ok(tab);
          if (tab.groupId !== -1) assert.equal(tab.windowId, options.windowId);
        }
        return move(ids, options);
      },
      /** @param {number} id */
      ungroup: async (id) => {
        const tab = windows
          .flatMap((window) => window.tabs)
          .find((candidate) => candidate.id === id);
        assert.ok(tab);
        tab.groupId = -1;
      },
    },
    tabGroups: {
      TAB_GROUP_ID_NONE: -1,
      /** @param {number} groupId @param {{ windowId: number, index: number }} options */
      move: async (groupId, options) => {
        groupsMoved.push(groupId);
        return move(
          windows
            .flatMap((window) => window.tabs)
            .filter((tab) => tab.groupId === groupId)
            .map((tab) => tab.id),
          options
        );
      },
    },
    windows: {
      onFocusChanged: noopEvent,
      getAll: async () => windows,
      /** @param {number} id @param {Partial<MockWindow>} options */
      update: async (id, options) => {
        updates.push({ id, ...options });
        const window = windows.find((candidate) => candidate.id === id);
        assert.ok(window);
        if (options.focused) {
          for (const candidate of windows) candidate.focused = false;
        }
        Object.assign(window, options);
      },
      /** @param {Bounds & { tabId: number, incognito?: boolean }} options */
      create: async (options) => {
        const window = {
          id: Math.max(...windows.map((candidate) => candidate.id)) + 1,
          left: options.left,
          top: options.top,
          width: options.width,
          height: options.height,
          state: 'normal',
          tabs: [],
          focused: false,
          incognito: options.incognito ?? false,
        };
        windows.push(window);
        move(options.tabId, { windowId: window.id, index: -1 });
        return window;
      },
    },
    runtime: {
      onMessage: {
        /** @param {MessageListener} listener */
        addListener(listener) {
          receiveMessage = listener;
        },
      },
    },
    storage: { session: { get: async () => ({}), set: async () => {} } },
    system: { display: { getInfo: async () => displays } },
  };
  Reflect.set(globalThis, 'chrome', browserApi);
  addWindow(1, firstDisplay, [makeTab(1, true), makeTab(2, true)]);
  addWindow(2, secondDisplay, [makeTab(3), makeTab(4, true), makeTab(5, true)]);
  addWindow(3, thirdDisplay, [
    makeTab(6),
    makeTab(7),
    makeTab(8, true),
    makeTab(9, true),
  ]);
  addWindow(4, thirdDisplay, [
    makeTab(10, true, 8),
    makeTab(11, false, 8),
    makeTab(12, true),
  ]);
  const moduleUrl = new URL(
    '../src/ui/tab-management.js?rearrange',
    import.meta.url
  );
  const { rearrangeTabs } = await import(moduleUrl.href);
  await rearrangeTabs(structuredClone(windows), displays);
  const browser = windows.find((window) =>
    window.tabs.some((tab) => tab.id === 3)
  );
  assert.ok(browser);
  assert.deepEqual(
    browser.tabs.map((tab) => tab.id),
    [3, 6, 7, 10, 11]
  );
  assert.equal(browser.left, 0);
  assert.deepEqual(groupsMoved, [8]);
  assert.deepEqual(
    browser.tabs.filter((tab) => tab.groupId === 8).map((tab) => tab.id),
    [10, 11]
  );
  const codeWindows = windows.filter((window) => window !== browser);
  assert.deepEqual(
    codeWindows.map((window) => window.tabs.length).sort(),
    [3, 4]
  );
  assert.deepEqual(
    codeWindows.map((window) => window.left).sort(),
    [1000, 2000]
  );
  assert.ok(windows.every((window) => window.state === 'fullscreen'));
  assert.equal(windows.length, 3);
  assert.equal(windows.flatMap((window) => window.tabs).length, 12);
  const normalUpdate = updates.findIndex(
    (update) => update.id === browser.id && update.state === 'normal'
  );
  assert.ok(normalUpdate >= 0);
  assert.equal(updates[normalUpdate + 1]?.left, 0);
  assert.equal(updates[normalUpdate + 2]?.state, 'fullscreen');

  windows.splice(0);
  addWindow(1, firstDisplay, [makeTab(1), makeTab(2, true), makeTab(3, true)]);
  addWindow(2, firstDisplay, [makeTab(4), makeTab(5, true)]);
  addWindow(3, firstDisplay, [makeTab(6, true), makeTab(7, true)]);
  await rearrangeTabs(structuredClone(windows), displays.slice(0, 1));
  assert.deepEqual(
    windows.find((window) => window.id === 1)?.tabs.map((tab) => tab.id),
    [1, 4]
  );
  assert.deepEqual(
    windows
      .filter((window) => window.id !== 1)
      .map((window) => window.tabs.length)
      .sort(),
    [2, 3]
  );

  windows.splice(0);
  addWindow(1, firstDisplay, [makeTab(1), makeTab(2, true), makeTab(3, true)]);
  await rearrangeTabs(structuredClone(windows), displays);
  assert.equal(windows.length, 3);
  assert.deepEqual(
    windows.map((window) => window.left).sort(),
    [0, 1000, 2000]
  );
  assert.ok(windows.every((window) => window.tabs.length === 1));

  windows.splice(0);
  addWindow(1, firstDisplay, [makeTab(1, true), makeTab(2)]);
  const privateWindow = addWindow(
    2,
    secondDisplay,
    [makeTab(3), makeTab(4, true)],
    true
  );
  const privateSnapshot = structuredClone(privateWindow);
  const flush = () => new Promise((resolve) => setImmediate(resolve));
  await flush();
  receiveMessage({ action: 'rearrange-tabs' }, { tab: { id: 1 } });
  await flush();
  assert.deepEqual(privateWindow, privateSnapshot);
  const foreground = windows.find((window) => window.focused);
  assert.ok(foreground);
  assert.equal(foreground.tabs.find((tab) => tab.active)?.id, 1);
  assert.equal(foreground.left, secondDisplay.bounds.left);
  assert.equal(
    windows.find((window) => window.tabs.some((tab) => tab.id === 2))?.left,
    0
  );

  await browserApi.tabs.update(4);
  await browserApi.windows.update(privateWindow.id, { focused: true });
  const normalWindows = structuredClone(
    windows.filter((window) => !window.incognito)
  );
  receiveMessage({ action: 'rearrange-tabs' }, { tab: { id: 4 } });
  await flush();
  assert.deepEqual(
    windows.filter((window) => !window.incognito),
    normalWindows
  );
  const privateCode = windows.find((window) =>
    window.tabs.some((tab) => tab.id === 4)
  );
  assert.ok(privateCode);
  assert.equal(privateCode.incognito, true);
  assert.equal(privateCode.focused, true);
  assert.equal(privateCode.left, secondDisplay.bounds.left);

  windows.splice(0);
  const current = makeTab(1);
  const source = addWindow(1, firstDisplay, [
    current,
    makeTab(2, false, 8),
    makeTab(3, false, 8),
    makeTab(4),
  ]);
  /** @param {string} direction */
  const moveTab = async (direction, betweenWindows = false) => {
    receiveMessage(
      { action: 'move-tab', direction, betweenWindows },
      { tab: { id: current.id } }
    );
    await flush();
  };
  await moveTab('right');
  assert.deepEqual(
    source.tabs.map((tab) => tab.id),
    [2, 3, 1, 4]
  );
  await moveTab('left');
  assert.deepEqual(
    source.tabs.map((tab) => tab.id),
    [1, 2, 3, 4]
  );
  assert.equal(current.groupId, -1);
  const destination = addWindow(2, secondDisplay, [makeTab(5)]);
  await moveTab('right', true);
  assert.deepEqual(
    destination.tabs.map((tab) => tab.id),
    [5, 1]
  );
  assert.equal(destination.focused, true);
  await moveTab('left', true);
  assert.equal(current.windowId, source.id);
  assert.equal(source.focused, true);

  windows.splice(windows.indexOf(destination), 1);
  await moveTab('down', true);
  const created = windows.find((window) => window.id === current.windowId);
  assert.ok(created);
  assert.equal(created.left, secondDisplay.bounds.left);
  assert.equal(created.state, 'fullscreen');
  assert.equal(created.focused, true);
  await moveTab('right', true);
  assert.equal(
    windows.find((window) => window.id === current.windowId)?.left,
    thirdDisplay.bounds.left
  );
  assert.ok(
    !windows.includes(created),
    'moving the last tab closes its old window'
  );
  await moveTab('up', true);
  assert.equal(current.windowId, source.id);

  displays.splice(2, 1);
  secondDisplay.bounds = { left: 0, top: 800, width: 1000, height: 800 };
  secondDisplay.workArea = { left: 0, top: 820, width: 1000, height: 780 };
  windows.splice(0);
  current.groupId = 8;
  const groupedNeighbor = makeTab(2, false, 8);
  const verticalSource = addWindow(1, firstDisplay, [current, groupedNeighbor]);
  await moveTab('right');
  assert.deepEqual(
    verticalSource.tabs.map((tab) => tab.id),
    [2, 1]
  );
  await moveTab('right');
  assert.deepEqual(
    verticalSource.tabs.map((tab) => tab.id),
    [2, 1]
  );
  await moveTab('right', true);
  const below = windows.find((window) => window.id === current.windowId);
  assert.ok(below);
  assert.equal(below.top, secondDisplay.workArea.top);
  assert.equal(below.state, 'fullscreen');
  assert.equal(current.groupId, -1);
  assert.equal(groupedNeighbor.groupId, 8);
  await moveTab('left', true);
  assert.equal(current.windowId, verticalSource.id);

  windows.splice(0);
  current.pinned = true;
  const pinnedSource = addWindow(1, firstDisplay, [current, makeTab(2)]);
  await moveTab('right');
  assert.deepEqual(
    pinnedSource.tabs.map((tab) => tab.id),
    [1, 2]
  );
  const privateTarget = addWindow(2, secondDisplay, [makeTab(3)], true);
  const untouchedPrivate = structuredClone(privateTarget);
  await moveTab('down', true);
  assert.deepEqual(privateTarget, untouchedPrivate);
  assert.notEqual(current.windowId, privateTarget.id);
  assert.equal(
    windows.find((window) => window.id === current.windowId)?.incognito,
    false
  );
  assert.equal(current.pinned, true);

  windows.splice(0);
  displays.splice(1);
  addWindow(1, firstDisplay, [current]);
  for (const direction of ['left', 'down', 'up', 'right'])
    await moveTab(direction, true);
  assert.equal(windows.length, 1);
  assert.equal(current.windowId, 1);
  Reflect.deleteProperty(globalThis, 'chrome');
});
