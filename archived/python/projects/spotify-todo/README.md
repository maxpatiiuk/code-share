# Spotify TODO
A simple program to manage a TODO list without leaving the terminal
I used it to save a list of Spotify artists I wanted to check out, but
it would work with any kind of list.

## Installation
Install dependencies:
```bash
pip install -r requirements.txt
```

## Configuration
Configuration options are described in the file. You have a choice
of the shell and editor to use as well as the location of the file that
would store the data structure.

## Running the program
For convinience, it is recommended to alias this program to some
short command. For example:
```bash
alias spotify="python3 ~/path/to/spotify_todo.py"
```

Then you can add a task to the list like this:
```bash
spotify add CategoryName Task Name
```

This whould automatically create a category `CategoryName`, if it
doesn't yet exist and add a `Task Name` under that category. Notice
that you are permitted to use whitespace in the name of the task.

If the task already exists in any category, you would be prompted.

When you want to view your categories and tasks or you want to remove
some tasks, you can run the program like this (without arguments):
```bash
spotify
```
to open the storage file in your editor of choice.

## Data storage file's structure
The data is stored in a valid markdown, with categy names starting with
a single `#` and individual taks under it beggining with `*`. You can
manually edit the file, as long as proper syntax is maintained.

Example valid file:
```md
# OST
* Oliver Deriviere
* Daniel Licht
* 2WEI

# Otacore
* Mili
* Ken Ashcorp
* Creep
```

