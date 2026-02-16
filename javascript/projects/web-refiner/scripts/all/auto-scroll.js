/**
 * Emulate Windows middle-click auto-scroll behavior on web pages.
 * This opens on right click on non-interactive element.
 * It also opens a menu with quick actions.
 */

'use strict';
(() => {
  let isAutoScrolling = false;
  let startX = 0,
    startY = 0;
  let currentX = 0,
    currentY = 0;
  /** @type {number | null} */
  let scrollRaf = null;
  let allowNativeMenu = false;
  const scrollMultiplier = 0.1;
  const overlaySize = 100; // square overlay size in pixels
  /** @type {HTMLDialogElement | null} */
  let controlOverlay = null;
  /** @type {DOMRect | null} */
  let controlOverlayRect = null;
  /** @type {Element | null} */
  let scrollTarget = null;
  let needsRetarget = true;
  const retargetThresholdPx = 6;
  let lastRetargetX = 0;
  let lastRetargetY = 0;
  let lastFrameTime = 0;

  // Not using adoptedStylesheets due to https://bugzilla.mozilla.org/show_bug.cgi?id=1770592
  const style = document.createElement('style');
  style.innerText = `
  #scroll-control-overlay::backdrop,
  #scroll-control-overlay:popover-open::backdrop {
    all: revert !important;
    background: transparent !important;
  }`;

  /**
   * Create the square overlay with a 3x3 grid of buttons.
   * @param {number} x
   * @param {number} y
   */
  function createControlOverlay(x, y) {
    controlOverlay = document.createElement('dialog');
    controlOverlay.id = 'scroll-control-overlay';
    controlOverlay.style.inset = 'auto';
    controlOverlay.style.position = 'fixed';
    controlOverlay.style.left = x - overlaySize / 2 + 'px';
    controlOverlay.style.top = y - overlaySize / 2 + 'px';
    controlOverlay.style.width = overlaySize + 'px';
    controlOverlay.style.height = overlaySize + 'px';
    controlOverlay.style.zIndex = 9999;
    controlOverlay.style.margin = '0';
    controlOverlay.style.padding = '0';
    controlOverlay.style.display = 'grid';
    controlOverlay.style.setProperty('opacity', '1', 'important');
    controlOverlay.style.setProperty('visibility', 'visible', 'important');
    controlOverlay.style.gridTemplateColumns = 'repeat(3, 1fr)';
    controlOverlay.style.gridTemplateRows = 'repeat(3, 1fr)';
    controlOverlay.style.boxSizing = 'border-box';
    controlOverlay.style.background = 'transparent';
    // Allow interactions on the overlay.
    controlOverlay.style.pointerEvents = 'auto';
    controlOverlay.style.outline = 'none';
    controlOverlay.style.border = 'none';

    if (!style.isConnected) {
      document.head.append(style);
    }

    const container = document.createElement('div');
    const shadowRoot = container.attachShadow({ mode: 'closed' });
    container.style.display = 'contents';
    controlOverlay.append(container);

    allowNativeMenu = false;

    // Define the button actions.
    const actions = {
      X: () => window.close(),
      ' ': undefined,
      O: () => {
        allowNativeMenu = true;
      }, //N: () => window.open(window.location.href, "_blank"),
      '<': () => window.history.back(),
      '  ': undefined /*C: () => {
        const selectedText = window.getSelection().toString();
        if (selectedText) {
          navigator.clipboard
            .writeText(selectedText)
            //.then(() => console.log('Copied to clipboard:', selectedText))
            .catch((err) => console.error("Error copying text: ", err));
        }
      },*/,
      '>': () => window.history.forward(),
      '^': () => location.reload(),
      //H: () => (window.location.href = "/"),
      /*V: () => {
        // If an input/textarea is focused, paste into it.
        if (
          document.activeElement &&
          (document.activeElement.tagName === "INPUT" ||
            document.activeElement.tagName === "TEXTAREA")
        ) {
          navigator.clipboard
            .readText()
            .then((text) => {
              let el = document.activeElement;
              if (typeof el.selectionStart === "number") {
                const start = el.selectionStart;
                const end = el.selectionEnd;
                const original = el.value;
                el.value =
                  original.substring(0, start) + text + original.substring(end);
                el.selectionStart = el.selectionEnd = start + text.length;
              } else {
                el.value += text;
              }
            })
            .catch((err) => alert("Paste failed: " + err));
        } else {
          //alert('No input element focused for paste.');
        }
      },*/
    };

    Object.keys(actions).forEach((letter) => {
      const isEmpty = letter.trim().length === 0;
      const btn = document.createElement(isEmpty ? 'div' : 'button');
      btn.style.width = '100%';
      btn.style.height = '100%';

      if (isEmpty) {
        btn.style.background = 'transparent';
      } else {
        btn.style.background = '#0006';
        btn.textContent = letter;
        btn.style.fontSize = '14px';
        btn.style.boxSizing = 'border-box';
        btn.style.cursor = 'pointer';
        btn.style.border = '1px solid #fff';
        // When a button is clicked (via left-click)...
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          actions[letter] && actions[letter]();
          endAutoScrollMode();
        });
        btn.addEventListener(
          'mouseup',
          function (e) {
            if (e.button !== 2) return;
            if (
              Math.abs(e.clientX - startX) >= 5 ||
              Math.abs(e.clientY - startY) >= 5
            ) {
              e.preventDefault();
              e.stopPropagation();
              btn.click();
            }
          },
          { once: true }
        );
      }

      shadowRoot.append(btn);
    });
    document.body.appendChild(controlOverlay);
    controlOverlay.popover = 'manual';
    controlOverlay.showPopover();
    controlOverlayRect = controlOverlay.getBoundingClientRect();
  }

  function removeControlOverlay() {
    if (controlOverlay) {
      controlOverlay.remove();
      controlOverlay = null;
    }
    controlOverlayRect = null;
  }

  // Ends auto-scroll mode: clears the interval, removes listeners, and removes the overlay.
  function endAutoScrollMode() {
    isAutoScrolling = false;
    if (scrollRaf) {
      cancelAnimationFrame(scrollRaf);
      scrollRaf = null;
    }
    lastFrameTime = 0;
    document.removeEventListener('mousemove', onMouseMove);
    removeControlOverlay();
    scrollTarget = null;
    needsRetarget = true;
  }

  // Returns true if the pointer is inside the overlay.
  function isPointerInsideOverlay() {
    if (!controlOverlayRect) return false;
    const rect = controlOverlayRect;
    return (
      currentX >= rect.left &&
      currentX <= rect.right &&
      currentY >= rect.top &&
      currentY <= rect.bottom
    );
  }

  /**
   * On middle-button down, either activate or toggle off auto-scroll.
   *
   * @param {MouseEvent} e
   */
  function onMouseDown(e) {
    // If already in auto-scroll mode and the click is not on the overlay, toggle off.
    if (isAutoScrolling) {
      if (controlOverlay && e.target?.closest('#scroll-control-overlay')) {
        // If clicking inside the overlay, let mouseup handle it.
        return;
      }
      e.preventDefault();
      e.stopPropagation();
      endAutoScrollMode();
      return;
    }
    // Activate auto-scroll mode.
    e.preventDefault();
    e.stopPropagation();
    isAutoScrolling = true;
    startX = e.clientX;
    startY = e.clientY;
    currentX = e.clientX;
    currentY = e.clientY;
    scrollTarget = null;
    needsRetarget = true;
    lastRetargetX = currentX;
    lastRetargetY = currentY;
    createControlOverlay(e.clientX, e.clientY);
    document.addEventListener('mousemove', onMouseMove, { passive: true });
    scrollRaf = requestAnimationFrame(stepScroll);
  }

  /**
   * @param {MouseEvent} event
   */
  function onMouseMove(event) {
    if (!isAutoScrolling) return;
    currentX = event.clientX;
    currentY = event.clientY;
    const dx = currentX - lastRetargetX;
    const dy = currentY - lastRetargetY;
    if (Math.hypot(dx, dy) >= retargetThresholdPx) {
      needsRetarget = true;
    }
  }

  /**
   * @param {Element} el
   * @param {number} dx
   * @param {number} dy
   */
  function isAtScrollEdge(el, dx, dy) {
    const atXEdge =
      (dx > 0 && el.scrollLeft + el.clientWidth >= el.scrollWidth) ||
      (dx < 0 && el.scrollLeft <= 0);
    const atYEdge =
      (dy > 0 && el.scrollTop + el.clientHeight >= el.scrollHeight) ||
      (dy < 0 && el.scrollTop <= 0);
    return atXEdge && atYEdge;
  }

  function retargetScrollElement() {
    scrollTarget = findNearestScrollableElement(currentX, currentY);
    needsRetarget = false;
    lastRetargetX = currentX;
    lastRetargetY = currentY;
  }

  /**
   * @param {number} timestamp
   */
  function stepScroll(timestamp) {
    if (!isAutoScrolling) return;
    if (!lastFrameTime) lastFrameTime = timestamp;
    const dt = Math.min(timestamp - lastFrameTime, 64);
    lastFrameTime = timestamp;

    if (!isPointerInsideOverlay()) {
      const dx = currentX - startX;
      const dy = currentY - startY;

      if (needsRetarget || !scrollTarget) retargetScrollElement();

      let el = scrollTarget;
      let guard = 0;
      while (el && guard < 10 && isAtScrollEdge(el, dx, dy)) {
        el = el.parentElement;
        guard += 1;
      }

      if (el) {
        const factor = scrollMultiplier * (dt / 16);
        el.scrollTop += dy * factor;
        el.scrollLeft += dx * factor;
        scrollTarget = el;
      }
    }

    scrollRaf = requestAnimationFrame(stepScroll);
  }

  /**
   * @param {MouseEvent} event
   */
  function customContextMenuHandler(event) {
    // Only act if the event wasn't already prevented and our flag is on.
    if (!event.defaultPrevented) {
      if (isAutoScrolling) {
        if (controlOverlay?.contains(event.target)) {
          event.preventDefault();
          event.stopPropagation();
          event.target.click();
        } else {
          event.preventDefault();
          event.stopPropagation();
          endAutoScrollMode();
        }
      } else if (allowNativeMenu) {
        allowNativeMenu = false;
        return;
      } else if (
        isInteractiveClick(event) ||
        window.getSelection?.().toString()
      ) {
        return;
      } else {
        event.preventDefault();
        onMouseDown(event);
      }
    }
  }
  /**
   * @param {MouseEvent} event
   */
  function isInteractiveClick(event) {
    const interactiveSelectors = [
      'a',
      'button',
      'input',
      'textarea',
      'select',
      '[role="button"]',
      // Removed tabindex=0 check as github's README md viewer (if side bar is
      // visible) uses tabindex0 on non interactive
      // div.data-selector="repos-split-pane-content" container
      '[contenteditable=plaintext-only]',
      '[contenteditable=true]',
    ].join(',');

    return !!event.target?.closest(interactiveSelectors);
  }

  // Attach our handler in the bubbling phase so that defaultPrevented reflects other listeners.
  document.addEventListener('contextmenu', customContextMenuHandler);

  /**
   * @param {Element} el
   */
  function isScrollable(el) {
    const style = window.getComputedStyle(el);
    const overflowY = style.overflowY;
    const overflowX = style.overflowX;
    const canScrollY =
      (overflowY === 'auto' || overflowY === 'scroll') &&
      el.scrollHeight > el.clientHeight;
    const canScrollX =
      (overflowX === 'auto' || overflowX === 'scroll') &&
      el.scrollWidth > el.clientWidth;
    return canScrollY || canScrollX;
  }

  // Finds the nearest scrollable element under the given (x, y) mouse position.
  // If that element is at the edge, it attempts to locate a parent scrollable container.
  function findNearestScrollableElement(
    x,
    y,
    el = document.elementFromPoint(x, y)
  ) {
    while (el) {
      if (isScrollable(el)) {
        return el;
      }
      el = el.parentElement;
    }
    // Fallback to the main scrolling element.
    return document.scrollingElement || document.body;
  }
})();
