pub struct LinkedList<T> {
    head: Option<Box<Node<T>>>,
    // FEATURE: add tail to make .add faster, once I learn how to have two
    // references to the same node
}

// FEATURE: support both owned and borrowed T (using Into<> or Borrow<>?)
impl<T> LinkedList<T> {
    pub fn new() -> LinkedList<T> {
        LinkedList { head: None }
    }

    pub fn from(iterable: impl IntoIterator<Item = T>) -> LinkedList<T> {
        let mut list = LinkedList::new();

        let mut tip: &mut Option<Box<Node<T>>> = &mut None;

        for item in iterable {
            let node = Node {
                value: item,
                next: None,
            };
            let new_tip = Some(Box::new(node));

            match tip {
                Some(tip_box) => {
                    tip_box.next = new_tip;
                    tip = &mut tip_box.next;
                }
                None => {
                    list.head = new_tip;
                    tip = &mut list.head;
                }
            }
        }

        list
    }

    // Since method returns a trait rather than a struct, it needs to
    // use `impl`
    // FEATURE: can concrete types be used instead of `impl`?
    pub fn as_iterator(&self) -> impl Iterator<Item = &T> {
        let mut current = &self.head;

        std::iter::from_fn(move || match current {
            Some(node) => {
                let node = node.as_ref();
                current = &node.next;
                Some(&node.value)
            }
            None => None,
        })
    }

    pub fn push(&mut self, value: T) {
        let mut previous: &mut dyn WithNext<T> = self;
        let mut next = &mut self.head;

        // while let Some(node) = next {
        // let node = node.as_mut();
        // previous = node;
        // next = &mut node.next;
        // }

        loop {
            match next {
                Some(node) => {
                    let node = node.as_mut();
                    previous = node;
                    next = &node.next();
                }
                None => break,
            }
        }

        previous.set_next(Some(Box::new(Node { value, next: None })));
    }
}

pub trait WithNext<T> {
    fn next(&self) -> &Option<Box<Node<T>>>;
    fn set_next(&mut self, next: Option<Box<Node<T>>>) -> ();
}

impl<T> WithNext<T> for LinkedList<T> {
    fn next(&self) -> &Option<Box<Node<T>>> {
        &self.head
    }

    fn set_next(&mut self, next: Option<Box<Node<T>>>) -> () {
        self.head = next;
    }
}

#[derive(PartialEq, Debug)]
pub struct Node<T> {
    value: T,
    // Need to own the next node, so don't use &.
    // At the same time, since Rust needs to statically know the Node<> size,
    // use Box<> to store the next node on the heap.
    next: Option<Box<Node<T>>>,
}

impl<T> WithNext<T> for Node<T> {
    fn next(&self) -> &Option<Box<Node<T>>> {
        &self.next
    }

    fn set_next(&mut self, next: Option<Box<Node<T>>>) -> () {
        self.next = next;
    }
}

#[cfg(test)]
mod test {
    use super::*;

    #[test]
    fn new() {
        let list: LinkedList<i32> = LinkedList::new();
        assert_eq!(list.head, None);
    }

    #[test]
    fn from_iterable_and_back() {
        let array = [1, 2, 3];
        let list = LinkedList::from(array);

        let vec = list.as_iterator().collect::<Vec<_>>();
        assert_eq!(format!("{:?}", vec), "[1, 2, 3]");
    }
}
