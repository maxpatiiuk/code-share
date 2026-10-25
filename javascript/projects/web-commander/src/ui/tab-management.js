export const displayOrder = [
  { width: 2560, height: 1440 },
  { width: 1920, height: 1080 },
  { width: 1728, height: 1085 },
];

/** @typedef {{ recent: number[], cycle: number[] | undefined, current: number | undefined }} TabHistory */
/** @typedef {'left' | 'down' | 'up' | 'right'} Direction */
/** @typedef {{ left?: number, top?: number, width?: number, height?: number }} Rectangle */

/** @type {TabHistory} */
let history = { recent: [], cycle: undefined, current: undefined };
let pending = restoreHistory();

chrome.tabs.onActivated.addListener(() => enqueue(recordForeground));
chrome.windows.onFocusChanged.addListener(() => enqueue(recordForeground));
chrome.tabs.onRemoved.addListener((tabId) =>
  enqueue(async () => {
    history.recent = history.recent.filter((id) => id !== tabId);
    history.cycle = history.cycle?.filter((id) => id !== tabId);
    await recordForeground();
  })
);

chrome.runtime.onMessage.addListener((message, sender) => {
  const tabId = sender.tab?.id;
  if (
    tabId === undefined ||
    ![
      'cycle-tabs',
      'select-vscode-tab',
      'tab-interaction',
      'rearrange-tabs',
      'move-tab',
    ].includes(message?.action)
  )
    return;

  enqueue(async () => {
    const windows = await chrome.windows.getAll({
      populate: true,
      windowTypes: ['normal'],
    });
    const foreground = windows
      .find((window) => window.focused)
      ?.tabs?.find((tab) => tab.active);
    if (foreground?.id !== tabId) return;

    if (
      message.action === 'move-tab' &&
      ['left', 'down', 'up', 'right'].includes(message.direction)
    ) {
      await moveCurrentTab(
        foreground,
        windows.filter((window) => window.incognito === foreground.incognito),
        message.direction,
        message.betweenWindows === true
      );
      await activateTab(tabId);
      commit(tabId);
    } else if (message.action === 'rearrange-tabs') {
      await rearrangeTabs(
        windows.filter((window) => window.incognito === foreground.incognito),
        await orderedDisplays()
      );
      await activateTab(tabId);
      commit(tabId);
    } else if (message.action === 'cycle-tabs') {
      await cycleTabs(tabId, message.reverse === true ? -1 : 1);
    } else if (
      message.action === 'select-vscode-tab' &&
      Number.isInteger(message.index) &&
      message.index >= 0 &&
      message.index < 9
    ) {
      await selectVsCodeTab(windows, message.index);
    } else if (message.action === 'tab-interaction') {
      commit(tabId);
    }
  });
});

/** @param {() => Promise<void>} operation */
function enqueue(operation) {
  pending = pending
    .then(async () => {
      await operation();
      await chrome.storage.session.set({ tabHistory: history });
    })
    .catch(console.error);
}

async function restoreHistory() {
  const { tabHistory } = await chrome.storage.session.get('tabHistory');
  if (tabHistory) history = tabHistory;
  const tabs = await chrome.tabs.query({});
  const openIds = new Set(tabs.map((tab) => tab.id));
  history.recent = history.recent.filter((id) => openIds.has(id));
  history.cycle = history.cycle?.filter((id) => openIds.has(id));
  await recordForeground();
}

async function recordForeground() {
  const windows = await chrome.windows.getAll({
    populate: true,
    windowTypes: ['normal'],
  });
  const tab = windows
    .find((window) => window.focused)
    ?.tabs?.find((candidate) => candidate.active);
  if (tab?.id !== undefined && tab.id !== history.current) commit(tab.id);
}

/** @param {number} tabId */
function commit(tabId) {
  history.recent = [tabId, ...history.recent.filter((id) => id !== tabId)];
  history.current = tabId;
  history.cycle = undefined;
}

/** @param {number} tabId @param {number} direction */
async function cycleTabs(tabId, direction) {
  if (!history.recent.includes(tabId)) commit(tabId);
  history.cycle ??= [...history.recent];
  const cycle = history.cycle;
  const index =
    (cycle.indexOf(tabId) + direction + cycle.length) % cycle.length;
  const target = cycle[index];
  if (target !== undefined && target !== tabId) await activateTab(target);
}

/** @param {number} tabId */
async function activateTab(tabId) {
  history.current = tabId;
  const tab = await chrome.tabs.update(tabId, { active: true });
  await chrome.windows.update(tab.windowId, { focused: true });
}

/** @param {chrome.tabs.Tab} tab @param {chrome.windows.Window[]} windows @param {Direction} direction @param {boolean} betweenWindows */
async function moveCurrentTab(tab, windows, direction, betweenWindows) {
  const source = windows.find((window) => window.id === tab.windowId);
  if (!source) return;
  if (!betweenWindows) {
    await moveWithinWindow(tab, source, direction === 'left' ? -1 : 1);
    return;
  }

  const displays = await orderedDisplays();
  const sourceDisplay = displayForWindow(source, displays);
  /** @type {Record<Direction, Direction>} */
  const alternatives = { left: 'up', down: 'right', up: 'left', right: 'down' };
  for (const nextDirection of [direction, alternatives[direction]]) {
    const target = nearestInDirection(
      source,
      windows.filter((window) => window.id !== source.id),
      nextDirection
    );
    if (target) {
      if (isGrouped(tab)) await chrome.tabs.ungroup(tab.id);
      await chrome.tabs.move(tab.id, {
        windowId: target.id,
        index: tab.pinned ? 0 : -1,
      });
      return;
    }
    if (!sourceDisplay) continue;
    const display = nearestInDirection(
      sourceDisplay.bounds,
      displays
        .filter((candidate) => candidate.id !== sourceDisplay.id)
        .map((candidate) => ({ ...candidate.bounds, display: candidate })),
      nextDirection
    )?.display;
    if (!display) continue;
    if (isGrouped(tab)) await chrome.tabs.ungroup(tab.id);
    const window = await chrome.windows.create({
      tabId: tab.id,
      incognito: tab.incognito,
      focused: true,
      ...display.workArea,
    });
    await enterFullscreen(window);
    return;
  }
}

/** @param {chrome.tabs.Tab} tab @param {chrome.windows.Window} window @param {number} step */
async function moveWithinWindow(tab, window, step) {
  const tabs = window.tabs ?? [];
  const index = tabs.findIndex((candidate) => candidate.id === tab.id);
  let targetIndex = index + step;
  const neighbor = tabs[targetIndex];
  if (!neighbor || Boolean(neighbor.pinned) !== Boolean(tab.pinned)) return;
  if (isGrouped(tab)) {
    if (neighbor.groupId !== tab.groupId) return;
  } else if (isGrouped(neighbor)) {
    while (tabs[targetIndex + step]?.groupId === neighbor.groupId)
      targetIndex += step;
  }
  await chrome.tabs.move(tab.id, { windowId: window.id, index: targetIndex });
}

/** @template {Rectangle} Target @param {Rectangle} source @param {Target[]} candidates @param {Direction} direction */
function nearestInDirection(source, candidates, direction) {
  const sourceX = (source.left ?? 0) + (source.width ?? 0) / 2;
  const sourceY = (source.top ?? 0) + (source.height ?? 0) / 2;
  const horizontal = direction === 'left' || direction === 'right';
  const sign = direction === 'left' || direction === 'up' ? -1 : 1;
  let nearest;
  let nearestDistance = Infinity;
  for (const candidate of candidates) {
    const deltaX = (candidate.left ?? 0) + (candidate.width ?? 0) / 2 - sourceX;
    const deltaY = (candidate.top ?? 0) + (candidate.height ?? 0) / 2 - sourceY;
    const forward = (horizontal ? deltaX : deltaY) * sign;
    const sideways = horizontal ? deltaY : deltaX;
    if (forward <= 0 || Math.abs(sideways) > forward) continue;
    const distance = deltaX ** 2 + deltaY ** 2;
    if (distance < nearestDistance) {
      nearest = candidate;
      nearestDistance = distance;
    }
  }
  return nearest;
}

/** @param {chrome.windows.Window[]} windows @param {number} index */
async function selectVsCodeTab(windows, index) {
  const displays = await orderedDisplays();
  const orderedWindows = displays.flatMap((display) =>
    windows.filter(
      (window) => displayForWindow(window, displays)?.id === display.id
    )
  );
  const tabs = orderedWindows
    .flatMap((window) => window.tabs ?? [])
    .filter(isVsCodeTab);
  const target = tabs[index];
  if (target?.id === undefined) return;
  await activateTab(target.id);
  commit(target.id);
}

/** @param {chrome.windows.Window[]} windows @param {chrome.system.display.DisplayUnitInfo[]} displays */
export async function rearrangeTabs(windows, displays) {
  const firstDisplay = displays[0];
  if (!firstDisplay) return;
  const tabs = windows.flatMap((window) => window.tabs ?? []);
  const codeTabs = tabs.filter(
    (tab) => !tab.pinned && isVsCodeTab(tab) && !isGrouped(tab)
  );
  const browsingTabs = tabs.filter(
    (tab) => !tab.pinned && (!isVsCodeTab(tab) || isGrouped(tab))
  );
  let browser =
    browsingTabs.length > 0
      ? windows.find(
          (window) => displayForWindow(window, displays)?.id === firstDisplay.id
        )
      : undefined;

  if (!browser && browsingTabs.length > 0) {
    browser = await chrome.windows.create({
      incognito: browsingTabs[0]?.incognito,
      focused: true,
      ...firstDisplay.workArea,
    });
  }
  if (browser) {
    const placeholders =
      browser.tabs?.filter(
        (tab) => !tabs.some((original) => original.id === tab.id)
      ) ?? [];
    const movedGroups = new Set();
    for (const tab of browsingTabs) {
      if (tab.windowId === browser.id) continue;
      if (isGrouped(tab)) {
        if (movedGroups.has(tab.groupId)) continue;
        await chrome.tabGroups.move(tab.groupId, {
          windowId: browser.id,
          index: -1,
        });
        movedGroups.add(tab.groupId);
      } else {
        await chrome.tabs.move(tab.id, {
          windowId: browser.id,
          index: tab.pinned ? 0 : -1,
        });
      }
    }
    for (const tab of placeholders) await chrome.tabs.remove(tab.id);
    await enterFullscreen(browser);
  }

  if (codeTabs.length === 0) return;
  const freeDisplays = browser ? displays.slice(1) : displays;
  const candidates = windows.filter(
    (window) =>
      window.id !== browser?.id &&
      window.tabs?.some((tab) => codeTabs.includes(tab))
  );
  const count = Math.min(
    codeTabs.length,
    freeDisplays.length || Math.max(1, candidates.length)
  );
  /** @type {{ window: chrome.windows.Window, display: chrome.system.display.DisplayUnitInfo, anchor: chrome.tabs.Tab }[]} */
  const destinations = [];
  const reserved = new Set();
  for (let index = 0; index < count; index += 1) {
    const display = freeDisplays[index] ?? firstDisplay;
    const candidate = candidates.find(
      (window) => displayForWindow(window, displays)?.id === display.id
    );
    if (candidate) {
      candidates.splice(candidates.indexOf(candidate), 1);
      const anchor = codeTabs.find((tab) => tab.windowId === candidate.id);
      if (anchor) {
        reserved.add(anchor.id);
        destinations.push({ window: candidate, display, anchor });
      }
    } else {
      const anchor = codeTabs.find((tab) => !reserved.has(tab.id));
      if (!anchor) break;
      reserved.add(anchor.id);
      const window = await chrome.windows.create({
        tabId: anchor.id,
        incognito: anchor.incognito,
        focused: true,
        ...display.workArea,
      });
      destinations.push({ window, display, anchor });
    }
  }

  const remaining = codeTabs.filter((tab) => !reserved.has(tab.id));
  for (const [index, destination] of destinations.entries()) {
    const size =
      Math.floor(codeTabs.length / destinations.length) +
      (index < codeTabs.length % destinations.length ? 1 : 0);
    const assigned = [destination.anchor, ...remaining.splice(0, size - 1)];
    await chrome.tabs.move(
      assigned.map((tab) => tab.id),
      { windowId: destination.window.id, index: -1 }
    );
    await enterFullscreen(destination.window);
  }
}

/** @param {chrome.tabs.Tab} tab */
function isVsCodeTab(tab) {
  const url = tab.pendingUrl ?? tab.url;
  if (!url) return false;
  const hostname = new URL(url).hostname;
  return hostname === 'vscode.localhost' || hostname === 'vscode.dev';
}

/** @param {chrome.tabs.Tab} tab */
function isGrouped(tab) {
  return (
    tab.groupId !== undefined &&
    tab.groupId !== chrome.tabGroups.TAB_GROUP_ID_NONE
  );
}

/** @param {chrome.windows.Window} window */
async function enterFullscreen(window) {
  if (window.state === 'fullscreen') return;
  await chrome.windows.update(window.id, { focused: true });
  await chrome.windows.update(window.id, { state: 'fullscreen' });
}

async function orderedDisplays() {
  const displays = await chrome.system.display.getInfo();
  return displays.sort(
    (first, second) =>
      displayPriority(first) - displayPriority(second) ||
      first.bounds.left - second.bounds.left
  );
}

/** @param {chrome.system.display.DisplayUnitInfo} display */
function displayPriority(display) {
  const index = displayOrder.findIndex(
    ({ width, height }) =>
      Math.abs(display.workArea.width - width) <= 64 &&
      Math.abs(display.workArea.height - height) <= 64
  );
  return index === -1 ? displayOrder.length : index;
}

/** @param {chrome.windows.Window} window @param {chrome.system.display.DisplayUnitInfo[]} displays */
function displayForWindow(window, displays) {
  const left = window.left ?? 0;
  const top = window.top ?? 0;
  const right = left + (window.width ?? 0);
  const bottom = top + (window.height ?? 0);
  let largestArea = -1;
  let selected = displays.find((display) => display.isPrimary);
  for (const display of displays) {
    const bounds = display.bounds;
    const area =
      Math.max(
        0,
        Math.min(right, bounds.left + bounds.width) -
          Math.max(left, bounds.left)
      ) *
      Math.max(
        0,
        Math.min(bottom, bounds.top + bounds.height) - Math.max(top, bounds.top)
      );
    if (area > largestArea) {
      largestArea = area;
      selected = display;
    }
  }
  return selected;
}
