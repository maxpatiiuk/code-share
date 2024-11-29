use std::env;
use std::error::Error;

use mini_grep::{run, Config};

fn main() -> Result<(), Box<dyn Error>> {
    let config = Config::build(env::args())?;

    run(config)
}
