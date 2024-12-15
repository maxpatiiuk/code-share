use std::{
    cell::RefCell,
    rc::{Rc, Weak},
};

pub trait Component {
    fn controllers(&self) -> RefCell<Vec<Box<dyn Controller>>>;
    fn add_controller(&self, controller: Box<dyn Controller>) {
        self.controllers().borrow_mut().push(controller);
    }
    // TODO: Implement remove_controller
}

pub trait Controller {
    fn parent(&self) -> Weak<dyn Component>;
}

struct ControllerA {
    component: Weak<dyn Component>,
    value: i32,
}

impl ControllerA {
    fn new(parent: &Weak<dyn Component>, value: i32) -> Self {
        Self {
            component: parent.clone(),
            value,
        }
    }
}

impl Controller for ControllerA {
    fn parent(&self) -> Weak<dyn Component> {
        self.component.clone()
    }
}

struct RootComponent {
    a: ControllerA,
    b: ControllerA,
}

impl RootComponent {
    fn new() -> Rc<Self> {
        Rc::new_cyclic(|self_ref| Self {
            a: ControllerA::new(self_ref),
            b: ControllerB::new(self_ref),
        })
    }
}

impl Component for RootComponent {
    fn controllers(&self) -> RefCell<Vec<Box<dyn Controller>>> {
        RefCell::new(vec![Box::new(self.a), Box::new(self.b)])
    }
}
