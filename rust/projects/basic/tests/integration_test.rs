// We can only import what's exposed by src/lib.ts
use basic::m09_tests;

mod common;

// Run this test file only:
// cargo t --test integration_test

#[test]
fn it_adds_two() {
    assert_eq!(m09_tests::add(2, 4), 6);
}

#[test]
fn it_uses_common_utils() {
    assert_eq!(common::get_zero(), 0);
}
