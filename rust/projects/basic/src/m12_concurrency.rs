use std::sync::mpsc;
use std::sync::Arc;
use std::sync::Mutex;
use std::thread;
use std::time::Duration;

pub fn main() {
    {
        println!("Threads");

        let v = vec![1, 2, 3];

        let handle = thread::spawn(move || {
            println!("Vector: {:?}", v);

            for i in 1..10 {
                println!("t {i} ");
                thread::sleep(Duration::from_millis(1))
            }
        });

        for i in 1..10 {
            println!("m {i} ");
            thread::sleep(Duration::from_millis(1))
        }

        // Await thread completion
        // Otherwise, it will be killed when main thread completes
        handle.join().unwrap();
    }

    {
        println!("\nMessage passing");

        // Multiple producer, single consumer
        // (transmitter, receiver)
        let (tx, rx) = mpsc::channel();
        let tx1 = tx.clone();

        thread::spawn(move || {
            let val = String::from("K/DA");
            tx.send(val).unwrap();
            thread::sleep(Duration::from_secs(1));
            tx.send("aespa".to_owned()).unwrap();
        });

        thread::spawn(move || {
            let val = String::from("IVE");
            tx1.send(val).unwrap();
            thread::sleep(Duration::from_secs(1));
            tx1.send("Blackpink".to_owned()).unwrap();
        });

        // .recv() blocks
        // .try_recv() is non-blocking
        let received = rx.recv().unwrap();
        println!("{}", received);

        for received in rx {
            println!("{}", received);
        }
    }

    {
        println!("\nMutex - mutual exclusion");
        // Mutex = atomic RefCell

        let m = Mutex::new(5);
        {
            // Block tread till we can acquire the lock
            let mut num = m.lock().unwrap();
            *num = 6;
        }
        println!("m = {:?}", m);
    }

    {
        println!("\nArc - atomic (=thread-safe) Rc");

        let counter = Arc::new(Mutex::new(0));
        let mut handles = vec![];

        for _ in 0..10 {
            let counter = Arc::clone(&counter);
            let handle = thread::spawn(move || {
                let mut num = counter.lock().unwrap();

                *num += 1;
            });
            handles.push(handle);
        }

        for handle in handles {
            handle.join().unwrap();
        }

        println!("Distributed counter: {}", *counter.lock().unwrap());
    }

    {
        // Send trait - allow transferring ownership between threads
        // Sync trait - allow sharing immutable references between threads
        // Type composed of Send or Sync is also Send or Sync

        // Sync trait = a value that implements a Send reference
    }
}
