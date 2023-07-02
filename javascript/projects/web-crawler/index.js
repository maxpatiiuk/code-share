const form = document.getElementById('form');
form.addEventListener('submit', (event) => {
  event.preventDefault();
  iterations = 0;
  const url = document.getElementById('url').value;
  startCrawl(url).then(console.log).catch(console.error);
});

const maxIterations = 100;
let iterations = 0;

async function startCrawl(url) {
  for await (const response of crawl(url)) postMessage(response);
}

const visits = {};

async function* crawl(url) {
  const response = await fetch(url, {
    referrer: 'no-referrer',
    referrerPolicy: 'no-referrer',
  }).catch((error) => ({
    type: 'error',
    url,
    error: `Error fetching: ${error.message}`,
    raw: error,
  }));
  if (response.type === 'error') {
    yield {
      type: 'error',
      url,
      error: `Error fetching: ${response.error}`,
      raw: response,
    };
    return;
  }
  const contentType = response.headers.get('content-type');
  if (!contentType.includes('html')) {
    yield {
      type: 'error',
      url,
      error: 'Not an HTML page',
    };
    return;
  }
  const text = await response.text();
  const xml = parseXml(text);
  if (typeof xml === 'string') {
    yield {
      type: 'error',
      url,
      error: `Failed parsing HTML: ${xml}`,
    };
    return;
  }
  const links = prioritizeLinks(
    shuffleArray(Array.from(xml.getElementsByTagName('a')))
      .map((link) => link.getAttribute('href'))
      .map(normalize.bind(undefined, url))
  );
  if (links.length === 0) {
    yield {
      type: 'error',
      url,
      error: 'No links found',
    };
    return;
  }

  yield {
    type: 'success',
    url,
    response: text,
  };

  for (const [domain, link, _visitCount] of links) {
    visits[domain] = (visits[domain] ?? 0) + 1;
    for await (const response of crawl(link)) {
      if (maxIterations < iterations) {
        yield {
          type: 'error',
          url,
          error: `Reached max iterations: ${maxIterations}`,
        };
        return;
      }
      iterations += 1;
      yield response;
    }
  }
  yield {
    type: 'error',
    url,
    error: 'Run out of links',
  };
}

function parseXml(string) {
  const parsedXml = new globalThis.DOMParser().parseFromString(
    string,
    'text/html'
  ).documentElement;

  // Chrome, Safari
  const parseError = parsedXml.getElementsByTagName('parsererror')[0];
  if (typeof parseError === 'object')
    return (parseError.children[1].textContent ?? parseError.innerHTML).trim();
  // Firefox
  else if (parsedXml.tagName === 'parsererror')
    return (
      parsedXml.childNodes[0].nodeValue ??
      parsedXml.textContent ??
      parsedXml.innerHTML
    ).trim();
  else return parsedXml;
}

function normalize(base, url) {
  try {
    return new URL(url, base);
  } catch {
    return undefined;
  }
}

const prioritizeLinks = (links) =>
  links
    .map((link) => [link.hostname.toLowerCase(), link.toString()])
    .map(([hostname, url]) => [hostname, url, visits[hostname] ?? 0])
    .sort(sortFunction(([_hostname, _url, score]) => score));

export const sortFunction =
  (mapper, reverse = false) =>
  (left, right) => {
    const [leftValue, rightValue] = reverse
      ? [mapper(right), mapper(left)]
      : [mapper(left), mapper(right)];
    if (leftValue === rightValue) return 0;
    return typeof leftValue === 'string' && typeof rightValue === 'string'
      ? leftValue.localeCompare(rightValue)
      : (leftValue ?? 0) > (rightValue ?? 0)
      ? 1
      : -1;
  };

const messageBox = document.getElementById('message-box');

function postMessage(message) {
  messageBox.insertAdjacentHTML(
    'beforeend',
    `<tr>
  <td>${iterations}</td>
  <td>${message.type}</td>
  <td><a class="link" href="${message.url}" target="_blank">${
      message.url
    }</a></td>
  <td>${
    message.type === 'error'
      ? message.error
      : '<div class="message-container"></div>'
  }</td>
  </tr>`
  );
  if (message.type === 'error') console.error(message);
  else {
    const iframe = document.createElement('iframe');
    iframe.srcdoc = message.response;

    const messageContainer =
      messageBox.lastElementChild.getElementsByClassName(
        'message-container'
      )[0];
    messageContainer.appendChild(iframe);
  }
}

/** Copied from https://stackoverflow.com/a/2450976/8584605 */
function shuffleArray(array) {
  let currentIndex = array.length,
    randomIndex;

  // While there remain elements to shuffle.
  while (currentIndex !== 0) {
    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex],
      array[currentIndex],
    ];
  }

  return array;
}
