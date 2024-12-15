pub fn main() {
    {
        enum IpAddrKind {
            V4,
            V6,
        }

        let _four = IpAddrKind::V4;
        let _six = IpAddrKind::V6;

        fn _route(ip_kind: IpAddrKind) {
            match ip_kind {
                IpAddrKind::V4 => println!("V4"),
                IpAddrKind::V6 => println!("V6"),
            }
        }
    }

    {
        // Enum instance takes as much memory as the largest variant
        enum IpAddr {
            V4(u8, u8, u8, u8),
            V6(String),
            Alias { name: String },
        }

        impl IpAddr {
            fn print(&self) {
                match self {
                    IpAddr::V4(a, b, c, d) => println!("{}.{}.{}.{}", a, b, c, d),
                    IpAddr::V6(s) => println!("{}", s),
                    IpAddr::Alias { name } => println!("{}", name),
                    // other => println!("{:?}", other),
                    // _ => (),
                }

                if let IpAddr::V4(a, b, c, d) = self {
                    println!("{}.{}.{}.{}", a, b, c, d);
                }
            }
        }

        let home = IpAddr::V4(1, 2, 3, 4);
        let loopback = IpAddr::V6(String::from("::1"));
        let alias = IpAddr::Alias {
            name: String::from("alias"),
        };

        home.print();
        loopback.print();
        alias.print();
    }

    {
        // result monad: Result<Value, Error>
        // Consists of Ok(Value) or Err(Error)

        // enum Option<T> { None, Some(T), }

        let _some = Some(5);
        let _none: Option<i32> = None;
    }
}
