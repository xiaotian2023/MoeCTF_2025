from flask import Flask, request, jsonify, render_template

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/test_talent', methods=['POST'])
def talent_test():
    # 获取GET参数（天赋等级）
    talent_level = request.args.get('level', 'B')
    
    # 获取POST参数（光芒形态）
    data = request.get_json(silent=True)
    manifestation = data.get('manifestation', 'none') if data else 'none'
    
    # 验证篡改结果
    if talent_level == 'S' and manifestation == 'flowing_azure_clouds':
        return jsonify({
            "status": "天道篡改成功！",
            "result": "天赋：S，光芒：流云状青芒",
            "flag": "FLAG_PLACEHOLDER"
        })
    else:
        return jsonify({
            "status": "问剑石显化",
            "result": f"天赋：{talent_level}，光芒：{manifestation}"
        })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)