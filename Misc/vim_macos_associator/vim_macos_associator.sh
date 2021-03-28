# Configuration
TEMP_FILE="/tmp/tmp.sh"  # temp file would be created during execution
                         # of this script. It would be deleted afterwards
EDITOR="mvim -v"  # the editor to call. In my case, I call mac vim in
                  # non-gui mode


# Script
echo "#\!/bin/sh
${EDITOR} \"$@\";  # open requested file in a chosen editor
# close Terminal tab once editor exited
osascript -e 'tell application \"Terminal\" to close first window' & exit;
" > ${TEMP_FILE};
chmod +x ${TEMP_FILE};  # make TEMP_FILE executable
open -a Terminal ${TEMP_FILE};  # run TEMP_FILE in a new terminal window
sleep 1;  # since the 'open' command is asynchronous,
          # we need to wait a tiny bit before deleting the temp file
rm ${TEMP_FILE};  # delete TEMP_FILE
