use std::cell::RefCell;
use std::ops::Deref;
use std::rc::{Rc, Weak};

pub fn main() {
    {
        println!("Box<T> - store data on the heap rather than stack");
        // Use Box<T> when:
        // - type whose size is not known at compile time (recursive type)
        // - large amount of data that needs to have ownership transferred without
        //   copying
        // - declare a type that implements a trait rather than is a specific struct
        //   (Trait Objects)
        //
        // Allows immutable or mutable borrows

        let b = Box::new(42);
        println!("b = {}", b);
        assert_eq!(42, *b);
    }

    {
        println!("\nUsing box in a recursive type");

        enum List {
            Cons(i32, Box<List>),
            Nil,
        }

        let list = List::Cons(1, Box::new(List::Cons(2, Box::new(List::Nil))));

        fn print_list(list: &List) {
            match list {
                List::Cons(head, sub_list) => {
                    print!("{} ", head);
                    print_list(sub_list);
                }
                List::Nil => (),
            }
        }

        print_list(&list);
    }

    {
        println!("\n\nDeref trait - * support");

        struct MyBox<T>(T);

        impl<T> MyBox<T> {
            fn new(x: T) -> MyBox<T> {
                MyBox(x)
            }
        }

        impl<T> Deref for MyBox<T> {
            type Target = T;

            fn deref(&self) -> &Self::Target {
                &self.0
            }
        }

        let b = MyBox::new(42);
        println!("b = {} (behind the scenes: {})", *b, *(b.deref()));
        assert_eq!(42, *b);

        fn print_string(string: &str) {
            println!("{}", string);
        }

        let string = MyBox::new(String::from("IVE"));
        // Because String implements Deref that returns &str, when you pass
        // &String where &str is needed, Rust does "Deref Coercion" to convert
        // it to &str.
        // (but not before converting MyBox<String> to &String)
        print_string(&string);
        // Equivalent:
        print_string(&(*string.deref())[..]);

        // DerefMut trait - support mutable dereferences

        // Deref coercion happens in these cases:
        // - &t -> &U if T: Deref<Target=U>
        // - &mut t -> &mut U if T: DerefMut<Target=U>
        // - &mut t -> &U if T: Deref<Target=U>
    }

    {
        println!("\nDrop trait - cleanup on lifecycle end");

        struct CustomSmartPointer {
            data: String,
        }

        impl Drop for CustomSmartPointer {
            fn drop(&mut self) {
                println!("Dropping data: {}", self.data);
            }
        }

        let _a = CustomSmartPointer {
            data: String::from("a"),
        };
        let b = CustomSmartPointer {
            data: String::from("b"),
        };
        let _c = CustomSmartPointer {
            data: String::from("c"),
        };

        // Explicit drop early
        drop(b);

        // Dropped rest is reversed order
    }

    {
        println!("\nRc<T> - reference counting (allows for multiple owners)");
        // Allows immutable references only

        enum List {
            Cons(i32, Rc<List>),
            Nil,
        }
        use List::{Cons, Nil};

        let a = Rc::new(Cons(2, Rc::new(Cons(1, Rc::new(Nil)))));
        match a.as_ref() {
            Cons(head, _rc) => println!("{}", head),
            _ => (),
        }

        print!("{} ", Rc::strong_count(&a));
        let _b = Cons(30, Rc::clone(&a));
        print!("{} ", Rc::strong_count(&a));
        {
            let _c = Cons(31, Rc::clone(&a));
            print!("{} ", Rc::strong_count(&a));
        }
        print!("{}\n", Rc::strong_count(&a));
    }

    {
        println!("\nRefCell<T> - interior mutability");
        // Runtime-checked multiple (im)mutable references

        // Interior mutability = mutating value inside immutable value

        pub trait Messenger {
            fn send(&self, usage: f64);
        }

        pub struct LimitTracker<'a, T: Messenger> {
            messenger: &'a T,
            value: usize,
        }

        impl<'a, T> LimitTracker<'a, T>
        where
            T: Messenger,
        {
            pub fn set_value(&mut self, value: usize) {
                self.value = value;

                let percentage_of_max = self.value as f64 / 100.0;

                self.messenger.send(percentage_of_max);
            }
        }

        struct MockMessenger(RefCell<Vec<f64>>);

        impl Messenger for MockMessenger {
            fn send(&self, message: f64) {
                self.0.borrow_mut().push(message);
            }
        }

        let mock_messenger = MockMessenger(RefCell::new(vec![]));
        let mut limit_tracker = LimitTracker {
            messenger: &mock_messenger,
            value: 0,
        };

        limit_tracker.set_value(80);

        println!("messages: {} (1)", mock_messenger.0.borrow().len());

        // Runtime error during concurrent mutable references:
        // let _a = mock_messenger.0.borrow_mut();
        // let _b = mock_messenger.0.borrow_mut();
    }

    {
        println!("\nRefCell in Rc (multiple references with mutability)");

        #[derive(Debug)]
        enum List {
            Cons(Rc<RefCell<i32>>, Rc<List>),
            Nil,
        }
        use List::{Cons, Nil};

        let value = Rc::new(RefCell::new(5));

        let a = Rc::new(Cons(Rc::clone(&value), Rc::new(Nil)));

        // Silence unused checker
        match a.as_ref() {
            Cons(_head, _rc) => (),
            _ => (),
        }

        let b = Cons(Rc::new(RefCell::new(3)), Rc::clone(&a));
        let c = Cons(Rc::new(RefCell::new(4)), Rc::clone(&a));

        *value.borrow_mut() += 10;

        println!("a after = {a:?}");
        println!("b after = {b:?}");
        println!("c after = {c:?}");

        let a_weak_pointer = Rc::downgrade(&a);
        let maybe_a = a_weak_pointer.upgrade();
        match maybe_a {
            Some(_a) => println!("a still exists"),
            None => println!("a has been dropped"),
        }
    }

    {
        println!("\nTree with Rc and RefCell");

        #[derive(Debug)]
        struct Node {
            value: i32,
            parent: RefCell<Weak<Node>>,
            children: RefCell<Vec<Rc<Node>>>,
        }

        let leaf = Rc::new(Node {
            value: 3,
            parent: RefCell::new(Weak::new()),
            children: RefCell::new(vec![]),
        });

        println!("leaf parent = {:?}", leaf.parent.borrow().upgrade());
        println!(
            "leaf strong = {}, weak = {}",
            Rc::strong_count(&leaf),
            Rc::weak_count(&leaf),
        );

        {
            let branch = Rc::new(Node {
                value: 5,
                parent: RefCell::new(Weak::new()),
                children: RefCell::new(vec![Rc::clone(&leaf)]),
            });

            *leaf.parent.borrow_mut() = Rc::downgrade(&branch);

            println!("leaf parent = {:?}", leaf.parent.borrow().upgrade());
            println!("branch value = {}", branch.value);
            println!("branch children = {:?}", branch.children);

            println!(
                "branch strong = {}, weak = {}",
                Rc::strong_count(&branch),
                Rc::weak_count(&branch),
            );

            println!(
                "leaf strong = {}, weak = {}",
                Rc::strong_count(&leaf),
                Rc::weak_count(&leaf),
            );
        }

        println!("leaf parent = {:?}", leaf.parent.borrow().upgrade());
        println!(
            "leaf strong = {}, weak = {}",
            Rc::strong_count(&leaf),
            Rc::weak_count(&leaf),
        );
    }
}
