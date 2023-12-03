# Code Share

Before [code_share](https://github.com/maxpatiiuk/code_share/) repository got
created, in fact, even before I knew GitHub existed, I had a need to small
snippets of code in some place for easy retrieval in the future or for sharing
with my friends.

This website was created to solve that problem.

It follows my bad practice of creating large single-file applications 😇.
Fun fact: here is
[the biggest single file program I ever wrote](/archived/c++/projects/s-life-simulator).

## Configuration

1. Install PHP 7.4
2. Edit the configuration constants at the top of the
   [`index.php`](./index.php) file:
   - MySQL credentials
   - `LINK` constant - a URL at which the website will be publicly available
   - `FILES` - a path relative to `LINK` at which uploaded files will be hosted.