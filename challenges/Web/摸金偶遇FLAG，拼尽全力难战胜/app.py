from flask import Flask, jsonify, request, session, render_template
import random
import time
import os

app = Flask(__name__)
app.secret_key = os.urandom(24)

restrict_time = 3
flag = os.environ.get("FLAG", "CTF{No_Flag_Configured}")

@app.route('/')
def index():
    """首页加载游戏界面"""
    return render_template('index.html')

@app.route('/get_challenge', methods=['GET'])
def get_challenge():
    """
    生成挑战随机数并返回数字和唯一令牌
    响应: { "numbers": [8, 1, 4], "token": "唯一令牌" }
    同时向会话存储 numbers, token 和创建时间戳
    随机数个数由 GET 请求参数指定
    """
    # 获取随机数个数参数，默认为3
    try:
        count = int(request.args.get('count', 3))
        if count <= 0:  # 限制随机数个数范围
            raise ValueError("Count must be between 1 and 10")
    except ValueError:
        return jsonify({
            "error": "Invalid count parameter. Must be an integer between 1 and 10."
        }), 400

    # 生成指定数量的0-9随机数
    numbers = [random.randint(0, 9) for _ in range(count)]
    
    # 创建防重放令牌 (组合时间戳+随机数)
    token = f"{int(time.time()*1000)}_{random.getrandbits(32):08x}"
    
    # 存储到会话 (用于后续验证)
    session['challenge'] = {
        'numbers': numbers,
        'token': token,
        'created_at': time.time()
    }
    
    return jsonify({"numbers": numbers, "token": token})

@app.route('/verify', methods=['POST'])
def verify_solution():
    """
    验证用户提交的答案
    请求: { "answers": [7, 1, 4], "token": "提交令牌" }
    响应: { "correct": false, "message": "Error", "flag": null }

    要求保存在 session 内的 token 和 POST 数据内的 token 匹配
    即验证答案中的 token 来自生成挑战的同一会话
    """
    data = request.json
    
    # 检查请求完整性
    if not data or 'answers' not in data or 'token' not in data:
        return jsonify({
            "correct": False,
            "message": "Invalid request format",
            "flag": None
        }), 400
        
    # 从会话获取挑战
    stored = session.get('challenge')
    if not stored:
        return jsonify({
            "correct": False,
            "message": "Challenge expired or not started",
            "flag": None
        }), 401
        
    # 验证令牌匹配 (防CSRF/重放)
    if stored['token'] != data['token']:
        return jsonify({
            "correct": False,
            "message": "Invalid challenge token",
            "flag": None
        }), 403
        
    # 检查挑战有效期
    if time.time() - stored['created_at'] > restrict_time:
        return jsonify({
            "correct": False,
            "message": "Challenge expired",
            "flag": None
        }), 408
        
    # 转换答案类型
    try:
        submitted = list(map(int, data['answers']))
    except ValueError:
        return jsonify({
            "correct": False,
            "message": "Invalid answer format",
            "flag": None
        }), 400
        
    # 获取正确答案
    correct_answers = list(map(int, stored['numbers']))
    
    # 验证答案
    if submitted == correct_answers:
        # 清空挑战（防重放）
        session.pop('challenge', None)
        return jsonify({
            "correct": True,
            "message": "Correct!",
            "flag": flag
        })
    else:
        return jsonify({
            "correct": False,
            "message": "Incorrect solution",
            "flag": None
        })
    
if __name__ == "__main__":
    app.run(debug=False, host='0.0.0.0', port=80)