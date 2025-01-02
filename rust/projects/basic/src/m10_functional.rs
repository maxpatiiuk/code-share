pub fn main() {
    {
        println!("Closures can infer type based on usage");
        // If type annotations not provided, they are inferred from first usage.
        // Closure like `Fn(i32,i32)->i32` doesn't mutate variables and doesn't
        // transfer ownership - can be called multiple times.
        let add = |a, b| a + b;
        println!("add(1, 2) = {}", add(1, 2));
    }

    {
        println!("\nClosures can take mutable captures of scope variables");
        let mut number = 0;
        // Automatically detects whether reference should be mutable
        // Mutable closures have type `FnMut`
        let mut increment = || number += 1;
        increment();
        println!("number = {}", number);
    }

    {
        println!("\nCan move variables into closures");
        let str = String::from("test");
        // With `move`, closure takes ownership of captured variables.
        // Useful when created threads.
        // `move` closure can only be called once. It has a "FnOnce" type
        let print_own = move || println!("{}", str);
        print_own();
        // FnOnce is the bottom-closure type, strictest - use that in argument
        // types to provide flexibility and document that closure is called
        // only once
        // edit: even better is fn() -> T type - function point, not a closure
    }

    {
        println!("\nIterators");

        let mut v1 = vec![1, 1];

        let v1_iter = v1.iter();
        for item in v1_iter {
            print!("{} ", item);
        }

        // for/in syntax makes iterator mutable behind the scenes. Need to make
        // it mutable explicitly if calling directly:
        let mut v1_iter = v1.iter();

        assert_eq!(v1_iter.next(), Some(&1));
        assert_eq!(v1_iter.next(), Some(&1));
        assert_eq!(v1_iter.next(), None);

        // Mutable iterator
        for item in v1.iter_mut() {
            *item += 1;
        }

        // Transfers ownership of vector to iterator
        for item in v1.into_iter() {
            print!("{} ", item);
        }
    }
}
