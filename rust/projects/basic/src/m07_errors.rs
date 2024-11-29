use std::fs::{self, File};
use std::io::{self, Read};

const FILE_NAME: &str = "Cargo.toml";

pub fn main() {
    // Run with RUST_BACKTRACE=1 to see error stack
    // panic!("This is an error message");

    {
        let greeting_file_result = File::open(FILE_NAME);

        let greeting_file = match greeting_file_result {
            Ok(file) => file,
            Err(error) => match error.kind() {
                io::ErrorKind::NotFound => match File::create(FILE_NAME) {
                    Ok(fc) => fc,
                    Err(e) => panic!("Problem creating the file: {e:?}"),
                },
                other_error => {
                    panic!("Problem opening the file: {other_error:?}");
                }
            },
        };

        println!("{}", greeting_file.metadata().unwrap().len());
    }

    {
        let mut greeting_file = File::open(FILE_NAME).unwrap_or_else(|error| {
            if error.kind() == io::ErrorKind::NotFound {
                File::create(FILE_NAME).unwrap_or_else(|error| {
                    panic!("Problem creating the file: {error:?}");
                })
            } else {
                panic!("Problem opening the file: {error:?}");
            }
        });

        let mut content = String::new();
        greeting_file.read_to_string(&mut content).unwrap();
        println!("{}", content);
    }

    {
        // Prefer .expect() over .unwrap() as it adds context to error messages
        File::open(FILE_NAME).unwrap();
        let greeting_file = File::open(FILE_NAME).expect("Failed to open file");

        println!("{}", greeting_file.metadata().unwrap().len());
    }

    {
        fn read_cargo_toml() -> Result<String, io::Error> {
            // ? propagates the exceptions up the call stack
            // ? can be used in Result-returning and Option-returning functions
            // Use .ok and .ok_or to convert Result<-->Option
            let mut username_file = File::open(FILE_NAME)?;
            let mut username = String::new();
            username_file.read_to_string(&mut username)?;
            Ok(username)
        }

        println!("{}", read_cargo_toml().expect("Failed file reading"));
    }

    {
        println!("{}", fs::read_to_string(FILE_NAME).unwrap());
    }

    {
        fn last_char_of_first_line(text: &str) -> Option<char> {
            text.lines().next()?.chars().last()
        }
        println!("{}", last_char_of_first_line("Black\nPink").unwrap());
    }

    // main() return type could be Result<(), Box<dyn Error>> to allow for ?
    // operator (Box<dyn Error> ~= "any error")

    // Use process:exit(1); to exit the program
}
