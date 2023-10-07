# Chrome DevTools

Based on https://developer.chrome.com/docs/devtools/

- `Cmd+Shift+I` toggle
- `Cmd+Option+C` select element/open "Elements" tab
- `Cmd+Option+J` open console
- `Cmd+[/]` go to next/prev panel
- `Cmd+Shift+R` hard reload

## Elements panel

- `Option+click on expand arrow` recursive toggle
- `Enter` star editing attribute
- `H` toggle element visibility
- `F2` edit as HTML
- Can see DOM element properties in "Properties" panel (useful for Web
  Components)

## Styles pane

- `Cmd+click` go to definition
- [Layers panel](https://www.youtube.com/watch?v=6je49J67TQk) for debugging css
  animations

## Sources

- `Option+W` close tab
- `Cmd+Fn+up/down` next/previous tab
- Can do local overrides of files and headers
- Can sync changes with local
- Can edit the function inline and save ephemerally
- Can see
  [list of made changes](https://developer.chrome.com/docs/devtools/changes/)
- "Page" pane can be set to show Deployed or Authored files

### Debugging

- `Cmd+\` pause/resume execution
- By holding "Resume" button, can force resume (skips breakpoints)
- `Cmd+'` step over next function
- `Cmd+;` step into next function
- `Cmd+Shift+;` step out of current function
- `Cmd+line number click` go to that line
- `Ctrl+./,` go up/down the stack
- Can set watch expressions (right sidebar pane)
- Can set DOM and fetch breakpoints
- `Cmd+B` toggle breakpoint
- `Cmd+Option+B` breakpoint edit menu
- Right click on call stack entry to restart frame - though that does not rewind
  the results

## Console ⭐

- `Option+click on expand arrow` recursive object expand
- `$0 - $4` nth most recently selected node
- `$_` value of last expression
- `$()` == `document.querySelector`
- `$$()` == `document.querySelectorAll`
- `copy(object)` copy serialized formatted object to clipboard ⭐
- `(un)debug(function)` set breakpoint on first line of the function
- `inspect(node)` focus node in "Elements" panel
- `getEventListeners(node)` list event listeners on node
- `(un)monitor(function)` log function calls and arguments
- `(un)monitorEvents(window, "resize" OR ["resize", "click"]);` log event
  occurrences
  - questionable utility over `addEventListener` besides shorter syntax
- `console.assert`
- `console.count`
- `console.group`
- `console.time`
- `console.trace`

## Network

- Search has a lot of advanced filtering and AND conditions
- Can change what waterfall column is sorting by (i.e total duration)
- Shift+hover of request to see it's initiators and dependencies

## Improvements

Tools for detecting issues and improving code:

- Lighthouse
- Code coverage
- CSS Profiler
- Issues tab

### Performance

- Performance insights panel provides a more streamlined performance analysis
  and suggestions
- There is a "Performance Monitor" tool
- Can enable FPS meter in "Rendering" panel

### Testing

- [End-to-end test builder](https://developer.chrome.com/docs/devtools/recorder/)
- [Forwarding localhost ports to mobile device](https://developer.chrome.com/docs/devtools/remote-debugging/local-server/)

### Misc

- chrome://media-engagement/ - collects how many times you played video/audio on
  which page
- chrome://network-errors/ - for inspiration on how to write user-friendly error
  messages for software/network issues
- chrome://site-engagement/ - see your most visited webpages