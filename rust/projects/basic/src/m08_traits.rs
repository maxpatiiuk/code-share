pub fn main() {
    {
        println!("Generic function");

        fn first<T: std::cmp::PartialOrd>(list: &[T]) -> &T {
            &list[0]
        }

        let vector = vec![1, 2];
        let first = first(&vector);
        println!("{first}");
    }

    {
        println!("\nGeneric struct");

        struct Point<T> {
            x: T,
            y: T,
        }

        impl<T> Point<T> {
            fn x(&self) -> &T {
                &self.x
            }
        }

        // Method available only for Point<f32>
        impl Point<f32> {
            fn distance_from_origin(&self) -> f32 {
                (self.x.powi(2) + self.y.powi(2)).sqrt()
            }
        }

        let point = Point { x: 1.0, y: 2.0 };
        println!("{} {} {}", point.x(), point.y, point.distance_from_origin());
        // Equivalent:
        println!("{}", Point::distance_from_origin(&point));
    }

    {
        println!("\nGeneric enum");
        enum Option<T> {
            Some(T),
            None,
        }

        let _some = Option::Some(1);
        let _none: Option<i32> = Option::None;
    }

    {
        println!("\nTrait");

        struct Pair<T> {
            left: T,
            right: T,
        }

        trait Sum<T: std::ops::Add<Output = T>> {
            fn sum(&self) -> T;

            // Default implementation
            fn zero(&self) -> i32 {
                0
            }
        }

        impl<T: std::ops::Add<Output = T> + Copy> Sum<T> for Pair<T> {
            fn sum(&self) -> T {
                self.left + self.right
            }
        }

        fn call_sum<T: std::ops::Add<Output = T> + Copy>(pair: &impl Sum<T>) -> T {
            pair.sum()
        }

        // `impl` de-sugars to:
        fn call_sum_2<T: Sum<T2>, T2: std::ops::Add<Output = T2> + Copy>(pair: &T) -> T2 {
            pair.sum()
        }

        // Alternative syntax if have lots of generics
        fn call_sum_3<T, T2>(pair: &T) -> T2
        where
            T: Sum<T2>,
            T2: std::ops::Add<Output = T2> + Copy,
        {
            pair.sum()
        }

        let pair = Pair { left: 1, right: 2 };
        println!(
            "{} {} {} {}",
            call_sum(&pair),
            call_sum_2(&pair),
            call_sum_3(&pair),
            pair.zero()
        );
    }

    {
        println!("\nBlanket implementations");

        trait ToStringIf {
            fn to_string_if(&self, condition: bool) -> String;
        }

        // Implement this method on every type that implements Display
        impl<T: std::fmt::Display> ToStringIf for T {
            fn to_string_if(&self, condition: bool) -> String {
                if condition {
                    self.to_string()
                } else {
                    String::from("Condition not met")
                }
            }
        }

        let number = 1;
        println!("{}", number.to_string_if(true));
    }

    {
        println!("\nLifetimes");

        // Tell rust's borrow checker that the lifetime of the return values is
        // the same as the lifetime of the input values (the shorter of the two)
        fn longest<'a>(x: &'a str, y: &'a str) -> &'a str {
            if x.len() > y.len() {
                x
            } else {
                y
            }
        }

        let a = String::from("a");
        let b = String::from("b");

        let result = longest(&a, &b);
        println!("{result}");

        // Error on potential usage of a reference after its scope:
        // let result2;
        // {
        // let b = String::from("b");
        // result2 = longest(&a, &b);
        // }
        // println!("{result2}");
    }

    {
        println!("\nLifetime in struct");
        struct StringContainer<'a> {
            s: &'a str,
        }

        let string = String::from("string");

        // The lifetime of `string_container` cannot outlie the lifetime of `string`
        let string_container = StringContainer { s: &string };

        print!("{}", string_container.s);

        // Lifetimes are inferred automatically based on 3 rules:
        // - assign a lifetime to each input parameter
        // - if there is one input, assign that lifetime to each output
        // - if we are in a prototype method, use the self lifetime
    }
}
