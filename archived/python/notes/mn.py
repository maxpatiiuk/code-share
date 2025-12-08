import numpy
import json
import pandas
import pydotplus
import matplotlib.pyplot as plt
import matplotlib.image as pltimg
from scipy import stats
from sklearn import tree
from sklearn import linear_model
from sklearn.metrics import r2_score
from sklearn.preprocessing import StandardScaler
from sklearn.tree import DecisionTreeClassifier

"""
Numerical values (Discrete: integers; Continuous: size)
Categorical (color; yes/no)
Ordinal (like Categorical but can be measured: A+)

Mean - average
Median - midpoint (sort; if even, then average of two)
Mode - most common
"""

my_list = [1, 2, 2, 3]
numpy.mean(my_list)  # 2
numpy.median(my_list)  # 2
numpy.std(my_list)  # 0.89 # standard deviation # var**0.5 # σ
numpy.var(my_list)  # 0.8 # variance # std**2 # σ**2
numpy.percentile(my_list, 50)  # 2 # percentile # 50% are 2 or less
stats.mode(my_list)

x = numpy.random.uniform(0.0, 5.0, 250)  # 250 floats between 0.0 and 5.0
plt.hist(x, 5)  # plot that with 5 columns
plt.show()

x = numpy.random.normal(5.0, 1.0, 100000)  # normal distribution # Gaussian data distribution
plt.hist(x, 5)
plt.show()
# bell shaped # 5 most common and usually 1 away from it


plt.scatter([1, 2, 3, 4], [4, 3, 2, 1])
plt.show()

x = numpy.random.normal(5.0, 1.0, 1000)
y = numpy.random.normal(10.0, 2.0, 1000)
plt.scatter(x, y)
plt.show()

x = [5, 7, 8, 7, 2, 17, 2, 9, 4, 11, 12, 9, 6]
y = [99, 86, 87, 88, 111, 86, 103, 87, 94, 78, 77, 85, 86]

slope, intercept, r, p, std_err = stats.linregress(x, y)


# r # relationship between points # min 0 # max abs(1)


def my_function(x_val):
    return slope * x_val + intercept


model = list(map(my_function, x))  # runs my_function for each x and returns list of results

plt.scatter(x, y)
plt.plot(x, model)  # plots and connects points
plt.show()

x = [1, 2, 3, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 18, 19, 21, 22]
y = [100, 90, 80, 60, 60, 55, 60, 65, 70, 70, 75, 76, 78, 79, 90, 99, 99, 100]

model = numpy.poly1d(numpy.polyfit(x, y, 3))  # create a polynomial line
line = numpy.linspace(1, 22, 100)  # specify line params

print(r2_score(y, model(x)))  # r
print(model(17))  # predict y when x is 17
plt.scatter(x, y)
plt.plot(line, model(line))
plt.show()

file_path = "/data/cars.json"
my_json = open(file_path).read()
my_object = json.loads(my_json)

X = []
y = []
for line in my_object:
    X.append([int(line[1]), int(line[0])])
    y.append(int(line[2]))

regression = linear_model.LinearRegression()
regression.fit(X, y)
predictedCO2 = regression.predict([[3300, 1300]])

print(predictedCO2)
print(regression.coef_)  # how does y increases with change in X[] by 1

scale = StandardScaler()

file_path = "/data/cars.csv"
df = pandas.read_csv(file_path)

X = df[['Weight', 'Volume']]
y = df['CO2']

scaledX = scale.fit_transform(X)

regression = linear_model.LinearRegression()
regression.fit(scaledX, y)

scaled = scale.transform([[2300, 1.3]])

predictedCO2 = regression.predict([scaled[0]])
print(scaled, predictedCO2)

# plot prediction
x = numpy.random.normal(3, 1, 100)
y = numpy.random.normal(150, 40, 100) / x

train_x = x[:80]
train_y = y[:80]

test_x = x[80:]
test_y = y[80:]

model = numpy.poly1d(numpy.polyfit(train_x, train_y, 4))
line = numpy.linspace(0, 6, 100)

print(r2_score(test_y, model(test_x)))  # r

plt.scatter(train_x, train_y)
plt.plot(line, model(line))
plt.show()

print(model(5))


# go to comedy show tree here
csv_file_path = "/Users/maxpatiiuk/s/py_charm/first/data/people.csv"
df = pandas.read_csv(csv_file_path)

d = {'UK': 0, 'USA': 1, 'N': 2}
df['Nationality'] = df['Nationality'].map(d)
d = {'YES': 1, 'NO': 0}
df['Go'] = df['Go'].map(d)

features = ['Age', 'Experience', 'Rank', 'Nationality']

X = df[features]
y = df['Go']

decision_tree = DecisionTreeClassifier()
decision_tree = decision_tree.fit(X, y)
data = tree.export_graphviz(decision_tree, out_file=None, feature_names=features)
graph = pydotplus.graph_from_dot_data(data)
png_image_path = "/Users/maxpatiiuk/s/py_charm/first/data/result.png"
graph.write_png(png_image_path)

img = pltimg.imread(png_image_path)
image_plot = plt.imshow(img)
plt.show()

print(decision_tree.predict([[40, 10, 7, 1]]))
print(decision_tree.predict([[40, 10, 6, 1]]))
