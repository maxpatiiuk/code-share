my_list = [1, 2, 3, 'a', 'b', 'c']
my_set = {'a', 'b', 'c'}  # not ordered  # not editable  # can add
my_second_set = set(my_set)
my_third_set = set(my_list)
my_set.add(1)
my_set.update(my_second_set)  # combines into my_set
my_set.union(my_second_set)  # returns combined set
my_set.remove('a')  # raise error if not found
my_set.discard('a')  # does not raise error if not found
my_set.clear()  # {}
my_set.intersection(my_second_set, my_third_set, ...)  # returns intersection set
my_set.intersection_update(my_second_set)  # my_set = intersection
my_set.isdisjoint(my_second_set)  # true if no duplicates between sets
my_set.difference(my_second_set)  # returns set of values that are only in my_set
my_set.difference_update(my_second_set)  # removes common values from my_set
my_set.symmetric_difference(my_second_set)  # returns set of unique values from both
my_set.symmetric_difference(my_second_set)  # my_set = set of unique values from both

sliced_set = my_set
parent_set = my_third_set
sliced_set.issubset(parent_set)
parent_set.issuperset(sliced_set)
