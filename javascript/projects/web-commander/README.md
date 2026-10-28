# Web Commander

An uber extension for bookmarks, styling the web, tab management, and quick note
taking.

[A blog post about it](https://max.patii.uk/articles/google-chrome-is-my-window-manager/).

## Installation

1. Clone this repository
2. Create `src/ui/rules.js` to define fast navigation rules for your common
   destinations (see [Navigator](#navigator)).
3. [Load unpacked](https://developer.chrome.com/docs/extensions/get-started/tutorial/hello-world)
   extension in Chrome from this directory.

## Navigator

Navigate to a precise URL with just a few keystrokes using rules you define:

For example, typing `gecia` navigates to "**G**ithub.com / **E**sri /
**C**alcite-design-system / **I**ssues / **A**uthored by me".

![](./docs/github-commander.avif)

And `mmnc` goes to "np**m**js.com / @arcgis/**m**ap-components / **n**ext
version / code".

![](./docs/npm-commander.avif)

### Usage

- **Command+D** (Mac) or **Alt+K** (Windows/Linux) - Toggle command palette
- Type keys to navigate the rule tree
- **?** - List defined rules
- **Enter** - Open in new tab
- **Shift+Enter** - Navigate in current tab
- **Cmd/Ctrl+Enter** - Open in new background tab
- **Escape** - Close palette

### Configuration

Create `src/ui/rules.js` (not checked into git):

```js
/**
 * @import { RuleNode } from './types';
 */

// Example: GitHub navigation with reusable repo structure
/** @type {RuleNode['children']} */
const repoChildren = {
  i: { path: '/issues' },
  p: { path: '/pulls' },
  a: { path: '/actions' },
  w: { path: '/wiki' },
};

/** @type {RuleNode} */
export const rules = {
  path: '',
  children: {
    g: {
      path: 'https://github.com/',
      children: {
        t: {
          path: 'microsoft/TypeScript',
          label: 'TypeScript',
          children: repoChildren,
        },
        v: { path: 'vitejs/vite', children: repoChildren },
        r: { path: 'facebook/react', children: repoChildren },
        n: { path: 'nodejs/node', children: repoChildren },
        d: { path: 'denoland/deno', children: repoChildren },
      },
    },
    // Add more domains...
  },
};
```

Type `gt` → opens github.com/microsoft/TypeScript  
Type `gti` → opens github.com/microsoft/TypeScript/issues  
Type `gvp` → opens github.com/vitejs/vite/pulls

Build deeper trees for complex navigation patterns.

## Web refinements

The extension injects custom styles and JavaScript to refine behavior of sites I
use frequently. Examples:

- Add [right-click "do anything" menu](./src/scripts/all/auto-scroll.js)

  ![](./docs/auto-scroll-menu.avif)

- Fix Readability.js or Chrome Auto Dark Mode compatibility issues.
- Disable conversation auto-scroll in
  [Claude](./src/scripts/claude.ai/no-auto-scroll.js) and
  [Gemini](./src/scripts/gemini.google.com/no-auto-scroll.js).
- Reduce noise. For example, simplify Outlook calendar menu

  ![](./docs/simplify-outlook.avif)

This serves as a minimalistic clone of tampermonkey. Notable features:

- All scripts are stored on the file system, in a Git-versioned folder - very
  easy to sync between machines
- No UI - scripts are edited in an IDE (benefit from TypeScript, Prettier,
  ESLint, Vim shortcuts)
- No sandboxing overhead - only run the scripts I trust
- Low overhead. Event-driven background worker

## Tab shortcuts

Web Commander provides additional keyboard shortcuts for fast navigation and
management of browser tabs:

- **Option+Z/X/C/V/B/N/M/,/.** selects VS Code tab 1 through 9 across windows.
  See
  [VS Code in the browser](https://github.com/maxpatiiuk/dotfiles/blob/main/vscode/README.md)
- **Option+I** cycles backward through recently viewed tabs.
- **Option+Shift+I** cycles forward through the same sequence.
- **Ctrl+Option+Command+I** consolidates ordinary tabs and whole tab groups on
  the first display. Ungrouped VS Code tabs are balanced across remaining
  screens.
- **Ctrl+Option+N/M** moves the current tab left; **Ctrl+Option+,/.** moves it
  right. Ungrouped tabs jump over adjacent tab groups. Grouped tabs stay within
  their group, and pinned tabs stay within the pinned section.
- In addition, hold **Command** to move the current tab between windows: **N**
  left, **M** down, **,** up, **.** right. If there is no window in that
  direction, an available display gets a new fullscreen window. Fallbacks are
  down/right and up/left in both directions.

Set `displayOrder` in [src/ui/tab-management.js](src/ui/tab-management.js) to an
ordered array of monitors. Monitor IDs are not stable so matching is based on
screen sizes. Run `await chrome.system.display.getInfo()` in the extension
service worker console to get the work area sizes.

## New Tab

Functional yet minimalistic New Tab page:

- Shows time remaining till I am 100 years old
- On double-click opens text editor for quick notes

### Special features

Double click anywhere on the page to bring up a simpler text editor for super
quick notes

Then open Chrome DevTools to use for quick snippets:

- change the value of the editor by typing `v = 'some value'` in the Chrome
  DevTools' console. read `v` to get the current value.
- `j = {"a": 1}` - pretty-print a JSON or parse JSON
- `jm` - minified JSON
- `vl` - content, split by new lines
- `vlu` - also unique
- `vls` - also sorted
- `vlsu` and `vlus` - also sorted and unique
