from flask import Flask, render_template, json

app = Flask(__name__)

@app.route('/')
def inicio():
    return render_template('index.html', title='INDEX')

@app.route('/test')
def test():
    return render_template('test.html', title='INDEX')

if __name__ == '__main__':
    app.run(port=8080, debug=True, host='0.0.0.0')