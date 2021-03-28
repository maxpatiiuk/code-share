import json

json_string = '{ "name":"John", "age":30, "city":"New York"}'
my_object = json.loads(json_string)
print(my_object['name'])
print(json.dumps(my_object, indent=4, separators=(", ", ": "), sort_keys=True))
