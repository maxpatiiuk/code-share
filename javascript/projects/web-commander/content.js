'use strict';

/**
 * @import { RuleNode, Result } from './types';
 */

(() => {
  const symbolKey = Symbol.for('@maxpatiiuk/web-commander');
  /** @type {typeof globalThis & { [symbolKey]?: () => void }} */
  const global = globalThis;
  if (typeof global[symbolKey] === 'function') {
    global[symbolKey]?.();
    return;
  }
  Object.defineProperty(globalThis, symbolKey, { value: toggle });

  const urlPartColors = [
    'white',
    'red',
    'green',
    'blue',
    'yellow',
    'purple',
    'orange',
    'pink',
    'brown',
  ];

  /** @type {HTMLElement | undefined} */
  let shadowHost = undefined;
  /** @type {ShadowRoot | undefined} */
  let shadowRoot = undefined;
  /** @type {HTMLInputElement | undefined} */
  let input = undefined;
  /** @type {HTMLDivElement | undefined} */
  let preview = undefined;
  /** @type {Result[] | undefined} */
  let results = undefined;
  let resultIndex = 0;
  let isVisible = false;
  /** @type {RuleNode | undefined} */
  let rules = undefined;

  async function loadRules() {
    const rulesUrl = chrome.runtime.getURL('rules.js');
    const module = await import(rulesUrl);
    if (!module?.rules) {
      throw new Error('Rules module did not export `rules`.');
    }
    return module.rules;
  }

  function toggle() {
    shadowHost ??= instantiate();

    const show = !isVisible;

    if (show) {
      shadowHost.classList.add('visible');
      isVisible = true;
      requestAnimationFrame(() => input?.focus());
    } else {
      shadowHost.classList.remove('visible');
      isVisible = false;
      if (input) input.value = ''; // Reset
      results = undefined;
      renderResults();
    }
  }

  const styles = `
  :host {
    all: initial;
    z-index: 2147483647; /* Max signed 32-bit integer */
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 2rem;
    display: none;
  }
  :host(.visible) {
    display: block;
  }
  .container {
    background: #1e1e1e;
    border: 1px solid #333;
    border-radius: 12px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.5);
    width: min(80vw, 800px);
    overflow: hidden;
    color: #e0e0e0;
    display: flex;
    flex-direction: column;
  }
  input {
    background: transparent;
    border: none;
    font-size: 2rem;
    outline: none;
    color: #fff;
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
  }
  .preview {
    padding: 12px 20px;
    background: #252526;
    border-top: 1px solid #333;
    color: #858585;
    display: flex;
    flex-direction: column;

    span.branch-key {
      border: 1px solid #555;
      border-radius: 0.25rem;
      padding: 0.125rem;
      margin-right: 1rem;
      background: #333;
      color: #fff;
    }
  }
`;

  /** @returns {HTMLElement} */
  function instantiate() {
    shadowHost = document.createElement('web-commander-nav');
    shadowRoot = shadowHost.attachShadow({ mode: 'open' });

    const styleEl = document.createElement('style');
    styleEl.textContent = styles;

    const container = document.createElement('div');
    container.className = 'container';

    input = document.createElement('input');
    input.placeholder = '';
    input.type = 'text';
    input.autocomplete = 'off';

    preview = document.createElement('div');
    preview.className = 'preview';

    container.appendChild(input);
    container.appendChild(preview);
    shadowRoot.appendChild(styleEl);
    shadowRoot.appendChild(container);
    document.body.appendChild(shadowHost);

    // Event Listeners
    document.addEventListener(
      'keydown',
      (event) => {
        if (!isVisible) return;
        const target = /** @type {Node} */ (event.target);
        if (shadowHost?.contains(target) !== true) return;
        event.stopImmediatePropagation();
        if (event.key === 'Enter' && results !== undefined) {
          const result = results[resultIndex];
          event.preventDefault();
          if (event.shiftKey) {
            window.location.href = result.url;
          } else if (event.metaKey || event.ctrlKey) {
            window.open(result.url, '_blank');
          } else {
            chrome.runtime.sendMessage({
              action: 'open-tab',
              url: result.url,
              active: true,
            });
          }
          toggle();
        }
        if (event.key === 'Escape') {
          event.preventDefault();
          toggle();
        }
      },
      { capture: true }
    );

    input.addEventListener(
      'input',
      (event) => {
        if (preview === undefined) return;
        const target = /** @type {HTMLInputElement} */ (event.target);
        results = reComputeResults(target.value);
        resultIndex = 0;
        renderResults();
      },
      { capture: true }
    );

    // Close on click outside
    document.addEventListener(
      'mousedown',
      (event) => {
        if (!isVisible) return;
        const target = /** @type {Node} */ (event.target);
        if (shadowHost?.contains(target) === false) {
          event.preventDefault();
          event.stopPropagation();
          toggle();
        }
      },
      { capture: true }
    );

    return shadowHost;
  }

  /**
   * @param {string} inputValue
   * @returns {Result[] | undefined}
   */
  function reComputeResults(inputValue) {
    if (!rules) return undefined;

    let tree = rules;
    /** @type {Result[]} */
    const results = [];
    /** @type {RuleNode[]} */
    const path = [];

    for (let index = 0; index < inputValue.length; ++index) {
      const char = inputValue[index];
      if (tree.children !== undefined && Object.hasOwn(tree.children, char)) {
        if (tree !== rules) path.push(tree);
        tree = tree.children[char];
      } else break;
      if (index === inputValue.length - 1) {
        path.push(tree);
        /** @type {string[]} */
        let labelParts = [];
        let url = '';
        for (const part of path) {
          if (part.path.startsWith('https://')) {
            url = '';
            labelParts = [];
          }
          url += part.path;
          labelParts.push(trimNoise(part.path));
        }
        url += tree.leaf ?? '';
        results.push({
          labelParts,
          url,
          branches: tree.children,
        });
      }
    }

    return results.length === 0 ? undefined : results;
  }

  /** @param {string} path */
  function trimNoise(path) {
    if (path.startsWith('https://')) {
      path = path.substring('https://'.length);
      if (path.startsWith('www.')) path = path.substring('www.'.length);
    }
    return path;
  }

  function renderResults() {
    if (preview === undefined) return;

    preview.textContent = '';
    if (results !== undefined)
      for (const result of results) {
        const resultContainer = document.createElement('div');
        for (let index = 0; index < result.labelParts.length; ++index) {
          const part = result.labelParts[index];
          const span = document.createElement('span');
          span.textContent = part;
          span.style.color = urlPartColors[index % urlPartColors.length];
          resultContainer.append(span);
        }
        preview.append(resultContainer);
        if (result.branches !== undefined) {
          Object.entries(result.branches).forEach(([key, node], index) => {
            const suggestionContainer = document.createElement('div');
            const keySpan = document.createElement('span');
            keySpan.textContent = key;
            keySpan.className = 'branch-key' + (index === 0 ? ' first' : '');
            const labelText = node.path || node.leaf || '';
            suggestionContainer.append(keySpan);
            suggestionContainer.append(document.createTextNode(labelText));
            /** @type {HTMLElement} */ (preview).append(suggestionContainer);
          });
        }
      }
  }

  loadRules()
    .then((loadedRules) => {
      rules = loadedRules;
      toggle();
    })
    .catch((error) => {
      console.error('Web Commander: failed to load rules.', error);
    });
})();
