# File/Directory finder

Searches for a file/directory with a given name in each parent
directory until the root directory.

The first argument should be the name of the file/directory to search
for. If the name ends with `/`, then the search looks for folders with
that name. Otherwise, it check for files with that name.

If search is successful, it prints the full path of the folder in which
the item was found and exits with code 0. Otherwise, it exits with code
1.

## Example usage

Find a `docker-compose.yml` file:

```bash
python3 ./path/to/dirfinder.py docker-compose.yml
```

Find an `.idea/` directory:

```bash
python3 ./path/to/dirfinder.py .idea/
```

