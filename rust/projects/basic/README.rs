// Resources:
// - https://doc.rust-lang.org/book/

// TODO:
// - implement common data structures in Rust
// - https://marketplace.visualstudio.com/items?itemName=swellaby.vscode-rust-test-adapter
// - https://marketplace.visualstudio.com/items?itemName=tamasfe.even-better-toml
// - configure rust-analyzer
// - clippy linter:https://doc.rust-lang.org/book/appendix-04-useful-development-tools.html#more-lints-with-clippy
// - a way to scan the program for all the places that could panic?

// Setup
// brew install rustup && rustup default stable

// Project setup
// cargo new <name> // create new project boilerplate
// rustc file.rs // manually compile a file
// cargo build // build a cargo project
// cargo run // build & run a cargo project
// cargo check // check without running
// cargo build --release // production build
// cargo update // check project dependencies for update
// cargo fix // fix autofixable warnings

// Impressions
// - Way more restrictive than JavaScript and you have to think about more things.
// - Compiler detects many bugs, which is great, but many of those can be
//   detected by strict TypeScript and strict ESLint
//   - the only exclusive part is borrow checker for memory management, which is
//     nice - not yet sure if it would prevent memory leaks though
// - Pattern matching and powerful enums are awesome. Monads are great too.
//   - This makes it much more suited for functional programming than
//     JavaScript. The fact that there are no nulls or exceptions is nice.
// - Couldn't get rust-analyzer to work in a monorepo. Had to hardcode paths to
//   projects into it.
