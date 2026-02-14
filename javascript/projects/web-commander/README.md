# Web Commander

Keyboard-driven navigation for Chrome. Quickly jump to frequently visited URLs using a command palette interface.

## Installation

1. Clone this repository
2. Create `rules.js` with your navigation rules (see Configuration below)
3. Load unpacked extension in Chrome from this directory

## Usage

- **Command+D** (Mac) or **Alt+K** (Windows/Linux) - Toggle command palette
- Type keys to navigate the rule tree
- **Enter** - Open in new tab
- **Shift+Enter** - Navigate in current tab
- **Cmd/Ctrl+Enter** - Open in new background tab
- **Escape** - Close palette

## Configuration

Create `rules.js` in the project root (not checked into git):

```javascript
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
        t: { path: 'microsoft/TypeScript', children: repoChildren },
        v: { path: 'vitejs/vite', children: repoChildren },
        r: { path: 'facebook/react', children: repoChildren },
        n: { path: 'nodejs/node', children: repoChildren },
        d: { path: 'denoland/deno', children: repoChildren },
      }
    },
    // Add more domains...
  }
};
```

Type `gt` → opens github.com/microsoft/TypeScript
Type `gti` → opens github.com/microsoft/TypeScript/issues
Type `vp` → opens github.com/vitejs/vite/pulls

Build deeper trees for complex navigation patterns.
