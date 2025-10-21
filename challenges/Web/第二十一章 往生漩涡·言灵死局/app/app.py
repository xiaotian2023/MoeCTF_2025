from flask import Flask, request, render_template, render_template_string
app = Flask(__name__)

blacklist = ["__", "global", "{{", "}}"]

@app.route('/')
def index():
    if 'username' in request.args or 'password' in request.args:
        username = request.args.get('username', '')
        password = request.args.get('password', '')

        if not username or not password:
            login_msg = """
            <div class="login-result" id="result">
                <div class="result-title">阵法反馈</div>
                <div id="result-content"><div class='login-fail'>用户名或密码不能为空</div></div>
            </div>
            """
        else:
            login_msg = render_template_string(f"""
            <div class="login-result" id="result">
                <div class="result-title">阵法反馈</div>
                <div id="result-content"><div class='login-success'>欢迎：{username}</div></div>
            </div>
            """)

            for blk in blacklist:
                if blk in username:
                    login_msg = """
                    <div class="login-result" id="result">
                        <div class="result-title">阵法反馈</div>
                        <div id="result-content"><div class='login-fail'>Error</div></div>
                    </div>
                    """
    else:
        login_msg = ""

    return render_template("index.html", login_msg=login_msg)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
