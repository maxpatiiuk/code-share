'use strict';
(() => {
  const autoDismissTitlePrefix = 'Session:';

  /**
   * Looked up on first need; only cached once found, so a link added after
   * document-start is still picked up
   * @type {string | undefined}
   */
  let cachedIconUrl;

  /** @returns {string | undefined} */
  const findIconUrl = () => {
    const link = document.querySelector('link[rel~="apple-touch-icon"]');
    return link instanceof HTMLLinkElement ? link.href : undefined;
  };

  /** @returns {string | undefined} */
  const getIconUrl = () => (cachedIconUrl ??= findIconUrl());

  /**
   * @param {unknown} title
   * @returns {boolean}
   */
  const shouldAutoDismiss = (title) =>
    typeof title === 'string' && title.startsWith(autoDismissTitlePrefix);

  /**
   * Returns the same array reference when nothing changes
   * @param {readonly unknown[]} args [title, options?, ...rest]
   * @returns {readonly unknown[]}
   */
  const patchArgs = (args) => {
    const options = /** @type {NotificationOptions | undefined} */ (args[1]);
    const iconUrl = options?.icon ? undefined : getIconUrl();

    /** @type {NotificationOptions} */
    const overrides = {
      ...(shouldAutoDismiss(args[0]) ? { requireInteraction: false } : {}),
      ...(iconUrl === undefined ? {} : { icon: iconUrl }),
    };

    return Object.keys(overrides).length === 0
      ? args
      : [args[0], { ...options, ...overrides }, ...args.slice(2)];
  };

  // new Notification(title, options)
  const OriginalNotification = window.Notification;
  if (OriginalNotification !== undefined)
    window.Notification = new Proxy(OriginalNotification, {
      construct: (target, args, newTarget) =>
        Reflect.construct(target, patchArgs(args), newTarget),
    });

  // registration.showNotification(title, options) — page-side calls only
  const registrationProto = window.ServiceWorkerRegistration?.prototype;
  if (registrationProto?.showNotification !== undefined)
    registrationProto.showNotification = new Proxy(
      registrationProto.showNotification,
      {
        apply: (target, thisArg, args) =>
          Reflect.apply(target, thisArg, patchArgs(args)),
      }
    );
})();
