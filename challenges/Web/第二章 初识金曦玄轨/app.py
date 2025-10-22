from flask import Flask, render_template, Response, send_from_directory
import os

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('golden_trail.html',
                         title="金曦禁制·初阶试炼",
                         hint="静观玄轨，可窥真形")

@app.route('/golden_trail')
def golden_trail():
    # 创建响应对象
    response = Response("""
========================
路径不正，难窥天道
========================
""", mimetype='text/plain')
    
    # 关键：将flag放在自定义响应头中
    response.headers['X-Jinxi-Secret'] = 'moectf{0bs3rv3_Th3_Gold3n_traiL}'
    return response


@app.route('/static/<path:filename>')
def static_files(filename):
    # 正常返回静态文件
    return send_from_directory(os.path.join(app.root_path, 'static'), filename)

@app.route('/<path:subpath>')
def catch_all(subpath):
    return Response("""
========================
虚空之中并无此物
========================
""", mimetype='text/plain', status=404)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)