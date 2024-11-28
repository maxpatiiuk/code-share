use rand::Rng;
use std::cmp::Ordering;

pub fn main() {
    {
        println!("Basic");
        let x = 5;
        let x_type = std::any::type_name_of_val(&x);
        print!("X {x}.");
        println!("X_type {x_type}");
    }

    {
        println!("\nMutable");
        let mut x = 5;
        print!("X {x}.");
        x = 6;
        println!("X' {x}");
    }

    {
        println!("\nConst");
        const X: u32 = 5;
        println!("X {X}");
    }

    {
        println!("\nShadowing with type change");
        let x = 5;
        print!("X {x}. ");
        let x = "'".to_owned() + x.to_string().as_str();
        println!("X {x}");
    }

    {
        println!("\nExplicit type annotation required for .parse()");
        let x: u32 = "5".parse().expect("Not a number!");
        println!("X {x}");
    }

    {
        println!("\nIntegers");
        // Integer data types:
        // i8, i16, i32, i64, i128, isize
        // u8, u16, u32, u64, u128, usize
        // isize is i64 on 64-bit systems and i32 on 32-bit systems

        // Integer syntaxes:
        let underscore = 1_0;
        let hex = 0xff;
        let octal = 0o77;
        let binary = 0b1111_0000;
        let byte = b'A';
        println!("{underscore} {hex} {octal} {binary} {byte}");
    }

    {
        println!("\nFloating point");
        let x = 2.0; // f64
        let y: f32 = 3.0;
        println!("{x} {y}");
    }

    {
        println!("\nBoolean");
        let t = true;
        let f: bool = false;
        println!("{t} {f}");
    }

    {
        println!("\nChar");
        let c = 'z';
        let z: char = 'Z';
        let mechanical_arm = '🦾';
        println!("{c} {z} {mechanical_arm}");
    }

    {
        println!("\nTuple");
        // Type annotation optional
        let tuple: (i32, f64, u8) = (500, 6.4, 1);
        let (x, y, z) = tuple;
        let x_ = tuple.0;
        println!("{x} {y} {z} {x_}");
    }

    {
        println!("\nArray");
        // Fixed size. Can't grow. Use Vectors if dynamic size needed
        let a: [i32; 5] = [1, 2, 3, 4, 5];
        let first = a[0];
        let second = a[1];
        println!("{first} {second}");

        let b = [3; 5]; // [3, 3, 3, 3, 3]
        println!("{}", b[0]);
    }

    {
        println!("\nFunction");
        let y = dual_argument_function(5, 6);
        println!("{y}");

        // fn dual_argument_function(x: i32, y: i32) {
        fn dual_argument_function(x: i32, y: i32) -> i32 {
            let updated_y = {
                const FACTOR: i32 = 2;
                y * FACTOR
            };
            // Implicit return
            x + updated_y
        }
    }

    {
        println!("\nConditional");
        let a = if true {
            2
        } else if 1 != 1 || 1 == 0 {
            4
        } else {
            8
        };
        println!("{a}");
    }

    {
        println!("\nLoop");
        let mut counter = 0;
        let result = loop {
            counter += 1;
            if counter == 10 {
                break counter * 2;
            }
        };
        println!("{result}");

        'label: loop {
            break 'label;
        }

        {
            let mut number = 3;
            // while loop doesn't support value return
            while number != 0 {
                print!("{number} ");
                number -= 1;
            }
        }

        // for loop doesn't support value return
        for element in [1, 2] {
            print!("{element} ");
        }

        for element in (1..2).rev() {
            print!("{element} ");
        }
    }

    if true {
        println!("\nCLI Input: ");
        let mut input = String::new();
        // std::io;
        // io::stdin()
        std::io::stdin()
            .read_line(&mut input)
            .expect("Failed to read line");

        let input: u32 = match input.trim().parse() {
            Ok(input) => input,
            Err(_) => {
                println!("Invalid input. Exiting");
                return;
            }
        };

        // rand::gen_range(1..101);
        let random_number = rand::thread_rng().gen_range(1..=100);
        println!("User input: {}. Random number: {}", input, random_number);

        match input.cmp(&random_number) {
            Ordering::Less => println!("Too small"),
            Ordering::Greater => println!("Too big"),
            Ordering::Equal => {
                println!("Match");
                return;
            }
        }
    }
}
