// @ts-check

/** @type {HTMLTextAreaElement} */
// @ts-expect-error
const textarea = document.getElementById('urlInput');
/** @type {HTMLButtonElement} */
// @ts-expect-error
const button = document.getElementById('openTabs');
/** @type {HTMLDivElement} */
// @ts-expect-error
const lineCount = document.getElementById('lineCount');

/** @param {string} value */
function updateTextArea(value) {
  // TODO: make deduplication smarter around utm query params
  const urls = Array.from(new Set(value.split('\n').filter(Boolean))).sort(
    (rawLeft, rawRight) => {
      const left = rawLeft.replace('www.', '');
      const right = rawRight.replace('www.', '');
      return left < right ? -1 : left > right ? 1 : 0;
    },
  );
  lineCount.innerText = String(urls.length);
  const urlString = urls.join('\n');
  textarea.value = urlString;
  chrome.storage.local.set({ urls: urlString });
}

chrome.storage.local.get('urls', (data) => {
  updateTextArea(data.urls || '');
});

/** @type {number} */
let timeout = -1;
textarea.addEventListener('input', () => {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    updateTextArea(textarea.value);
  }, 2000);
});

button.addEventListener('click', () => {
  let urls = textarea.value.split('\n');

  if (urls.length === 0) {
    return;
  }

  const toOpen = urls.slice(0, 10).reverse();
  toOpen.forEach((url) => {
    if (url.startsWith('http://') || url.startsWith('https://')) {
      window.open(url, '_blank');
    } else {
      window.open('https://' + url, '_blank');
    }
  });

  updateTextArea(urls.slice(10).join('\n'));
});

lineCount.addEventListener('click', () => {
  const textUrls = textarea.value.split('\n');
  /** @type {Record<string, number>} */
  const domains = {};
  /** @type {Record<string, number>} */
  const utmSources = {};
  textUrls.forEach((urlText) => {
    const url = new URL(urlText);
    let hostname = url.hostname;
    if (hostname.startsWith('www.')) {
      hostname = hostname.slice('www.'.length);
    }
    domains[hostname] ??= 0;
    domains[hostname] += 1;
    let utmSource = url.searchParams.get('utm_source') ?? 'undefined';
    if (utmSource.endsWith('/')) utmSource = utmSource.slice(0, -'/'.length);
    utmSources[utmSource] ??= 0;
    utmSources[utmSource] += 1;
  });
  console.table(domains);
  console.table(utmSources);
  alert('See output in dev console');
});
