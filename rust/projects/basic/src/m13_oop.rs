pub fn main() {
    // Rust has objects (structs, enums, impl)
    // Rust has encapsulation (private/public fields)
    // Rust has no inheritance (use traits, generics, or trait objects instead)

    {
        println!("Trait objects");

        trait Display {
            fn display(&self);
        }

        struct Program {
            // If we used a generic, then all members would have to be of the
            // same type.
            // If we used a struct, then list of possibilities needs to be known
            // at compile time.
            // With trait objects we allow anything that implements the trait.
            components: Vec<Box<dyn Display>>,
        }

        impl Display for Program {
            fn display(&self) {
                for component in &self.components {
                    component.display();
                }
            }
        }

        struct Unit {
            pub value: i32,
        }
        impl Display for Unit {
            fn display(&self) {
                println!("Item: {}", self.value);
            }
        }

        struct Flag {
            pub value: bool,
        }
        impl Display for Flag {
            fn display(&self) {
                println!("Flag: {}", self.value);
            }
        }

        let program = Program {
            components: vec![Box::new(Unit { value: 42 }), Box::new(Flag { value: true })],
        };

        program.display();
    }

    {
        println!("\nTransfer Box ownership");
        // Use for:
        // - destructors
        // - transforming boxed types

        // Use &self when ownership transfer is not needed
        // use self when value is not boxed

        struct Node {
            value: i32,
        }

        impl Node {
            // Ownership of the boxed value is consumed here
            fn destroy(self: Box<Self>) {
                println!("Destroying node with value: {}", self.value);
            }
        }

        let node = Box::new(Node { value: 42 });
        node.destroy();
    }

    // State pattern example:
    // - Post holds PosState trait object
    // - Post methods forward call to the trait object
    // - Trait object implements different logic depending on state
    // - Pros: all logic for "Published" state is in one place
    //
    // Enum equivalent:
    // - Post holds a state enum
    // - Post methods match on the state enum
    // - Pros: less boilerplate, faster performance
    //
    // Separate types:
    // - Have Post, DraftPost, PublishedPost types
    // - Each type only implements the methods it needs
    // - Strict type safety for state transitions
}
