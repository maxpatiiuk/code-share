use std::fmt;

// static COUNTER: u32 = 0;
// fn add_to_count(inc: u32) {
// unsafe {
// COUNTER += inc;
// }
// }

pub fn main() {
    {
        println!("Unsafe");
        // Unsafe superpowers:
        // - Dereference raw pointer
        //   (can have multiple owners, even if writable, may be null, no cleanup)
        // - Call unsafe function/trait method
        // - Call function from another language
        //   https://doc.rust-lang.org/book/ch19-01-unsafe-rust.html#using-extern-functions-to-call-external-code
        // - Access/modify mutable static variable
        // - Implement unsafe trait
        // - Access fields of unions

        let mut num = 5;

        // Raw pointers can be created outside unsafe, but must be dereferenced inside unsafe
        let r1 = &num as *const i32;
        let r2 = &mut num as *mut i32;

        unsafe {
            println!("r1 is: {}", *r1);
            println!("r2 is: {}", *r2);
        }

        unsafe fn dangerous() {}

        unsafe {
            dangerous();
        }

        // add_to_count(3);
        // unsafe {
        // println!("COUNTER: {COUNTER}");
        // }
    }

    {
        println!("\nAssociated type");
        // Like Generics, but:
        // - must be present in implementations
        // - can't have multiple implementations for the same method

        trait _Iterator {
            // Can set default value for type too
            type Item;

            fn next(&mut self) -> Option<Self::Item>;
        }
    }

    {
        println!("\nTrait depending on trait");

        trait OutlinePrint: fmt::Display {
            fn outline_print(&self) -> String {
                return self.to_string();
            }
        }

        struct Point {
            x: i32,
        }

        impl OutlinePrint for Point {}

        impl fmt::Display for Point {
            fn fmt(&self, f: &mut fmt::Formatter) -> fmt::Result {
                write!(f, "({})", self.x)
            }
        }

        let p = Point { x: 1 };
        p.outline_print();
    }

    {
        println!("\nType alias");

        // Use case: shorter equivalents for long types
        type Kilometers = i32;
        let y: Kilometers = 5;
        let x: i32 = y;
        println!("x: {}, y: {}", x, y);
    }

    {
        println!("\n! // Never type");
        // Very much like TypeScript

        let parsed: i32 = loop {
            match String::from("4").parse::<i32>() {
                Ok(num) => break num,
                // Never returns here, so type is !
                Err(_) => continue,
                // panic! is also ! type
            }
        };
        println!("{}", parsed);
    }

    {
        println!("\nFunction pointer");

        fn id<T>(x: T) -> T {
            x
        }

        // fn is a type. Fn is a trait
        fn double_apply(map: fn(i32) -> i32, value: i32) -> i32 {
            map(value) + map(value)
        }

        let answer = double_apply(id, 5);
        println!("{answer}");
    }

    {
        println!("\nMetaprogramming -> Macros");
        // Can take any number of arguments of any type
        // Can create traits or structs dynamically

        // Macros can be defined declaratively using macro_rules!
        // Or imperatively (manipulating AST) using procedural macros:
        // https://doc.rust-lang.org/book/ch19-06-macros.html#procedural-macros-for-generating-code-from-attributes
    }
}

#[macro_export]
macro_rules! vec {
    // Match an expression followed by a comma any number of times
    // and assign that code to $x variable
    ( $( $x:expr ),* ) => {
        // If matches, turn that into the following code:
        {
            let mut temp_vec = Vec::new();
            $(
                temp_vec.push($x);
            )*
            temp_vec
        }
    };
}
