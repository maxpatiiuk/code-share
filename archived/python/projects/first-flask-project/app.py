import gettext
from flask import Flask, render_template, request
from utilities.file_reader import read_csv

app = Flask(__name__)

# configure localization
app.jinja_options['extensions'].append('jinja2.ext.i18n')
en = gettext.translation('base', localedir='./private_static/languages/', languages=['en'])
en.install()
_ = en.gettext
ngettext = en.ngettext()

# FragmentCacheExtension  # pip install -U Flask cachelib

# export FLASK_APP=index.py FLASK_DEBUG=1 FLASK_ENV=development && flask run
# parameters : <param:var_name> : int, string, float, path (string with slashes)

app.add_url_rule('/public/css/<path:filename>',
                 endpoint='css',
                 view_func=app.send_static_file)

root = '/Users/maxpatiiuk/s/py_charm/flask/'


@app.route('/')
def hello_world():
    return 'Hello World!'


@app.route('/iframe')
def iframe():
    return render_template('iframe.html')


@app.route('/posts/class/<int:selected_class>/category/<string:category>/subcategory/<string:subcategory>/')
def filtered_posts(selected_class, category, subcategory):
    lines = read_csv(root, 'classes', ['key', 'name'])

    return render_template('posts.html',
                           selected_class=selected_class,
                           category=category,
                           subcategory=subcategory,
                           classes=lines)


@app.route('/posts/')
def posts():
    lines = read_csv(root, 'classes', ['key', 'name'])

    return render_template('posts.html',
                           classes=lines)


@app.route('/login', methods=['GET', 'POST'])
def login():
    error = None

    if request.method == 'POST':
        if request.form['login'] == 'testuser' == request.form['password']:
            return render_template('profile.html')
        else:
            error = 'Invalid login'

    # request.args.get('key', '') # GET params
    return render_template('login.html', error=error)


if __name__ == '__main__':
    app.run(debug=True)
