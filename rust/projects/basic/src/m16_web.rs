use std::{
    fs,
    io::prelude::*,
    net::{TcpListener, TcpStream},
};

pub fn main() {
    let listener = TcpListener::bind("127.0.0.1:7878").unwrap();

    for stream in listener.incoming() {
        let stream = stream.unwrap();

        handle_connection(stream);
    }
}

fn handle_connection(mut stream: TcpStream) {
    let status_line = "HTTP/1.1 200 OK";

    let contents = fs::read_to_string("./src/m16_web.rs").unwrap();
    let contents = contents.replace("<", "&lt;").replace(">", "&gt;");
    let full_contents = format!("<pre>{contents}</pre>");
    let length = full_contents.len();

    let response = format!("{status_line}\r\nContent-Length: {length}\r\n\r\n{full_contents}");

    stream.write_all(response.as_bytes()).unwrap();
}
