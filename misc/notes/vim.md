# TODO

- figure out tabs and nerdtree/sidebar methodology
- code folding
- https://vim.fandom.com/wiki/Using_tab_pages
- replace NERDTree with vim's default file explorer
- :help user-manual

# Sort this:

# Main

- :open file  #  open file in current tab
- :vs file  # open file in vertical split
- :bn  # switch to nth buffer
- x/X  # delete current/previous char
- A  # $a
- a  # li
- c  # if in visual > remove selected and enter insert mode
- ce  # de+i
- cc  # dd+i
- s  # cl
- Ctrl+G  # show status message
- Ctrl+O/I  # go to prev/next cursor position
- v:!ls / :r !ls  # prints the output of `ls` in the current line
- gv  # reselect previous selection
- :set ic/noic  # make search case insensitive/sensitive
- Ctrl+D  # show suggestions when typing `:` commands or passing
            arguments
- Ctrl+C  # return to the normal mode
- </>  # indent/unindent
- ~Uu  # toggle/upper/lower case
- <c-v>  # visual block

# Movement

- n|  # go to nth char in line
- g$  # go to last SCREEN column. Same for ^, 0, etc...
- ^  # go to the first non blank character of a line
- H/M/L  # cursor to the top/middle/bottom of the screen
- gM  # cursor to the middle of the line
- 90gM  # move to 10% till the end of the line
- 10%  # go to the 10% of the file
- (/)  # move between sentences
- {/}  # move between paragraphs
- va"/'/`/`/{/[/>  # select text between symbols of type
- vi"/"/...  # .. excluding the symbols
- di/a... # ...

# Search & Replace

- tC  # like f, but cursor before next occurrence of C
- TC  # like F, but cursor after previous occurrence of C
- ;  # repeat last t, f, T, F
- ,  # repeat last t, f, T, F in the opposite direction
- \*/#  # find next/prev occurrence of this word
- /word  # search for word
- n/N  # show next/previous occurrence
- dgn  # delete next occurrence
- %  # go to matching ([{
- :%s/old/new/gc  #search&replace with a prompt

# Tabs

- :tabfind file  # open file in new tab
- gt/T  # go to the right/left tab
- ngt  # go to the nth tab
- :tabs  # list all tabs

# Windows

- Ctrl+w v/s  # open new vim window on the left/bottom
- Ctrl+w c  # close window
- Ctrl+w l/h/j/k  # switch to the window to the right/left/below/above
- Ctrl+w Ctrl+w  # toggle between windows
- Ctrl+w </>/-/+  # decrease/increase current window
-                   horizontally/vertically
- Ctrl+w |  # maximize current window horizontally/vertically
- Ctrl+w =  # make all windows have equal size

# NERDTree

- Ctrl+n  # toggle NERDTree window
- Ctrl+s  # open current file in NERDTree

# Misc

- `sed -n l`  # show key codes

# Markers

- mk  # make marker
- `k` y'k  # copy from marker `k` till current position
- :marks  # list all marks

# Folding

- zf'k  # fold from marker
- 5:16fo  # fold lines 5-16
- zo  # unfold

# Reformatting

- =i{ # reformat current scope
- v + =  # reindent selected

# Vim's file explorer:

- :Ex or :Vexplore

# Macros

- qa  # start recording a macro `a`
- q - finish recording
- @a - replay `a` macros

# Examples

!echo "1"
2d3w  # delete 6 words
d<c-v>2j
yf?
yF?
d}
dj
dvj
