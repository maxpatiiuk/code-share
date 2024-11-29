pub fn main() {
    {
        println!("\nString semantics");
        let mut empty_string = String::new();
        empty_string.push_str("some data ");

        let heap_string_from_const_string = String::from("static string");

        empty_string.push_str(heap_string_from_const_string.as_str());

        println!("{empty_string}");
    }

    {
        println!("\nMove");
        let s1 = String::from("1");
        let s2 = s1;
        // s1 is no longer usable as heap ownership moved to s2
        println!("{s2}");
    }

    {
        println!("\nClone");
        let s1 = String::from("1");
        let s2 = s1.clone();
        println!("{s1} {s2}");
    }

    {
        println!("\nTransfer ownership");
        let s1 = String::from("1");
        let s2 = transfer_ownership(s1);
        // s1 no longer usable in this scope. s2 is
        println!("{s2}");

        let i = 1;
        make_copy(i);
        // i is still usable as it was copied

        fn transfer_ownership(_s: String) -> String {
            // give ownership of 2
            let s2 = String::from("2");
            s2
        }

        fn make_copy(_i: i32) {}
    }

    {
        println!("\nReference");
        let s1 = String::from("test");
        let len = len(&s1);
        println!("{s1} {len}");

        fn len(s: &String) -> usize {
            // Make a copy:
            // s.clone()
            s.len()
        }

        // Can have multiple immutable references at a time, but only one mutable
        let mut s2 = String::from("test");
        append(&mut s2, "1");

        fn append(s: &mut String, suffix: &str) {
            s.push_str(suffix);
        }
        println!("{s2}");
    }

    {
        println!("\nSlice");
        // String - heap string
        // str - slice type/pointer to const string/pointer to heap string
        let string = "black pink";
        let word = first_word(string);

        fn first_word(s: &str) -> &str {
            let bytes = s.as_bytes();
            for (i, &character) in bytes.iter().enumerate() {
                if character == b' ' {
                    // return reference to .slice(0, i) of the string
                    return &s[..i]; // return &s[0..i];

                    // s[0..s.len()] // s[..]
                    // s[3..]
                }
            }

            return &s;
        }

        println!("{word}");
        println!("{}", string.split_whitespace().next().unwrap_or(string));
    }
}
