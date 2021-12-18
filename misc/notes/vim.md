# TODO

- figure out tabs and nerdtree/sidebar methodology
- code folding
- https://vim.fandom.com/wiki/Using_tab_pages
- replace NERDTree with vim's default file explorer
- :help user-manual

# Sort this:
ci)  (change inside parents)
vim cheat sheat
look into other's vimrc files

# Main

- .  # repeat last change command
- ;  # repeat last find command
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

# Movement

- n|  # go to nth char in line
- g$  # go to last SCREEN column. Same for ^, 0, etc...
- ^  # go to the first non blank character of a line
- H/M/L  # cursor to the nth line from top/middle/bottom of the screen
- gM  # cursor to the middle of the line
- 90gM  # move to 10% till the end of the line
- 10%  # go to the 10% of the file
- (/)  # move between sentences
- {/}  # move between paragraphs
- [/]  # move between code blocks
- va"/'/`/`/{/[/>  # select text between symbols of type
- vi"/"/...  # .. excluding the symbols - di/a... # ...
- vis/vas  # select inner/a sentance
- Ctrl-u/d  # half page up / down
- Ctrl-f/b  # page up / down
- Ctrl-e/y  # scroll one line up / down
- zz  # scroll viewport to have cursor at the middle

# Visual

- <c-v>  # visual block
- o/O  # toggle the horizontal/vertial direction of selection

# Search & Replace

- ?query  # backwards search
- *  # search for current word
- tC  # like f, but cursor before next occurrence of C
- TC  # like F, but cursor after previous occurrence of C
- ;  # repeat last t, f, T, F
- ,  # repeat last t, f, T, F in the opposite direction
- \*/#  # find next/prev occurrence of this word
- /word  # search for word
- n/N  # show next/previous occurrence
- dgn  # delete next occurrence
- daw  # delete current word
- %  # go to matching ([{
- :%s/old/new/gc  #search&replace with a prompt
- (in query) \< and \>  # regex's \b


# Tabs

- :tabfind file  # open file in new tab
- ngt  # go to the nth tab
- :tabs  # list all tabs

# Windows

- vertical help  # open help in a vertical split
- vsp file  # open file in a vertical split
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

- mk  # make marker k
- ' moves to that line, while \` also moves to that col
- `k` y'k  # copy from marker `k` till current position
- :marks  # list all marks
- 'k or `k  # go to mark k`
- '' or ``  # jump to mark ``

# Jumping
- Ctrl-o/i - go to prev/next cursor jump position
- g;/, - go to prev/next change list position

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
yy3p
dis
cas
diw
