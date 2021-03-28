my_dictionary = {
    '1': '2',
    '3': '4',
    '5': '6'
}

for x in my_dictionary:
    print(x)  # print keys
    print(my_dictionary[x])  # print values
for x in my_dictionary.values():
    print(x)  # print values
for x, y in my_dictionary.items():
    print(x, y)

my_dictionary.pop('1')
my_dictionary.popitem()  # pops last
my_second_dictionary = dict(my_dictionary)  # = my_dictionary.copy()
my_third_dictionary = dict(a=1, b=2, c=3)
my_fourth_dictionary = dict.fromkeys(['a', 'b', 'c'], 0)  # sets all to 0
my_fourth_dictionary.setdefault('1', 2)  # if '1' does not exists, return 2, else return it

del my_dictionary['1']
del my_dictionary
