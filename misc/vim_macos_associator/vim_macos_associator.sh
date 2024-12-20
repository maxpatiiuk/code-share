# Configuration
TEMP_FILE="/tmp/list_view"
EDITOR="vim"  # cli editor to use


# Script
echo "#!/bin/sh
${EDITOR} \"$@\";  # open requested file in a chosen editor
# If using Terminal, uncomment this: close the tab once editor exited
# osascript -e 'tell application \"Terminal\" to close first window' & exit;
" > ${TEMP_FILE};
chmod +x ${TEMP_FILE};  # make TEMP_FILE executable
open -a iTerm ${TEMP_FILE};  # run TEMP_FILE in a new terminal window

