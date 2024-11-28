use basic::m1_syntax;
use basic::m2_ownership;
use basic::m3_struct;
use basic::m4_enum;
use basic::m5_modules;
use basic::m6_collections;
use basic::m7_errors;
use basic::m8_traits;
use basic::m9_tests;

fn main() {
    struct Module(/* enabled */ bool, /* main */ fn());
    let modules = [
        Module(false, m1_syntax::main),
        Module(false, m2_ownership::main),
        Module(false, m3_struct::main),
        Module(false, m4_enum::main),
        Module(false, m5_modules::main),
        Module(false, m6_collections::main),
        Module(false, m7_errors::main),
        Module(false, m8_traits::main),
        Module(true, m9_tests::main),
    ];

    for Module(enabled, main) in modules {
        if enabled {
            main();
        }
    }
}
