"""

name       ordered changeable duplicate indexed
list       +       +          +
tuple      +       -          +
set        -       add only   -         -
dictionary -       +          -         +

"""

my_list = [1, 2, 3]
print(my_list[1])
print(my_list[-1])
print(my_list[1:-1])
print(my_list[:5])
print(my_list[2:])
print(2 in my_list)  # true
print(5 not in my_list)  # true
print([my_list] + [my_list])  # returns [a,b]  # modifies a to be a.append(b)

for x in my_list:
    my_list.count(x)  # finds and counts x in my_list

print(len(my_list) == my_list.__len__())

my_list.append(4)
my_list.extend([1, 2, 3])
my_list.insert(3, 1)  # insets 1 at 3rd position
my_list.remove(3)  # find and remove 3 from the my_list
my_list.pop(2)  # removes and returns 2nd
my_list.clear()  # []
reference_of_my_list = my_list
copy_of_my_list = my_list.copy()  # list(my_list)
my_list.reverse()  # reverses my_list


def my_function(e):
    return len(e)


my_list.sort(reverse=False, key=my_function)

del my_list[2]  # removes 2nd
del my_list
