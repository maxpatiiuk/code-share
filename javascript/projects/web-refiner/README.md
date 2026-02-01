Refine commonly used webpages:

- Add [right-click "do anything" menu](./scripts/all/auto-scroll.js)
- Improve UX
- Fix Readability.js or Chrome Auto Dark Mode compatibility issues

This serves as a minimalistic clone of tampermonkey. Notable features:

- All scripts are stored on the file system, in a Git-versioned folder - very
  easy to sync between machines
- No UI - scripts are edited in an IDE (benefit from TypeScript, Prettier,
  ESLint, Vim shortcuts)
- No sandboxing overhead - only run the scripts I trust
- Low overhead. No background worker
