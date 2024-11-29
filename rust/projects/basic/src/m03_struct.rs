pub fn main() {
    #[derive(Debug)]
    struct Color(u8, u8, u8);

    #[derive(Debug)]
    struct User {
        username: String,
        color: Color,
    }

    impl User {
        // Static method (doesn't have self as 1st argument)
        fn mock() -> Self {
            Self {
                username: String::from("mock"),
                color: Color(0, 0, 0),
            }
        }

        // fn print(&self: &Self) {
        fn print(&self) {
            println!(
                "{username} {0} {1} {2}",
                self.color.0,
                self.color.1,
                self.color.2,
                username = self.username,
            );
        }

        // Method can re-use field name
        fn username(&self, other: &Self) {
            println!(
                "{username} {username2}",
                username = self.username,
                username2 = other.username
            );
        }
    }
    // Multiple `impl` blocks are combined

    let username = String::from("user1");
    let mut user1 = User {
        username,
        color: Color(1, 2, 3),
    };
    user1.username = String::from("user1_2");

    let user2 = User {
        username: String::from("user2"),
        ..user1
    };

    // :? does debug print - available on structs with #[derive(Debug)]
    println!("{user2:?}");
    // :#? does pretty-printed debug print
    println!("{:#?}", user2);
    // Verbose debug print with stack trace
    dbg!(&user2);

    user2.print(); // (&user2).print();
    user2.username(&User::mock());

    struct UnitStruct;
    let _unit = UnitStruct;
}
