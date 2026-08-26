# NPM Run (Rust Version)

> [!WARNING]
>
> This is a Rust port of
> https://github.com/maxpatiiuk/code-share/tree/main/javascript/projects/npm-run.
>
> This code was written by Gemini Agent to test how well it works for porting
> between languages.

An essential utility for running any npm script or executable with fewer
keystrokes.

This is a **Rust port** of the original JavaScript tool. It is compiled to
native machine code, making it significantly faster (starting in <2ms vs
~100ms), eliminating the latency usually felt when running CLI commands.

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

# Can invoke a .js file from the current directory or a parent directory
x cli --help
▶︎ node cli.js --help

# Filter Turbo tasks to a workspace package using an abbreviated package name
x -f m-c tu b
▶︎ turbo build --filter=@arcgis/map-components

# Run a binary in a workspace package
x --filter m-c vite --host
▶︎ pnpm --filter=@arcgis/map-components exec vite --host

# Run a package script using abbreviated package and script names
x -f m-c s-i
▶︎ pnpm --filter=@arcgis/map-components run start-internal-storybook
```

`-f`, `-F`, and `--filter` are equivalent when placed immediately after `x`.
`--filter=<package>` is also supported. Package abbreviations use the same
separator-aware matching as commands, so `m-c` can match
`@arcgis/map-components`. Scopes can also be abbreviated, so `@a/m-c` matches
the same package. Ambiguous matches resolve deterministically by exact full
name, exact unscoped name, match specificity, shortest unscoped name, and
finally lexical full name.

Filtered Turbo commands run from the workspace root and receive Turbo's
`--filter` option. Turbo task names are abbreviated using the same matching
rules, so `b` resolves to `build`. Other filtered binaries run through the
detected package manager (`pnpm`, Yarn, or npm) in the selected workspace
package. Filtered package scripts use the same abbreviated matching and take
precedence over binaries.

Targets are resolved in this order:

1. Scripts from the nearest `package.json` and `.js` files from the current
   directory upward, ranked by match specificity
2. Scripts from additional ancestor `package.json` files
3. Executables from `node_modules/.bin` (nearest first)
4. An `npx` fallback

Specificity favors exact matches, fewer unmatched name segments, and shorter
names, in that order. A script wins when its specificity ties a `.js` file. For
example, `x c` prefers `cli.js` over `core:docs`, while `x c:d` resolves to
`core:docs`.

## Setup & Installation

Since this is written in Rust, you need to compile it once before you can use
it.

### 1. Install Rust

If you don't have Rust installed, the easiest way is using `rustup`. Run this in
your terminal:

```sh
curl --proto '=https' --tlsv1.2 -sSf https://sh.rustup.rs | sh
```

Follow the on-screen instructions (default installation is usually fine).
Restart your terminal after installation.

### 2. Compile the Project

Navigate to the project folder and build the optimized binary:

```sh
cd path/to/rust/projects/npm-run
cargo build --release
```

This will create a binary file at `target/release/npm-run`.

### 3. Configure Your Shell

To use the `x` command, add a function to your shell configuration file
(`.zshrc` or `.bashrc`).

Open your config file:

```sh
nano ~/.zshrc
# OR
nano ~/.bashrc
```

Add the following function to the bottom of the file. **Make sure to update
`/absolute/path/to/` with the actual path where this project resides.**

```sh
x() {
  # Note: pointing directly to the compiled binary
  local cmd_output
  cmd_output=$("/absolute/path/to/rust/projects/npm-run/target/release/npm-run" "$@")
  local exit_code=$?

  if [ $exit_code -eq 0 ]; then
    echo "> $cmd_output"
    eval "$cmd_output"
  else
    echo "$cmd_output" # Print error message
    return $exit_code
  fi
}
```

### 4. Apply Changes

Reload your shell config:

```sh
source ~/.zshrc
# OR
source ~/.bashrc
```

Now you can type `x` followed by a script abbreviation!
