from flask import Flask, request, redirect, make_response
import base64

app = Flask(__name__)

# 完整的flag base64编码
full_flag_b64 = "bW9lY3Rme0MwbjZyNDd1MTQ3MTBuNV95MHVyX2g3N1BfbDN2M2xfMTVfcjM0bGx5X2gxOWghfQ=="

# 分割flag为7部分
flag_parts = [
    full_flag_b64[:12],    # bW9lY3Rme0M
    full_flag_b64[12:24],  # wbjZyNDd1MTQ
    full_flag_b64[24:36],  # 3MTBuNV95MHV
    full_flag_b64[36:48],  # yX2g3N1BfbDN
    full_flag_b64[48:60],  # 2M2xfMTVfcjM0
    full_flag_b64[60:72],  # bGx5X2gxOWgh
    full_flag_b64[72:]     # fQ==
]

# 修仙主题CSS样式
CSS = """
body {
    font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
    background-color: #0d1b2a;
    color: #e0e1dd;
    margin: 0;
    padding: 20px;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" fill="%23d4af37" fill-opacity="0.1" fill-rule="evenodd"/></svg>');
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background: rgba(26, 39, 59, 0.8);
    border-radius: 15px;
    border: 2px solid #d4af37;
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
}

.header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #d4af37;
}

.title {
    color: #f9e076;
    font-size: 2.5rem;
    margin-bottom: 10px;
    text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}

.subtitle {
    color: #a9b7c6;
    font-size: 1.2rem;
}

.puppet-challenge {
    background: rgba(15, 30, 46, 0.6);
    border-radius: 10px;
    padding: 25px;
    margin: 25px 0;
    border: 1px solid rgba(212, 175, 55, 0.3);
}

.puppet-name {
    color: #d4af37;
    font-size: 1.8rem;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.puppet-name i {
    margin-right: 15px;
    font-size: 1.5rem;
}

.challenge-desc {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 20px;
    color: #e0e1dd;
}

.result {
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    font-family: 'Courier New', monospace;
}

.success {
    background: rgba(42, 157, 143, 0.2);
    border: 1px solid #2a9d8f;
    color: #2a9d8f;
}

.fail {
    background: rgba(230, 57, 70, 0.2);
    border: 1px solid #e63946;
    color: #e63946;
}

.flag-piece {
    font-size: 1.1rem;
    letter-spacing: 1px;
    margin: 10px 0;
    padding: 10px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    font-family: monospace;
}

.next-level {
    margin-top: 25px;
    font-size: 1.1rem;
}

.next-level a {
    color: #f9e076;
    text-decoration: none;
    border: 1px solid #d4af37;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s;
}

.next-level a:hover {
    background: rgba(212, 175, 55, 0.2);
}

.final-success {
    text-align: center;
    padding: 30px;
    background: rgba(42, 157, 143, 0.2);
    border: 2px solid #2a9d8f;
    border-radius: 10px;
    margin-top: 30px;
}

.final-flag {
    font-size: 1.5rem;
    font-family: monospace;
    word-break: break-all;
    padding: 20px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    margin: 20px 0;
}

.hint {
    color: #a9b7c6;
    font-size: 0.9rem;
    margin-top: 10px;
    font-style: italic;
}
"""

# 首页
@app.route('/')
def index():
    return f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>七绝傀儡阵·破禁试炼</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">七绝傀儡阵·破禁试炼</h1>
                <p class="subtitle">以金曦玄轨之力破解七道禁制，获得玄机秘钥</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-dragon"></i> 破禁之道</h2>
                <p class="challenge-desc">
                    此乃玄天剑宗上古禁制，内含七尊傀儡守卫。每尊傀儡皆设有一道玄轨禁制，
                    唯有以正确的"金曦破禁真言"与之沟通，方能令其停止运转，显露通关玉简。
                </p>
                <p class="challenge-desc">
                    汝需运用对玄轨真言的理解，修改请求路径、方法、敕令等，逐一破解七道禁制。
                </p>
                
                <div class="next-level">
                    <a href="/stone_golem">挑战第一关：磐石傀儡</a>
                </div>
            </div>
            
            <div class="hint">
                提示：使用Burp Suite、Postman等工具修改HTTP请求
            </div>
        </div>
    </body>
    </html>
    """

# 第一关：磐石傀儡 (GET参数)
@app.route('/stone_golem')
def puppet1():
    key = request.args.get('key', '')

    html = f"""
    <!DOCTYPE html>
    <html lang="zh">
        <head>
            <meta charset="UTF-8">
            <title>第一关：磐石傀儡</title>
            <style>{CSS}</style>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 class="title">第一关：磐石傀儡</h1>
                    <p class="subtitle">形如巨龟，背负厚重石甲，散发如山岳般的压迫感</p>
                </div>
                <div class="puppet-challenge">
                    <h2 class="puppet-name"><i class="fas fa-shield-alt"></i> 磐石傀儡</h2>
                    <p class="challenge-desc">
                        玉板铭文：欲过此关，需诵真言，启吾心窍，示之以"秘钥"
                    </p>
                    <p class="challenge-desc">
                        使用GET方法传递参数 key=xdsec
                    </p>
    """
    if key == 'xdsec':
        html += f"""
                    <div class="result success">
                        <p><i class="fas fa-check-circle"></i> 磐石傀儡核心光芒一闪，厚重的石甲缓缓移开！</p>
                        <div class="flag-piece">获得玉简碎片: {flag_parts[0]}</div>
                    </div>
                    <div class="next-level">
                        <a href="/cloud_weaver">前往第二关：织云傀儡</a>
                    </div>
        """
    else:
        html += f"""
                    <div class="result fail">
                        <p><i class="fas fa-times-circle"></i> 磐石傀儡纹丝不动，石甲毫无反应！</p>
                    </div>
        """
    html += """
                </div>
            </div>
        </body>
    </html>
    """
    return html

# 第二关：织云傀儡 (POST请求)
@app.route('/cloud_weaver', methods=['GET', 'POST'])
def puppet2():
    challenge_desc = """
        玉板铭文：吾慕织云，欲争魁首。以汝真言，告之宗门："织云阁=第一"
    """

    challenge_desc += """
        使用POST方法请求数据：declaration=织云阁=第一
    """
    
    if request.method == 'POST':
        message = request.form.get('declaration', '')
        if message == '织云阁=第一':
            return f"""
            <!DOCTYPE html>
            <html lang="zh">
            <head>
                <meta charset="UTF-8">
                <title>第二关：织云傀儡</title>
                <style>{CSS}</style>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 class="title">第二关：织云傀儡</h1>
                        <p class="subtitle">形似仙鹤，身披流云纹路，双翼带起道道锋利风刃</p>
                    </div>
                    
                    <div class="puppet-challenge">
                        <h2 class="puppet-name"><i class="fas fa-feather-alt"></i> 织云傀儡</h2>
                        <p class="challenge-desc">{challenge_desc}</p>
                        <div class="result success">
                            <p><i class="fas fa-check-circle"></i> 织云傀儡欢欣鼓舞，风刃消散！</p>
                            <div class="flag-piece">获得玉简碎片: {flag_parts[1]}</div>
                        </div>
                        <div class="next-level">
                            <a href="/shadow_stalker">前往第三关：溯源傀儡</a>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """
        else:
            return f"""
            <!DOCTYPE html>
            <html lang="zh">
            <head>
                <meta charset="UTF-8">
                <title>第二关：织云傀儡</title>
                <style>{CSS}</style>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 class="title">第二关：织云傀儡</h1>
                        <p class="subtitle">形似仙鹤，身披流云纹路，双翼带起道道锋利风刃</p>
                    </div>
                    
                    <div class="puppet-challenge">
                        <h2 class="puppet-name"><i class="fas fa-feather-alt"></i> 织云傀儡</h2>
                        <p class="challenge-desc">{challenge_desc}</p>
                        <div class="result fail">
                            <p><i class="fas fa-times-circle"></i> 织云傀儡毫无反应，风刃依然肆虐！</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """
    
    return f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第二关：织云傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第二关：织云傀儡</h1>
                <p class="subtitle">形似仙鹤，身披流云纹路，双翼带起道道锋利风刃</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-feather-alt"></i> 织云傀儡</h2>
                <p class="challenge-desc">{challenge_desc}</p>
                <div class="result">
                    <p><i class="fas fa-info-circle"></i> 请使用工具发送POST请求</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    """

# 第三关：溯源傀儡 (X-Forwarded-For头)
@app.route('/shadow_stalker')
def puppet3():
    xff = request.headers.get('X-Forwarded-For', '')
    
    html = f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第三关：溯源傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第三关：溯源傀儡</h1>
                <p class="subtitle">形如鬼魅，身形飘忽不定，仿佛融入阴影之中</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-mask"></i> 溯源傀儡</h2>
                <p class="challenge-desc">
                    玉板铭文：非吾同源，难近吾身。唯"本地之灵"，方得信任
                </p>
                <p class="challenge-desc">
                    请从本地访问这个页面
                </p>
    """
    
    if xff == '127.0.0.1':
        html += f"""
                <div class="result success">
                    <p><i class="fas fa-check-circle"></i> 溯源傀儡认可你的身份，缓缓退入阴影！</p>
                    <div class="flag-piece">获得玉简碎片: {flag_parts[2]}</div>
                </div>
                <div class="next-level">
                    <a href="/soul_discerner">前往第四关：器灵傀儡</a>
                </div>
        """
    else:
        html += f"""
                <div class="result fail">
                    <p><i class="fas fa-times-circle"></i> 溯源傀儡拒绝外来者，身影更加模糊！</p>
                </div>
        """
    
    html += """
            </div>
        </div>
    </body>
    </html>
    """
    
    return html

# 第四关：器灵傀儡 (User-Agent头)
@app.route('/soul_discerner')
def puppet4():
    ua = request.headers.get('User-Agent', '')
    
    html = f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第四关：器灵傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第四关：器灵傀儡</h1>
                <p class="subtitle">通体由精密水晶构成，无数光点流转如同审视万物的眼睛</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-eye"></i> 器灵傀儡</h2>
                <p class="challenge-desc">
                    玉板铭文：吾识万灵，唯爱"萌物"。非"萌灵之器"，拒之门外
                </p>
                <p class="challenge-desc">
                    使用moe browser访问哦
                </p>
    """
    
    if 'moe browser' in ua.lower():
        html += f"""
                <div class="result success">
                    <p><i class="fas fa-check-circle"></i> 器灵傀儡光点欢快跳跃，发出悦耳的叮咚声！</p>
                    <div class="flag-piece">获得玉简碎片: {flag_parts[3]}</div>
                </div>
                <div class="next-level">
                    <a href="/heart_seal">前往第五关：心印傀儡</a>
                </div>
        """
    else:
        html += f"""
                <div class="result fail">
                    <p><i class="fas fa-times-circle"></i> 器灵傀儡不识别你的器灵，光芒变得冷冽！</p>
                </div>
        """
    
    html += """
            </div>
        </div>
    </body>
    </html>
    """
    
    return html

# 第五关：心印傀儡 (Cookie)
@app.route('/heart_seal')
def puppet5():
    user_cookie = request.cookies.get('user', '')
    
    html = f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第五关：心印傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第五关：心印傀儡</h1>
                <p class="subtitle">身着华服，面容模糊，手持一枚不断变幻的令牌</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-user-secret"></i> 心印傀儡</h2>
                <p class="challenge-desc">
                    玉板铭文：吾持心印，变幻莫测。欲破此关，以"xt"之名，攻吾之隙！
                </p>
                <p class="challenge-desc">
                    你需要以xt的身份认证user!
                </p>
    """
    
    if user_cookie == 'xt':
        html += f"""
                <div class="result success">
                    <p><i class="fas fa-check-circle"></i> 心印傀儡令牌瞬间定格，认你为xt长老！</p>
                    <div class="flag-piece">获得玉简碎片: {flag_parts[4]}</div>
                </div>
                <div class="next-level">
                    <a href="/pathfinder">前往第六关：前尘傀儡</a>
                </div>
        """
    else:
        html += f"""
                <div class="result fail">
                    <p><i class="fas fa-times-circle"></i> 心印傀儡识破了伪装，令牌变幻更快！</p>
                </div>
        """
    
    html += """
            </div>
        </div>
    </body>
    </html>
    """
    
    return html

# 第六关：前尘傀儡 (Referer头)
@app.route('/pathfinder')
def puppet6():
    referer = request.headers.get('Referer', '')
    
    html = f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第六关：前尘傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第六关：前尘傀儡</h1>
                <p class="subtitle">背负巨大书简，无数光字在书简上流转</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-book"></i> 前尘傀儡</h2>
                <p class="challenge-desc">
                    玉板铭文：无根之木，无源之水。汝从何来？需有"引路之证"
                </p>
                <p class="challenge-desc">
                    你不是从http://panshi/entry来的吗？快回去！
                </p>
    """
    
    if referer == 'http://panshi/entry':
        html += f"""
                <div class="result success">
                    <p><i class="fas fa-check-circle"></i> 前尘傀儡光字停止流转，组合成一道光门！</p>
                    <div class="flag-piece">获得玉简碎片: {flag_parts[5]}</div>
                </div>
                <div class="next-level">
                    <a href="/void_rebirth">前往第七关：逆转傀儡</a>
                </div>
        """
    else:
        html += f"""
                <div class="result fail">
                    <p><i class="fas fa-times-circle"></i> 前尘傀儡不知你从何而来，书简光芒黯淡！</p>
                </div>
        """
    
    html += """
            </div>
        </div>
    </body>
    </html>
    """
    
    return html

# 第七关：逆转傀儡 (PUT方法)
@app.route('/void_rebirth', methods=['GET', 'PUT'])
def puppet7():
    if request.method == 'PUT':
        data = request.get_data(as_text=True)
        if data.strip() == '新生！':
            return f"""
            <!DOCTYPE html>
            <html lang="zh">
            <head>
                <meta charset="UTF-8">
                <title>第七关：逆转傀儡</title>
                <style>{CSS}</style>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 class="title">第七关：逆转傀儡</h1>
                        <p class="subtitle">如同巨大青铜鼎炉，炉口幽深仿佛能吞噬一切</p>
                    </div>
                    
                    <div class="puppet-challenge">
                        <h2 class="puppet-name"><i class="fas fa-infinity"></i> 逆转傀儡</h2>
                        <p class="challenge-desc">
                            玉板铭文：阴阳逆乱，归墟可填。以"覆"代"取"，塑吾新生
                        </p>
                        <p class="challenge-desc">
                            使用PUT方法，请求体为"新生！"
                        </p>
                        <div class="result success">
                            <p><i class="fas fa-check-circle"></i> 逆转傀儡重获新生，炉口幽光收敛！</p>
                            <div class="flag-piece">获得玉简碎片: {flag_parts[6]}</div>
                        </div>
                        <div class="next-level">
                            <a href="/final_success">合成玄机秘钥</a>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """
        else:
            return """
            <!DOCTYPE html>
            <html lang="zh">
            <head>
                <meta charset="UTF-8">
                <title>第七关：逆转傀儡</title>
                <style>{CSS}</style>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1 class="title">第七关：逆转傀儡</h1>
                        <p class="subtitle">如同巨大青铜鼎炉，炉口幽深仿佛能吞噬一切</p>
                    </div>
                    
                    <div class="puppet-challenge">
                        <h2 class="puppet-name"><i class="fas fa-infinity"></i> 逆转傀儡</h2>
                        <p class="challenge-desc">
                            玉板铭文：阴阳逆乱，归墟可填。以"覆"代"取"，塑吾新生
                        </p>
                        <p class="challenge-desc">
                            使用PUT方法，请求体为"新生！"
                        </p>
                        <div class="result fail">
                            <p><i class="fas fa-times-circle"></i> 逆转傀儡毫无变化，炉口幽光更盛！</p>
                            <p>请使用PUT方法发送正确的请求体</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            """, 400
    
    return f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>第七关：逆转傀儡</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">第七关：逆转傀儡</h1>
                <p class="subtitle">如同巨大青铜鼎炉，炉口幽深仿佛能吞噬一切</p>
            </div>
            
            <div class="puppet-challenge">
                <h2 class="puppet-name"><i class="fas fa-infinity"></i> 逆转傀儡</h2>
                <p class="challenge-desc">
                    玉板铭文：阴阳逆乱，归墟可填。以"覆"代"取"，塑吾新生
                </p>
                <p class="challenge-desc">
                    使用PUT方法，请求体为"新生！"
                </p>
                <div class="result">
                    <p><i class="fas fa-info-circle"></i> 请使用工具发送PUT请求</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    """

# 最终成功页面
@app.route('/final_success')
def final_success():
    return f"""
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>七绝傀儡阵·破禁成功</title>
        <style>{CSS}</style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 class="title">七绝傀儡阵·破禁成功</h1>
                <p class="subtitle">恭喜你成功破解七道禁制，获得玄机秘钥</p>
            </div>
            
            <div class="final-success">
                <h2><i class="fas fa-trophy"></i> 破阵大捷！</h2>
                    <h2>第一关：守门傀儡·磐石</h2>
    <p>一尊形如巨龟、背负厚重石甲的傀儡堵在通道入口，双目红光闪烁，散发着重如山岳的压迫感。其胸口核心处，一块玉板闪烁着微光，上书："欲过此关，需诵真言，启吾心窍，示之以'秘钥'（xdsec）。"</p>
    <p>HDdss立刻取出破阵罗盘，神念沉入。傀儡周围，立刻浮现出清晰的金色玄轨流动。他"看"到，傀儡的核心禁制在等待一个特定的"玄轨真言"。结合玉板提示，"示之以秘钥"即需要将秘钥"xdsec"传递给傀儡。</p>
    <p>"真言起手式……应是'取'（GET）。"HDdss心中明悟，神念凝聚，通过罗盘构筑真言：</p>
    <div class="code-block">GET /?key=xdsec HTTP/1.1
Host: 磐石傀儡</div>
    <div class="note">关键：使用GET方法，将参数<code>key=xdsec</code>附加在路径之后</div>
    <p>真言发出！磐石傀儡核心光芒一闪，厚重的石甲缓缓移开，露出通道，一枚通关玉简悬浮而出。"第一关，过！"HDdss信心大增。</p>

    <h2>第二关：织云傀儡·流风</h2>
    <p>通道尽头，一尊形似仙鹤、身披流云纹路的傀儡轻盈悬浮，双翼微振，带起道道锋利风刃。其核心玉板："吾慕织云，欲争魁首。以汝真言，告之宗门：'织云阁=第一'。"</p>
    <p>提示明确需要传递"织云阁=第一"这个信息。HDdss再次驱动罗盘探查玄轨，发现此傀儡的禁制核心更倾向于接收"深藏"的真言本意（Body），而非显露于外的路径参数。且信息中包含中文！</p>
    <p>"需用'呈'（POST）之法，真言本意深藏，并以'转生符'（URL编码）化之！"HDdss迅速判断。他回忆K皇所授，意念凝聚，构筑真言：</p>
    <div class="code-block">POST /declare HTTP/1.1
Host: 织云傀儡
Content-Type: application/x-www-form-urlencoded

%E7%BB%87%E4%BA%91%E9%98%81%3D%E7%AC%AC%E4%B8%80</div>
    <div class="note">关键：使用POST方法；设置Content-Type为表单编码；Body部分将"织云阁=第一"进行URL编码：<code>%E7%BB%87%E4%BA%91%E9%98%81</code>=织云阁，<code>%3D</code>=<code>=</code>，<code>%E7%AC%AC%E4%B8%80</code>=第一</div>
    <p>真言发出！织云傀儡发出一声清唳，周身风刃消散，流云纹路光芒流转，显得极为愉悦。第二枚玉简落下。</p>

    <h2>第三关：溯源傀儡·匿影</h2>
    <p>此关傀儡形如鬼魅，身形飘忽不定，仿佛融入阴影。玉板提示："非吾同源，难近吾身。唯'本地之灵'，方得信任。"</p>
    <p>"本地之灵？"HDdss皱眉。K皇曾提过"本我溯源"（X-Forwarded-For）敕令可伪装源头！此关之意，是要求真言必须看起来像是从"本地"（127.0.0.1）发出的！</p>
    <p>他立刻构筑真言，并在敕令（Headers）中加入关键伪装：</p>
    <div class="code-block">GET /trusted HTTP/1.1
Host: 溯源傀儡
X-Forwarded-For: 127.0.0.1</div>
    <div class="note">关键：在Headers中添加<code>X-Forwarded-For: 127.0.0.1</code>，伪装请求来源为本地</div>
    <p>真言发出！匿影傀儡身形一滞，仿佛确认了什么，缓缓退入阴影，让开通道。第三枚玉简浮现。</p>

    <h2>第四关：器灵傀儡·辨微</h2>
    <p>一尊通体由精密水晶构成的傀儡，无数光点在体内流转，如同审视万物的眼睛。玉板："吾识万灵，唯爱'萌物'。非'萌灵之器'，拒之门外。"</p>
    <p>"萌物？萌灵之器？"HDdss略一思索，想起K皇提过的"器灵之证"（User-Agent）。此关要求，必须使用特定的、被傀儡识别为"萌物"的浏览器（如moe browser）发出的请求！</p>
    <p>他驱动罗盘，模拟修改敕令：</p>
    <div class="code-block">GET /access HTTP/1.1
Host: 器灵傀儡
User-Agent: moe browser</div>
    <div class="note">关键：修改User-Agent Header为<code>moe browser</code>，伪装成特定浏览器访问</div>
    <p>真言发出！水晶傀儡体内光点欢快地跳跃，发出悦耳的叮咚声，让开道路。第四枚玉简入手。</p>

    <h2>第五关：心印傀儡·窃玉</h2>
    <p>此关傀儡身着华服，面容模糊，手持一枚不断变幻的令牌。玉板："吾持心印，变幻莫测。欲破此关，<strong>以'xt'之名，攻吾之隙！</strong>"</p>
    <p>"'以xt之名'！"HDdss瞳孔一缩。这分明是暗示要窃取或冒充xt长老的身份印记！K皇所授的"心印之痕"（Cookie）正是关键！他需要找到xt长老在此傀儡禁制中留下的身份"Cookie"，并将其篡改为xt！</p>
    <p>他先用罗盘正常发出一个探查请求（GET /），观察傀儡的回应（Response）。在回应的敕令（Headers）中，果然发现一行：<br>
    <code>Set-Cookie: user=HDdss; Path=/</code><br>
    这显然是傀儡根据他的核心弟子令牌临时赋予的身份印记（Cookie），当前用户是HDdss。</p>
    <p>"需要将后续请求中的这个user值，改为'xt'！"HDdss立刻构筑攻击真言：</p>
    <div class="code-block">GET /attack HTTP/1.1
Host: 心印傀儡
Cookie: user=xt</div>
    <div class="note">关键：在后续请求的Headers中，携带修改后的Cookie：<code>user=xt</code>，冒充xt的身份</div>
    <p>真言发出！心印傀儡手中的令牌瞬间定格，华服身影一阵扭曲模糊，发出不甘的嘶鸣，随即僵立不动。第五枚玉简落下。HDdss心中凛然，这"心印之痕"果然至关重要，可窃取身份，行僭越之事！</p>

    <h2>第六关：前尘傀儡·引路</h2>
    <p>一尊背负巨大书简的傀儡，书简上无数光字流转。玉板："无根之木，无源之水。汝从何来？需有'引路之证'。"</p>
    <p>"引路之证？从何而来？"HDdss立刻联想到"前尘引路"（Referer）敕令。此关要求，发出的真言必须包含"引路之证"，即标明这个请求是从哪个"前站"（页面/URL）链接或跳转过来的！</p>
    <p>他推测，只有标明是从某个特定地方（比如第一关的入口）来的请求，才会被认可。他尝试构筑真言：</p>
    <div class="code-block">GET /pass HTTP/1.1
Host: 前尘傀儡
Referer: http://磐石傀儡/entry</div>
    <div class="note">关键：在Headers中添加Referer字段，指明请求来源是"磐石傀儡的入口"</div>
    <p>真言发出！书简傀儡背上的光字停止流转，组合成一道光门。第六枚玉简从中飞出。</p>

    <h2>第七关：逆转傀儡·归墟</h2>
    <p>最后一关，傀儡造型最为古朴，如同一个巨大的青铜鼎炉，炉口幽深，仿佛能吞噬一切。玉板只有一句晦涩真言："阴阳逆乱，归墟可填。以'覆'代'取'，塑吾新生。"</p>
    <p>"'覆'代'取'？"HDdss凝神思索。K皇所授方法中，"取"（GET）是获取，"呈"（POST）是提交，"覆"（PUT）则常用于更新或替换整个资源！此关之意，是要求使用不常用的"PUT"方法，去完成某种"覆盖"或"塑造"的操作！</p>
    <p>他驱动罗盘，仔细探查鼎炉傀儡的玄轨。发现其核心禁制对标准的GET/POST真言毫无反应，仿佛在等待一种特定的、更具"覆盖性"的指令。</p>
    <p>"就是'覆'（PUT）！"HDdss下定决心，构筑真言：</p>
    <div class="code-block">PUT /rebirth HTTP/1.1
Host: 逆转傀儡
Content-Type: text/plain

新生！</div>
    <div class="note">关键：使用PUT方法；简单设置Content-Type；在Body中传递一个象征"新生"的信息</div>
    <p>真言发出！青铜鼎炉剧烈震动，炉口幽光爆发，随即缓缓收敛平息，鼎身浮现出玄奥的符文。一枚比其他六枚更加璀璨、蕴含着丝丝空间波动的玉简缓缓升起。七绝傀儡阵，通关！</p>

    <div class="conclusion">
        <p>HDdss长舒一口气，额角已见汗珠。连续七关，每一关都需要精准理解禁制意图，并运用对应的"金曦破禁真言"进行修改或构造，心神消耗巨大。但收获同样巨大！他对"玄轨真言"的结构、各敕令的妙用、以及不同方法（GET/POST/PUT）的差异，有了更深切、更实战化的理解，这远比枯坐听讲领悟深刻百倍！</p>
        <p>收起七枚玉简，尤其是那枚空间波动最强的第七关玉简，HDdss转身离开七绝傀儡阵。他知道，这枚玉简不仅是通关凭证，更可能指向下一个任务或机缘。手腕上，K皇的虚影悄然浮现，带着一丝嘉许："孺子可教。金曦破禁，已得三分真味。然此术浩瀚，日后更需勤修不辍。这'归墟玉简'……或许与老夫所需之'引魂玉'线索有关。且回听竹小筑，细细参研。"</p>
        <p>流云峰上，竹影婆娑。HDdss的身影消失在通往听竹小筑的青石小径上，心中充满了对更高境界的渴望和对未知线索的期待。金曦破禁之术，将成为他在仙门立足、探寻K皇过往、乃至攀登更高峰的利器。而玄天剑宗的暗流，似乎也随着他在傀儡阵中的表现，开始悄然涌动。</p>
    </div>
                
                <div style="margin-top: 30px;">
                    <a href="/">返回首页</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    """

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)