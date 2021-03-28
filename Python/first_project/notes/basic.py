import random
import my_module
import my_module as x
from my_module import my_var as x
import platform

# comment
"""
multiline comment
"""
print(x)


x = 2e10
if not type(x) is int:  # float, int, str, None
    print(2 ** 3)  # 2*10^3
x = 2 + 3j  # complex numbers
print(15 // 2)  # 7

isinstance(x, float)

print("%d", x)

x = y = z = "do"

print(random.randrange(0, 10))

a = '''some
text'''

print("qwerty"[1:-1])
print('Sample ', end='')  # does not print new line after this

# false
bool(False)
bool(None)
bool(0)
bool("")
bool(())
bool([])
bool({})

if True and False or random.randrange(0, 1) != 1:
    print(1)
elif random.randrange(0, 1) == 1:
    print(2)
else:
    print(3)
print(1) if True else print(2) if False else print(3)
if True:
    pass  # use this if need to have an empty if

while x in range(1, 5):
    if True and random.randrange(0, 1) != 1:
        continue
    elif random.randrange(0, 1) != 1:
        break
else:
    print(1)  # gets here if while loop did not break

for i in range(6):  # range(0,6)
    print(i)


def my_function(my_param, my_second_param=False, *my_list):  # args  # function receives a list
    return len(my_list) + my_param + int(my_second_param)


my_function(my_second_param=True, my_param=False)


def my_function(**my_dictionary):  # kwargs  # function receives a dictionary
    print(my_dictionary)


my_function(my_param=2, my_second_param=3, my_third_param=4)


def my_function(primary):
    return lambda b, c: primary + b + c


my_concat_function = my_function('a')
print(my_concat_function('b', 'c'))

x = 4


def my_function():
    print(x)


my_function()


def my_function():
    global y
    y = 2


print(x, my_function())


# MY_MODULE.PY
def my_function():
    print(2)


print(my_function())

# MAIN.PY
# import my_module

my_module.my_function()

# MY_MODULE.PY
a = 2

# MAIN.PY
# import my_module as x
print(x)

# MAIN2.PY
# from my_module import my_var  # OR from my_module import my_var as y
my_function()

print(y)

# import platform

print(platform.system())
print(platform.mac_ver())
print(platform.version())  # system version
print(platform.python_version())
print(dir(platform))  # returns a list of defined names in the module

my_string = input('String: ')
print(my_string)

# raise SystemExit # exits python
