from flask import Flask, render_template, jsonify, request

app = Flask(__name__)
FLAG = "FLAG_PLACEHOLDER"

@app.route('/')
def index():
    return render_template('number.html')

@app.route('/flag', methods=['POST'])
def flag():
    # 这里只返回flag，不做校验（前端已判断）
    return jsonify({'flag': FLAG})

if __name__ == '__main__':
    app.run(debug=True)