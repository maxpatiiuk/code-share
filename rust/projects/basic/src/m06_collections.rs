use std::collections::HashMap;

pub fn main() {
    {
        println!("Vector");

        enum Cell {
            Int(i32),
            Float(f64),
            Text(String),
        }

        // Array of variable length with same type. Stored on the heap.

        let mut v: Vec<i32> = Vec::new();
        let mut v2 = vec![
            Cell::Int(2),
            Cell::Float(2.0),
            Cell::Text(String::from("2")),
        ];
        v.push(1);
        v2.push(Cell::Int(2));

        let first = &v[0];
        let first_safe = v.get(0).expect("No first element");
        let first_copy = v[0];

        print!("{first} {first_safe} {first_copy} ");

        for i in &v2 {
            match i {
                Cell::Int(i) => print!("{i} "),
                Cell::Float(f) => print!("{f} "),
                Cell::Text(s) => print!("{s} "),
            }
        }

        for i in &mut v2 {
            match i {
                Cell::Int(i) => *i += 1,
                Cell::Float(f) => *f += 1.0,
                Cell::Text(s) => s.push_str("2"),
            }
        }

        for i in v2 {
            match i {
                Cell::Int(i) => print!("{i} "),
                Cell::Float(f) => print!("{f} "),
                Cell::Text(s) => print!("{s} "),
            }
        }
    }

    {
        println!("\nString");
        let mut s = String::from("V");
        let data = "X";
        s.push_str(data);
        // Convert any value to string using Display trait:
        print!("{}", data.to_string() + &s);

        // Compiler does "deref coercion" automatically:
        // &s // &String
        // &s[..] // &str

        // Like print!, but returns a String:
        let s = format!("{s} {data}");

        // Can't index into a string &s[0] due to ambiguity between bytes,
        // scalar values, and grapheme clusters.
        // Can use range of bytes: &s[0..4] (crashes if slice is in the middle
        // of a character)

        // Iterate over Unicode scalar values:
        for c in s.chars() {
            print!("{c} ");
        }

        for b in s.bytes() {
            print!("{b} ");
        }
    }

    {
        println!("\nHashMap");

        let mut rgb = HashMap::new();
        rgb.insert(String::from("Black"), 1);
        // Overwrites previous entry as Eq trait says the key is the same
        rgb.insert(String::from("Black"), 0);

        // Insert if not present
        rgb.entry(String::from("Black")).or_insert(1);

        let black_color = rgb.get("Black");
        let black_color_reference = black_color.copied();
        let black_color_value = black_color_reference.unwrap_or(0);

        println!("{black_color_value}");

        // !!! Iteration order is undefined
        for (key, value) in &rgb {
            println!("{key}: {value}");
        }
    }
}
