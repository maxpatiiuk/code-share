# vim-macos-associator

Make non-gui Vim open associated text files in Terminal on double click
in finder

## Instructions
 1. Open Automator.app
 2. Choose 'New Document'
 3. Choose 'Application'
 4. On the left bar chose 'Utilities' and `Run Shell Script` next to it
 5. Change 'pass input' option to 'as arguments'
 6. Paste this script into the textbox
 7. Edit the configuration options below these instructions if needed
 8. Save the script and place it into any directory
 8. Select any file in finder you want to associate with Vim
 9. [Optional] Change the icon of the generated .app file like described
    here: https://9to5mac.com/2019/01/17/change-mac-icons/
 10. Press Cmd+I (or press 'Get Info' in the context menu)
 11. In the 'Open With' section select the 'Other' option from the list
 12. Select the script created in step 8
 13. Press 'Add'
 14. Press 'Change All' button below the list to make all files wit
     this extention be associated with your editor
 15. Confirm you action if promted
Enjoy!


# Configuration
Configuration options are described in the `vim_macos_associator.md` 
file

