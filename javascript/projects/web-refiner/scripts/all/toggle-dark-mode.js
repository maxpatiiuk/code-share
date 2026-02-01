/** Toggle Chrome's automatic dark mode */

'use strict';
(() => {
  document.addEventListener(
    'keydown',
    ({ key, metaKey, ctrlKey, altKey, shiftKey }) => {
      if (key === '1' && (metaKey || ctrlKey) && shiftKey && !altKey)
        document.documentElement.style.colorScheme =
          document.documentElement.style.colorScheme === 'white only'
            ? ''
            : 'white only';
    }
  );
})();
