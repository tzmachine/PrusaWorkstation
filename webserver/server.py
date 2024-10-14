from flask import Flask, render_template

server = Flask(__name__)

@server.route('/')

def index():

 return render_template('index.html')

@server.route('/print')
def print():
 return 'Rasperry Pie!'
 
if __name__ == '__main__':

 server.run (debug=True, host='0.0.0.0')
