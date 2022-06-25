import re

my_string = "The rain in Spain"
x = re.split(" ", my_string, maxsplit=2)
y = re.sub(" ", "_", my_string, count=2)  # p reg_replace

z = re.search("^T.*n$", my_string)  # findall(...)
z.span()  # (0,5)
print(z.string)  # my_string
z.group()  # returns a match

"""
All start with one slash:
A - beginning of the string (!Z) (^$)
b - boundary (!B)
d - digits (!D)
s - whitespace (!S)
w - A-Za-z0-9_ (!W)
"""