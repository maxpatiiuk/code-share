'use strict';

(() => {
  // Bypass link validator for common & safe domains
  const SAFE_DOMAINS = [
    'esri.com',
    'arcgis.com',
    'github.com',
    'google.com',
    'youtube.com',
    'office.com',
    'microsoft.com',
  ];

  /**
   * Outlook Safe-Links are rewritten to
   * https://*.safelinks.protection.outlook.com/?url=<encoded>&data=...
   * This extracts the original URL if present.
   *
   * @param {string} href
   */
  const extractOriginalUrl = (href) => {
    try {
      const { hostname, searchParams } = new URL(href);
      if (!/\.safelinks\.protection\.outlook\.com$/.test(hostname)) return href;

      // In practice the param can be url= or target=, handle both.
      const encoded = searchParams.get('url') || searchParams.get('target');
      return encoded ? decodeURIComponent(encoded) : href;
    } catch {
      return href;
    }
  };

  /** @param {string} host */
  const isSafeDomain = (host) =>
    SAFE_DOMAINS.some((d) => host === d || host.endsWith('.' + d));

  /**
   * Main handler for click & aux-click (middle-button).
   *
   * @param {MouseEvent} e
   */
  const intercept = (e) => {
    if (e.defaultPrevented) return;

    // Find the nearest anchor in the composed path.
    const anchor =
      e.target.closest?.('a[href]') ||
      e.composedPath?.().find?.((n) => n?.href);

    if (!anchor) return;

    const finalUrl = extractOriginalUrl(anchor.href);

    let host = '';
    try {
      host = new URL(finalUrl).hostname;
    } catch {
      return;
    }

    if (!isSafeDomain(host)) return;

    e.stopImmediatePropagation();
  };

  // Capture phase so we run before Outlook’s listeners.
  addEventListener('click', intercept, true);
  addEventListener('auxclick', intercept, true);
})();
