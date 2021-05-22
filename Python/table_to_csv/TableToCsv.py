from abc import ABC
from html.parser import HTMLParser


class TableToCsv(HTMLParser, ABC):
    current_tag = ''
    columns = []
    output = ''
    columns_to_exclude = []
    column_numbers_to_exclude = []
    current_number = 0
    mode = 'columns_from_th'
    is_first_tr = None

    def __init__(self, new_settings=None):

        self.is_first_tr = False
        if new_settings is None:
            new_settings = {}

        if 'columns_to_exclude' in new_settings and type(new_settings['columns_to_exclude']) is list:
            self.columns_to_exclude = new_settings['columns_to_exclude']

        if 'mode' in new_settings and new_settings['mode'] in ['columns_from_first_tr', 'auto']:
            self.mode = new_settings['mode']

        super().__init__()

    def handle_starttag(self, tag, attrs):
        self.current_tag = tag

        if tag == 'tr':
            self.current_number = 0

        if self.is_first_tr is False and tag == 'tr' and self.mode in ['auto', 'columns_from_first_tr']:
            self.is_first_tr = True

    def handle_endtag(self, tag):
        if tag == 'tr':

            if self.output[-1] == ',':
                self.output = self.output[:-1]
                self.output += '\n'

            if self.is_first_tr is True:
                self.is_first_tr = False

    def handle_data(self, data):
        if data == '\n':
            return

        self.current_number += 1

        if self.current_number in self.column_numbers_to_exclude:
                return

        if self.current_tag == 'th':

            if data in self.columns_to_exclude:
                self.column_numbers_to_exclude.append(self.current_number)
                return

            if self.mode == 'auto':
                self.mode = 'columns_from_th'

            self.is_first_tr = None

            self.columns.append(data)
            self.output += data + ','

        elif self.current_tag == 'td':

            if self.mode == 'auto' and self.is_first_tr is not None:
                self.mode = 'columns_from_first_tr'

            if self.is_first_tr and self.mode == 'columns_from_first_tr':

                if data in self.columns_to_exclude:
                    self.column_numbers_to_exclude.append(self.current_number)
                    return

                self.columns.append(data)

            self.output += data + ','

    def get_output(self):
        return self.output


