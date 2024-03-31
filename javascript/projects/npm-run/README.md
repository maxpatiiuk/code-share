# NPM Run

An essential utility for running any npm script or executable with fewer
keystrokes.

## Examples

```sh
# Will find the first npm script that starts with a given prefix and run it
x t
▶︎ npm run test

# Can enter more characters if ambiguous
x wa:bu
︎▶︎ npm run watch:build

# Supports . - and : separators
x g:t.w
▶︎ npm run global:test.watch

# Passes all arguments to the script
x wa:bu --serve
▶︎ npm run watch:build -- --serve

# Will try to resolve to some script from any of the parent package.json files
# If fails to match against any script, will try to resolve the executable
x ts -b
▶︎ npx tsc -b

# If "packageManager" in package.json is set to yarn or pnpm,
# will use it instead of npm
x s
▶︎ yarn run start
```

## Installation

Make sure Node.js 18+ is installed.

Clone this repository:

```sh
git clone --depth 1 https://github.com/maxpatiiuk/code-share
```

Add this to your `.bashrc` or `.zshrc`:

```sh
x() {
  command=$(node ~/path/to/code-share/javascript/projects/npm-run "$@")
  echo "> $command"
  eval $command
}
```

(remember to replace `~/path/to/code-share/` in the above snippet with the path
to the cloned `code-share` repository)
