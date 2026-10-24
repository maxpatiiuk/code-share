'use strict';

// Closest January 1st to my birth date to have the timer reset on New Year
const initialPoint = new Date('2003-01-01');
const minimumLifetime = 100;
const fractionDigits = 6;

const numberFormatter = new Intl.NumberFormat(undefined, {
  style: 'percent',
  minimumFractionDigits: fractionDigits,
});

const content = document.getElementById('new-tab-content');
const main = document.querySelector('main');
const verticalFilled = main.querySelector('.vertical-filled');
const horizontalFilled = main.querySelector('.horizontal-filled');
const counter = main.querySelector('h1');
main.style.setProperty('--minimum-lifetime', String(minimumLifetime));

/*
 * The progress number will visibly change every
 * 365*86400/10^fractionDigits seconds (31 seconds in case of 6 fraction
 * digits). We keep it simple and re-compute every 10 seconds.
 */
updateProgress();
const progressInterval = setInterval(updateProgress, 1000 * 1);

function updateProgress() {
  const [percentageYearsPassed, percentageYearProgress] = computeProgress();
  const numericProgress = percentageYearsPassed + percentageYearProgress / 100;

  verticalFilled.style.height = `${percentageYearsPassed * 100}%`;
  horizontalFilled.style.width = `${percentageYearProgress * 100}%`;
  counter.textContent = numberFormatter.format(numericProgress);
}

function computeProgress() {
  const now = new Date();

  const thisYearStart = new Date(now.getUTCFullYear(), 0);
  const yearsPassed = now.getUTCFullYear() - initialPoint.getUTCFullYear();
  const percentageYearsPassed = yearsPassed / minimumLifetime;
  const nextYearStart = new Date(now.getUTCFullYear() + 1, 0);
  const oneYear = nextYearStart.getTime() - thisYearStart.getTime();
  const fullYear = now.getTime() - thisYearStart.getTime();
  const percentageYearProgress = fullYear / oneYear;

  return [percentageYearsPassed, percentageYearProgress];
}

Object.defineProperty(window, 'j', {
  get: () => JSON.parse(getTextarea().value),
  set: (value) => {
    getTextarea().value = JSON.stringify(value, null, 2);
  },
});
Object.defineProperty(window, 'jm', {
  get: () => JSON.parse(getTextarea().value),
  set: (value) => {
    getTextarea().value = JSON.stringify(value);
  },
});
Object.defineProperty(window, 'v', {
  get: () => getTextarea().value,
  set: (value) => {
    getTextarea().value = value;
  },
});
Object.defineProperty(window, 'vl', {
  get: getLines,
  set: setLines,
});
Object.defineProperty(window, 'vlu', {
  get: () => [...new Set(getLines())],
  set: (value) => {
    setLines(new Set(value));
  },
});
Object.defineProperty(window, 'vls', {
  get: () => getLines().sort(),
  set: (value) => {
    setLines(Array.from(value).sort());
  },
});
Object.defineProperty(window, 'vlsu', {
  get: () => [...new Set(getLines().sort())],
  set: (value) => {
    setLines(new Set(Array.from(value).sort()));
  },
});
Object.defineProperty(window, 'vlus', {
  get: () => [...new Set(getLines())].sort(),
  set: (value) => {
    setLines(Array.from(new Set(value)).sort());
  },
});

function getLines() {
  return getTextarea().value.split('\n');
}

/** @param {Iterable<unknown>} value */
function setLines(value) {
  getTextarea().value = Array.from(value).join('\n');
}

function getTextarea() {
  if (textarea) return textarea;
  textarea = document.createElement('textarea');
  textarea.className = 'default-content';
  textarea.autofocus = true;
  content.replaceChildren(textarea);
  textarea.focus();
  document.body.removeEventListener('dblclick', getTextarea);
  clearInterval(progressInterval);
  return textarea;
}
let textarea = undefined;

document.body.addEventListener('dblclick', getTextarea);

const observer = new MutationObserver((mutations) => {
  const mutation = mutations.find(
    ({ target }) =>
      target !== verticalFilled &&
      target !== horizontalFilled &&
      target !== counter
  );
  if (!mutation) return;
  const node = mutation.addedNodes?.[0];
  if (node?.textContent.trim() === '' && node.outerHTML === undefined) return;

  observer.disconnect();
  document.body.classList.remove('default-content');
  document.title = 'Scratch Page';

  const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
      <circle cx="50" cy="50" r="50" fill="#faf"></circle>
    </svg>`;
  const blob = new Blob([svg], { type: 'image/svg+xml' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('link');
  link.type = 'image/svg+xml';
  link.rel = 'shortcut icon';
  link.href = url;
  document.head.appendChild(link);
});

observer.observe(content, {
  childList: true,
  subtree: true,
  attributes: true,
});
