pub fn main() {
    add(1, 2);
}

pub fn add(left: u64, right: u64) -> u64 {
    left + right
}

// Only compile this code if "test" condition is present
#[cfg(test)]
mod tests {
    use super::*;

    // `cargo test it_works` to run only this test
    #[test]
    fn it_works() {
        let result = add(2, 2);
        assert_eq!(result, 4);
        assert!(result == 4, "Expected 4, got {}", result);
        assert_ne!(result, 5);

        let res: Result<i32, i32> = Err(1);
        assert!(res.is_err());
    }

    #[test]
    #[should_panic(expected = "Done")]
    fn panics() {
        panic!("Done");
    }

    #[test]
    #[ignore]
    fn it_works2() -> Result<(), String> {
        let result = add(2, 2);

        if result == 4 {
            Ok(())
        } else {
            Err(String::from("two plus two does not equal four"))
        }
    }
}
