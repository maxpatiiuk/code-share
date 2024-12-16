pub fn main() {
    {
        println!("Places where patterns can be used");
        // Compared to JavaScript, new places are:
        // match
        // if let
        // while let

        match Some("1") {
            Some("1") => println!("One"),
            // Compiler has exhaustiveness check
            _ => println!("None"),
        }

        let value = Some("1");

        // Can chain if let and non let
        // Accepts refutable pattern (doesn't have to match)
        if let Some(value) = value {
            println!("shadowing: {value}");
        } else if let Some(value) = Some("2") {
            println!("{value}");
        }
        // No exhaustiveness check enforcement

        // Accepts refutable pattern (doesn't have to match)
        let mut v = vec![1, 2];
        while let Some(value) = v.pop() {
            println!("{value}");
        }

        // Accepts only irrefutable pattern (not much to do otherwise)
        for (index, value) in vec![1].iter().enumerate() {
            println!("{index}: {value}");
        }

        // Accepts only irrefutable pattern (not much to do otherwise)
        let (x, _) = (1, 2);
        println!("{x}");

        // Error: mismatched types
        // let (x, y) = (1, 2, 3);

        fn first((x, _): (i32, i32)) -> i32 {
            x
        }
        first((1, 2));
    }

    {
        println!("\nPattern syntax");

        match 1 {
            1 => println!("One"),
            2 | 3 => println!("Two or three"),
            3..5 => println!("Two to three"),
            // Must have irrefutable pattern last
            x => println!("{x}"),
        }

        match 'A' {
            'a'..'z' => println!("Lowercase"),
            _ => (),
        }

        struct Pair {
            x: i32,
            y: i32,
        }
        let pair = Pair { x: 1, y: 2 };
        let Pair { x, y: y2 } = pair;
        println!("{x}, {y2}");

        if let Pair { x: 0, y } = pair {
            println!("X is 0 and Y is {y}");
        }

        enum Message {
            Quit,
            Move { x: i32, y: i32 },
            Write(String),
            ChangeColor(Pair),
        }

        let msg = Message::ChangeColor(Pair { x: 1, y: 2 });
        let _ = Message::Quit;
        // _ is thrown away rather than bound:
        let _ = Message::Move { x: 1, y: 2 };
        let _ = Message::Write("Hello".to_string());

        match msg {
            Message::Quit => (),
            Message::Move { x, y } => println!("{x}_{y}"),
            Message::Write(text) => println!("{text}"),
            Message::ChangeColor(Pair { x, y }) => println!("{x}_{y}"),
        }

        let ((_, _), Pair { x: _, y: _ }) = ((3, 10), pair);

        match (Some(1), Some(2)) {
            (Some(_), Some(_)) => println!("Some"),
            _ => (),
        }

        // .. = ignore the rest
        let Pair { x: _, .. } = pair;

        match (1, 2, 3, 4) {
            (1, .., 4) => println!("1 .. 4"),
            // Condition checked against every element
            (x, ..) | (1, x, ..) if x > 0 => println!("{x}"),
            _ => (),
        }

        match Some(1) {
            Some(x) if x % 2 == 0 => println!("Even"),
            _ => (),
        }

        match (Pair { x: 1, y: 2 }) {
            // Use @ to pattern match and bind at the same time
            Pair { x: x2 @ 3..=7, .. } => println!("Found an x in range: {x2}"),
            Pair { x: 10..=12, .. } => {
                println!("Found an id in another range")
            }
            _ => (),
        }
    }
}
