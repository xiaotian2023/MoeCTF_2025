from flask import Flask, render_template, send_from_directory, request, jsonify
import threading

app = Flask(
    __name__,
    static_folder='static',      
    template_folder='templates'  
)

# 用于统计有效POST次数
post_counter = {
    "count": 0
}
counter_lock = threading.Lock()

# 读取万言咒内容
with open('wanyanzhou.txt.bak', 'r', encoding='utf-8') as f:
    WANYANZHOU_CONTENT = f.read()

FLAG = "FLAG_PLACEHOLDER" 

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/wanyanzhou.txt.bak')
def download_file():
    return send_from_directory('.', 'wanyanzhou.txt.bak', as_attachment=True)

@app.route('/unseal', methods=['POST'])
def unseal():
    # 检查特殊请求头
    special_header = request.headers.get('X-SPECIAL-HEADER')
    if special_header != 'magic':
        return jsonify({"success": False, "message": "非法请求"}), 403

    data = request.get_json()
    content = data.get('content', '')

    # 判断内容是否与万言咒一致
    if content == WANYANZHOU_CONTENT:
        with counter_lock:
            post_counter["count"] += 1
            if post_counter["count"] >= 500:
                return jsonify({"success": True, "message": "已成功启封！", "flag": FLAG})
            else:
                return jsonify({"success": False, "message": f"内容正确，但还需提交 {500 - post_counter['count']} 次"})
    else:
        return jsonify({"success": False, "message": "内容不正确"})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)