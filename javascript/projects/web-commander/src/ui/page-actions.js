'use strict';

const vscodeTabCodes = [
  'KeyZ',
  'KeyX',
  'KeyC',
  'KeyV',
  'KeyB',
  'KeyN',
  'KeyM',
  'Comma',
  'Period',
];
const tabMoveDirections = {
  KeyN: 'left',
  KeyM: 'down',
  Comma: 'up',
  Period: 'right',
};
let interactionReported = false;

window.addEventListener(
  'keydown',
  (event) => {
    if (!event.isTrusted) return;
    const index = vscodeTabCodes.indexOf(event.code);
    const cycle = event.code === 'KeyI';
    const rearrange =
      cycle &&
      event.altKey &&
      event.ctrlKey &&
      event.metaKey &&
      !event.shiftKey;
    const moveDirection =
      tabMoveDirections[
        /** @type {keyof typeof tabMoveDirections} */ (event.code)
      ];
    const move =
      moveDirection && event.ctrlKey && event.altKey && !event.shiftKey;
    if (
      move ||
      rearrange ||
      (event.altKey &&
        !event.ctrlKey &&
        !event.metaKey &&
        (cycle || (index !== -1 && !event.shiftKey)))
    ) {
      event.preventDefault();
      event.stopImmediatePropagation();
      if (event.repeat) return;
      interactionReported = false;
      chrome.runtime.sendMessage(
        move
          ? {
              action: 'move-tab',
              direction: event.metaKey
                ? moveDirection
                : index <= 6
                ? 'left'
                : 'right',
              betweenWindows: event.metaKey,
            }
          : rearrange
          ? { action: 'rearrange-tabs' }
          : cycle
          ? { action: 'cycle-tabs', reverse: event.shiftKey }
          : { action: 'select-vscode-tab', index }
      );
    } else if (!['Alt', 'Shift', 'Control', 'Meta'].includes(event.key)) {
      reportInteraction();
    }
  },
  { capture: true }
);

for (const type of [
  'pointerdown',
  'pointerup',
  'pointermove',
  'wheel',
  'contextmenu',
]) {
  window.addEventListener(
    type,
    (event) => {
      if (!event.isTrusted) return;
      if (
        event instanceof MouseEvent &&
        event.type === 'pointermove' &&
        event.movementX === 0 &&
        event.movementY === 0
      )
        return;
      reportInteraction();
    },
    { capture: true, passive: true }
  );
}

document.addEventListener('visibilitychange', resetInteraction);
window.addEventListener('focus', resetInteraction);

function resetInteraction() {
  interactionReported = false;
}

function reportInteraction() {
  if (interactionReported || document.visibilityState !== 'visible') return;
  interactionReported = true;
  chrome.runtime.sendMessage({ action: 'tab-interaction' });
}

document.addEventListener('@maxpatiiuk/web-commander:close-tab', () => {
  chrome.runtime.sendMessage({ action: 'close-tab' });
});
