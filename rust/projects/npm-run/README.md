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
```

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
