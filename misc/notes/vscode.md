## Todo

- [ ] Setup test workflow
  - [ ] Try out testing.showAllMessages?
  - [ ] Try out the Test Explorer and it's settings
- [ ] Keyboard Shortcuts
  - [ ] Consider keyboard shortcut for "Open in integrated terminal" "when":
        "filesExplorerFocus"
  - [ ] assign keyboard shortcut for "workbench.action.createTerminalEditor" or
        is there Cmd to move current terminal to up?
        (terminal.integrated.defaultLocation) or "Maximize panel size"
        (workbench.action.toggleMaximizedPanel)
  - [ ] Go over TODOs in keymap list below
  - [ ] Learn keyboard shortcuts
  - This is useful -
    https://marketplace.visualstudio.com/items?itemName=jasonlhy.hungry-delete
    - But cmd+backspace seems to work natively now
    - Also, check if vim provides a neat solution for this
    - Any way to make "Hungry delete" be the default behaviour?
- [ ] https://code.visualstudio.com/docs/nodejs/debugging-recipes
- [ ] Consider always having a pinned full-screen terminal at Cmd+1
- [ ] https://github.com/viatsko/awesome-vscode

### Low

- [ ] https://code.visualstudio.com/docs/getstarted/tips-and-tricks#_define-keyboard-shortcuts-for-tasks
- [ ] Spend time learning VIM much better
- [ ] https://code.visualstudio.com/docs/editor/variables-reference
- [ ] https://code.visualstudio.com/docs/getstarted/tips-and-tricks#_language-specific-settings
- [ ] https://code.visualstudio.com/api
- [ ] Publish my theme
- [ ] Find or create a "Key Promoter" extension
- [ ] Learn debugger keyboard shortcuts - breakpoints (set, edit, toggle all),
      stepping...

### Tried out and rejected

- [x] Node.js Modules Intellisense
  - Not needed -> available natively
- [x] Web Components Peek
  - Works on local web components only
- [x] Web Components Snippets
  - I don't use snippets
- [x] Save Editors Layout
  - I almost never have more than one editor open
- [x] Markdown Preview Enhanced
  - Redundant with "Markdown All in One" and "GitHub Markdown Preview"
- [x] shell-format
  - Replaced by prettier-plugin-sh
- [x] Code Runner
  - Why does this exist? seems redundant with native code runner
- [x] Emmet Live
  - I am considering disabling emmet entirely
  - To cubersome and few benefits over creating smaller emmet expressions
- [x] eslint-disable-snippets
  - Nice idea, except it uses a hardcoded list of ESLint rules rather than
    dynamically loads enabled rules
- [x] ESLint Disable
  - Redundant with actions already available in the auto fix menu
- [x] Edit csv
  - Horrible UX and buggy. Using Excel Viewer instead (though it's read only,
    but I shouldn't be editing CSVs by hand anyway)
- [x] ArcGIS API for JavaScript Snippets
  - Very out of date
  - Aimed at JS API user, not JS API developer
- [x] Path Intellisense
  - Seems to work natively
- [x] NPM IntelliSense
  - Seems to work natively
- [ ] Test Explorer and Test Adapter Converter
- [ ] Learn Vim
- [ ] Live Preview
- [ ] env/dotenv/native?
- [ ] markdownlint?, unless can be done by prettier or natively?

## Keyboard Shortcuts

TODO: review the custom Vim plugin shortcuts

### IDE

- `gf` go to file
- `gv` go to symbol
- `gv` go to local symbol
- `gb` actions
- `Cmd+P Backspace %` quick search
  - // TODO: change this
- `Cmd+O` open file/folder

### Editing

- `Cmd+D` duplicate cursor to next occurrence
  - or `Cmd+Shift+L` select all occurrences
  - or `Cmd+Option+up/down` duplicate cursor line up/down
- `Option+up/down arrow` move element in file
- `Control+(shift)+-` cursor to next/prev position
  - // TODO: update this
- `Option+scroll` fast scrolling `ga` go to definition/reference
- `Shift+Control+F12` show references in sidebar
  - // TODO: change this
- `Cmd+Control+Shift+right/left arrow` smart selection expand/contract
- `Control+Shift+R` refactor
  - // TODO: change this
- `Cmd+Shift+\` jump to matching bracket
  - // TODO: is it really useful?), also Vim might have an alternative
- `Cmd+[/]` indent/outdent line
  - (`</>` is supposed to work too, but that looses selection)

### Meta Editing

- `gn/gp` open next/prev error
- `Cmd+Shift+V` show markdown preview
  - or `Cmd+K V` markdown side by side
- `Cmd+K Cmd+I` show type
  - or `Cmd+Shift+Space` show signature
- `Cmd+K P` copy path of current file
- `Cmd+K R` open current file in finder
- `(Shift)+Cmd+-` next/previous cursor position

### Windows

- `Option+backtick` toggle terminal
- `Option+backtick` open focused file in terminal
  - or `Cmd+J` toggle panel
- `Option+Shift+backtick` open another terminal
  - // TODO: change
- `Cmd+\` split editor/terminal
- `Cmd+1/2/3` focus editor
- `Cmd+B` toggle sidebar
- `Cmd+Option+B` toggle right sidebar
- `Cmd+Shift+E` move to explorer
  - // TODO: change this

### Tools

- `Cmd+Shift+E` explorer
- `Cmd+Shift+F` search
  - `(shift)+option+g` next/previous search result
- `Cmd+Shift+D` debug
- `Cmd+Shift+X` extensions
- `Cmd+Shift+E` explorer

### Git

- `Control+Shift+G` Git sidebar
  - // TODO: change
- `Option+B` toggle blame
- `Option+/` Git commands
- `Option+G` toggle commit graph
- `Option+F` show focus view

### Tabs

- `Cmd+\` open side by side
- `Control+Tab–` navigate between files

### Misc

- `code --diff file file` diff two files
- `code --help` see CLI options
- `(Shift)+Enter` next/previous search result
- `Cmd+Enter` open search results in editor

### Run and Debug - `launch.json`

- `F5` debug/start/continue
- `F6` pause
- `Shift+F5` stop
- `Control+F5` run
- `Cmd+Shift+B` run tasks
- `(Shift)+F9` (inline) breakpoint
- `(Shift)+F11` step into/out
- `F10` step over

### Tasks - `tasks.json`

`Cmd+Shift+D` debug window

### NOTE

Settings can be language-specific or project-specific

Could use this snippet to help inspect the profile contents:

```js
function inflateValue(obj) {
  let value = obj;
  try {
    while (typeof value === 'string') {
      value = JSON.parse(value);
    }
  } catch {
    return value;
  }
  return value;
}
function inflate(rawValue) {
  const obj = inflateValue(rawValue);
  return Array.isArray(obj)
    ? obj.map(inflate)
    : obj == null
    ? null
    : typeof obj === 'object'
    ? Object.fromEntries(
        Object.entries(obj).map(([key, value]) => [key, inflate(value)])
      )
    : obj;
}
inflate($('textarea').value);
```
