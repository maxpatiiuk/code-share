class MyClass:  # base class
    x = 5

    def __init__(self, new_x):
        self.x = new_x

    def my_method(self):  # has to be first, reference to my_class
        print(self.x)


my_object = MyClass(3)
my_object.my_method()
my_object.x = 4


class MyChildClass(MyClass):  # derived class
    def __init__(self, new_x):
        MyClass.__init__(self, new_x)  # super().__init__(self,new_x)
        MyChildClass.y = 5


my_tuple = (1, 2, 3)  # strings, lists, tuples, sets and dictionaries are iterable
my_iterator = iter(my_tuple)
print(next(my_iterator))


class MyIterable:
    def __iter__(self):
        self.a = 1
        return self

    def __next__(self):
        if self.a > 10:
            raise StopIteration  # raises error here
        x = self.a
        self.a += 1
        return x


def my_function():
    x = 2

    def my_inner_function():
        print(x)

    my_inner_function()
