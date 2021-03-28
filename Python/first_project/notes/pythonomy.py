colors = ['a','b','c']
colors2 = ['1','2','3']

for color in colors:
	print(color)

for color in reversed(colors):
	print(color)

for i, color in enumerate(colors):
	print('%s --> %s' % (i, color))

for color_1, color_2 in zip(colors, colors2)
	print('%s, %s' % (color_1, color_2))

for color in sorted(colors):
	print(color)

for color in sorted(colors, reverse=True):
	print(color)

print sorted(colors, key=len)  # sort by str len

for i,color in enumerate(colors):
	if color=='a':
		return i
else:  # did not break
	return -1


d = {'a':'b'}
d2 = {'1':'2'}

for k in d:
	prink(key)

for k in d.keys():  # if dictionary is mutated
	print(key)

for k, v in d.items():
	print(k,v)


d = {k : d[k] for k in d if len(k)>2}

d = dict(zip(d1,d2))

d = dict(enumearate(d))  # convert assoc dict to numeric dict


# count the number of occurrences of each item in the list
d = defaultdict(int)  # undefined keys will have int() by default  # int() returns 0 by default
for color in colors:
	d[color] += 1


# group by len
d = defaultdict(list)
for name in names:
	key = len(name)
	d[key].append(name)

# destructive iteration over dict
while d:
	key, value = d.popitem()
	pring('%s > %s' % (key, value))

'abcd'.startswith('b')  # False

TestResults = namedtuple('TestResults', ['failed', 'attempted'])  # tuple with 2 named keys

a, b, c, d = my_tuple


@cache  # should be put before any pure function
def web_lookup(url):  # caches the result of the function
	return requests.get(url)


@contextmanager
def ignored(*exceptions):
	try:
		yield
	except exceptions:
		pass

# suppress() can also be importedf
with ignored(OSError):  # ignores file does not exist error
	os.remove('file.tmp')


print sum(i**2 for i in range(10))  # sum the powers of first 10 numbers