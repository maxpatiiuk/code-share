def read_csv(root, file_name, keys):

    with open('{root}private_static/csv/{file_name}.csv'.format(root=root, file_name=file_name)) as file:
        data = file.read()

    lines = data.split("\n")
    return [dict(zip(keys, line.split(','))) for i, line in enumerate(lines) if i != 0]
