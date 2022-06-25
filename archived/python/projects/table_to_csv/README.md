# table_to_csv
Little python script that converts html tables to csv
# source
Source code is located in the file named `TableToCsv.py`
# how_to_use

1. Create html file containing \<table\> as a root element: <img width="509" alt="Screen Shot 2020-01-12 at 5 02 52 PM" src="https://user-images.githubusercontent.com/40512816/72227089-1b556280-355e-11ea-87fb-271c6c637f1d.png">
1. Import TableToCsv into your script
1. Read the data from html file
1. Run the parser
1. Save the output into a csv file

Sample usage:
```python
from TableToCsv import TableToCsv  # import the script

csv_file_path = "table.html"
my_file = open(csv_file_path, "r")
my_html = my_file.read(). # writhe html into my_html
my_file.close()

parser = TableToCsv(settings)
parser.feed(my_html)
my_csv = parser.get_output(). # write result csv into my_csv

csv_file_path = "data.csv"
my_file = open(csv_file_path, "w")
my_file.write(my_csv)  # save result into csv_file_path
my_file.close()

```

And here is the result:

<img width="509" alt="Screen Shot 2020-01-12 at 5 03 47 PM" src="https://user-images.githubusercontent.com/40512816/72227090-1b556280-355e-11ea-8152-87dcda6b812e.png">

# settings

Optional dictionary with settings can be passed to the constructor
The default parameters are specified below
```python
settings = {
    'columns_to_exclude': [],
    'mode': 'auto'  # [columns_from_first_tr, columns_from_th]
}

parser = TableToCsv(settings)
```
 - `columns_to_exclude` - a list of columns that should be excluded from the resulting csv (e.x. `['Age', 'Go']`)

 - `mode` - changes the way script recognizes column headings and it does not matter if  `columns_to_exclude` is empty

    The value of `auto` will make script try to find the column headings automatically
    
    `columns_from_first_tr` will use all `<td>` from the first `<tr>` as column headings.

    `columns_from_th` will use all `<th>` as column names


# contributions
Everyone is free to contribute to this repository
