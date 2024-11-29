use basic::m01_syntax;
use basic::m02_ownership;
use basic::m03_struct;
use basic::m04_enum;
use basic::m05_modules;
use basic::m06_collections;
use basic::m07_errors;
use basic::m08_traits;
use basic::m09_tests;
use basic::m10_functional;

fn main() {
    struct Module(/* enabled */ bool, /* main */ fn());
    let modules = [
        Module(false, m01_syntax::main),
        Module(false, m02_ownership::main),
        Module(false, m03_struct::main),
        Module(false, m04_enum::main),
        Module(false, m05_modules::main),
        Module(false, m06_collections::main),
        Module(false, m07_errors::main),
        Module(false, m08_traits::main),
        Module(false, m09_tests::main),
        Module(true, m10_functional::main),
    ];

    for Module(enabled, main) in modules {
        if enabled {
            main();
        }
    }
}
