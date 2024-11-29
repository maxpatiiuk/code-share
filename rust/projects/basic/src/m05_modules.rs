// Create ~= package
// Binary create = app = src/main.rs, src/bin/*
// Library create = library = src/lib.rs
// Crate root = entrypoint

// `mod` needs to be used once per module to expose it to the compiler.
// Usually place them in the entrypoint file.
// mod name; // will look in src/name.rs and src/name/mod.rs (legacy)

mod test {
    pub mod sub_test {
        pub fn sub_test() {
            println!("sub_test");
            super::super::outer();
        }

        // All enum variants are automatically public
        pub enum Color {
            Black,
        }

        // Have to explicitly make struct fields public
        pub struct User {
            pub username: String,
            // pub color: super::super::Color,
            pub color: Color,
        }
    }
}

// Make a shorter alias for "Color"
use test::sub_test::Color;
// For functions, it's idiomatic to "use" the parent module
// For enums and structures, "use" the members directly (except when collide)

use test::sub_test::Color as UserColor;
// pub use test::sub_test::Color as UserColor;

// use std::cmp::Ordering;
// use std::io;
// use std::{cmp::Ordering, io};

// use std::io:Write;
// use std::io;
// use std::io::{self, Write};

// use std::io::*;

fn outer() {
    println!("outer");
}

// Use "pub" to expose code outside the module
pub fn main() {
    // Absolute path:
    crate::m05_modules::test::sub_test::sub_test();
    // Relative path:
    test::sub_test::sub_test();

    let color = test::sub_test::User {
        username: String::from("Pink"),
        color: Color::Black,
    };
    print!(
        "{} {}",
        match color.color {
            UserColor::Black => "Black",
        },
        color.username,
    );
}
