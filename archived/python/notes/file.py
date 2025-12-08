import os

file_path = "/Users/maxpatiiuk/s/py_charm/first/data/my_file.txt"
my_file = open(file_path, "r")
for x in my_file:
    print(x)  # loop through the file
print(my_file.read())
print(my_file.read(6))  # read 6 bytes
print(my_file.readline())
print(my_file.readlines(7))  # read 7 bytes and finish cur line
my_file.close()

my_file = open(file_path, "w")
my_file.write("Now the file has more content!")
my_file.close()

my_file = open(file_path, "r")
print(my_file.read())
my_file.close()

if os.path.exists(file_path):
    os.remove(file_path)

dir_path = "/Users/maxpatiiuk/s/py_charm/first/directory"
if os.path.exists(dir_path):
    os.rmdir(dir_path)
else:
    os.mkdir(dir_path)

"""
r - beginning
creates, error if does
not exist, default
a - end, creates
w - beginning, creates, overwrites
x - beginning, creates, error if exists
t - read as text, default
b - read as binary
"""
