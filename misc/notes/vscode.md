## Todo

- [x] Go over https://code.visualstudio.com/docs
- [x] Configure layout
- [x] Go over all toolbar (mac os menu items) and remember useful shortcuts
- [x] Learn the debugger
- [x] https://www.cordulack.com/writing/moving-to-vs-code-from-intelliJ
- [x] Go over default snippets and disable useless ones
- [x] Go over all IDE settings
  - [ ] Did I break git diff gutters? -> update the css file
  - [x] Go over welcome page, or reenable workbench.startupEditor
  - [ ] https://github.com/microsoft/vscode/issues/90130
  - [ ] Hide activity bar once I learn it or at least reduce it
    - And likely create a shortcut for toggling it
  - [x] Hide status bar once I learn it or at least reduce it
  - [ ] Consider doing setting sync in git (maybe "Settings sync" extension)?
    - or do regular takeouts (Profiles: Show Contents)
      - that includes too much data, and may contain sensitive data
      - if publicizing, only publish settings.json, keystrokes.json, and
          extension list
      - Could use this snippet to help inspect the profile contents:
        ```js
        function inflateValue(obj) {
          let value = obj;
          try {
            while (typeof value === "string") {
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
            : typeof obj === "object"
            ? Object.fromEntries(
                Object.entries(obj).map(([key, value]) => [key, inflate(value)]),
              )
            : obj;
        }
        inflate($("textarea").value);
        ```
    - or "Settings Sync: Show Synced Data" is enough?
- [ ] Setup test workflow
  - [ ] Try out testing.showAllMessages?
  - [ ] Go over Karma settings, and come up with a workflow
  - [ ] Try out the Test Explorer and it's settings
  - [ ] Check if "Jest (Extension)" component in Status Bar is needed
  - [ ] Setup VS Code tasks (i.e, Jest)
    - https://code.visualstudio.com/docs/editor/tasks
    - https://code.visualstudio.com/docs/nodejs/nodejs-debugging#_launch-configuration-attributes
    - create a problem matcher if not automatic
- [x] TabNine vs GitHub Copilot vs GitHub Copilot Chat vs IntelliSence vs
      IntelliCode
  - https://www.youtube.com/watch?v=Fi3AJZZregI
  - https://code.visualstudio.com/docs/editor/artificial-intelligence
- [ ] Keyboard Shortcuts
  - [x] https://code.visualstudio.com/shortcuts/keyboard-shortcuts-macos.pdf?WT.mc_id=code-online-jopapa
  - [x] https://code.visualstudio.com/docs/getstarted/keybindings#_basic-editing
  - [x] toggle git blame (and maybe change width)
  - [ ] Consider keyboard shortcut for "Open in integrated terminal" "when":
        "filesExplorerFocus"
  - [ ] assign keyboard shortcut for "workbench.action.createTerminalEditor" or
        is there Cmd to move current terminal to up?
        (terminal.integrated.defaultLocation) or "Maximize panel size"
        (workbench.action.toggleMaximizedPanel)
  - [ ] Go over TODOs in keymap list below
  - [ ] Learn keyboard shortcuts
  - [ ] Convert all commonly used shortcuts to vim if possible
  - This is useful - https://marketplace.visualstudio.com/items?itemName=jasonlhy.hungry-delete
    - But cmd+backspace seems to work natively now
    - Also, check if vim provides a neat solution for this
    - Any way to make "Hungry delete" be the default behaviour?
- [x] Go over all plugins and their settings and theme settings
- [x] Create a keyboard shortcut for going to nth tab
  - Decided not to implement this - hid tabs instead
- [ ] https://code.visualstudio.com/docs/nodejs/debugging-recipes
- [ ] Create profile for Demos based on the main profile (and google/chatgpt
      nice settings for that - i.e autosave, font size) (or just zen mode?)
- Esri
  - [x] Turn sdk and api into single workspace?
    - Nope. My VS Code is terribly slow as is. Explorer takes 4 seconds to open.
      Even scrolling the file freezes the IDE sometimes. All because there are
      too many files already. And, the use case for searching/editing both of
      these at the same time (that can't be done in separate windows) is very
      narrow.
  - Disable all SCSS support once Esri moved off to CSS
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

## Plugins

Installed extensions are absent from this list

### Uninstall?

- [ ] Shell Syntax
  - see if can be replaced by an ESLint plugin
- [ ] Node.JS REPL
  - try out "nodemon"
- [ ] -- Go over git plugins and see if I need them (I am still a big fun of
      using Git in the CLI, especially due to customization options and many
      aliases I have)

## Find extension for

- [x] Refactoring (mainly, "Move to existing file")
  - https://github.com/microsoft/TypeScript/issues/29988 is fixed, yet I can'tb
    see it
    - "Abracadabra, refactor this!" has this feature but it almost never works
    - Update: now available in the August 2023 release
- [x] There are a bunch of "git plugins - figure out (also .gitignore)
  - [x] gitignore
    - syntax highlighting available natively
    - I rarely find .gitignore templates useful
- [ ] code coverage
- [ ] docker plugins
- [ ] jsdoc
- [ ] json
- [ ] scopes extension OR vscode profiles:
  - https://code.visualstudio.com/docs/editor/profiles
  - https://marketplace.visualstudio.com/items?itemName=cfcluan.project-scopes

## Don't forget to use

TODO: Review all installed plugins as a reminder. Also:

- [ ] Node.js REPL
  - Though, this might be better replaced by Chrome DevTools' snippets.
    - Cons of DevTools' snippets:
      - No Vim keyboard shortcuts
      - No easy file system access
    - Pros of DevTools' snippets:
      - Always there, easily accessible, and can save snippets for later
      - Access to the DOM
- [ ] Search node_modules

### Maybe later

- [ ] Stencil Tools
  - Maybe once I will start working with Stencil more
- [ ] Shell
  - Is it redundant with the terminal?
  - Is it redundant with the vim extension? (which can execute CLI commands
    too?)
- [ ] Dev Containers
- [ ] Emmet
  - Little use for this. Don't write .html at all. Write little .css (especially
    with Tailwind CSS). Write a lot of .tsx, but there props are often needed,
    you rarely think 2-3 components ahead, and you never create a lot of similar
    components at once (in favor of dry code: loops)
  - [ ] https://docs.emmet.io/cheat-sheet/
- [ ] Docker
  - Not working with docker much nowadays, despite it being a useful technology

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
- [ ] Jest Test Explorer
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