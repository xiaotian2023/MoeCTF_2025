<?php
$login_msg = '';
if (isset($_GET['username']) && isset($_GET['password'])) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "user";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        $login_msg = '<div class="login-fail">数据库连接失败</div>';
    } else {
        $user = $_GET['username'];
        $pass = $_GET['password'];
        // ⚠️ 存在SQL注入，比赛题目特意保留
        $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $login_msg = '<div class="login-success">'. "Welcome " . htmlspecialchars($row['username']) . '</div>';
        } else {
            $login_msg = '<div class="login-fail">登录失败，请检查神识印记与心法密咒</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>玄机阁 · 九重天衍禁制</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold-primary: #d4af37;
            --gold-secondary: #f9e076;
            --gold-tertiary: #b8860b;
            --deep-blue: #0a192f;
            --dark-bg: #0d1b2a;
            --jade-light: #5cd0b9;
            --jade-dark: #2a9d8f;
            --silk-red: #c62e2e;
            --silk-light: #f5e8c9;
            --scrollbar: #2c3e50;
            --text-light: #e0e1dd;
        }

        html, body {
            height: 100%;
            overflow: auto;
        }

        body {
            background:
                    linear-gradient(rgba(13, 27, 42, 0.9), rgba(10, 25, 47, 0.9)),
                    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200"><path d="M20,50 Q40,30 60,50 T100,50 T140,50 T180,50" stroke="%232a9d8f" stroke-width="0.5" fill="none" opacity="0.1"/><path d="M10,80 Q30,60 50,80 T90,80 T130,80 T170,80" stroke="%23d4af37" stroke-width="0.5" fill="none" opacity="0.1"/><path d="M30,110 Q50,90 70,110 T110,110 T150,110 T190,110" stroke="%23c62e2e" stroke-width="0.5" fill="none" opacity="0.1"/></svg>');
            color: var(--text-light);
            font-family: 'Microsoft YaHei', 'SimSun', serif;
            min-height: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* 修改为顶部对齐 */
            position: relative;
            overflow: auto;
            padding: 20px 0; /* 添加上下内边距 */
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                    radial-gradient(circle at 20% 30%, rgba(92, 208, 185, 0.1) 0%, transparent 20%),
                    radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
            z-index: -1;
            pointer-events: none;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: rgba(13, 27, 42, 0.85);
            border-radius: 15px;
            box-shadow:
                    0 0 30px rgba(92, 208, 185, 0.3),
                    0 0 60px rgba(212, 175, 55, 0.2);
            border: 2px solid var(--jade-light);
            overflow: hidden;
            position: relative;
            z-index: 1;
            margin: 50px 0; /* 添加上下外边距 */
        }

        .header {
            background: linear-gradient(90deg, var(--deep-blue) 0%, rgba(10, 25, 47, 0.8) 100%);
            padding: 25px 30px;
            border-bottom: 2px solid var(--gold-primary);
            text-align: center;
            position: relative;
        }

        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M10,10 Q25,5 40,10 T70,10 T100,10" stroke="%23d4af37" stroke-width="1" fill="none" opacity="0.1"/><path d="M5,30 Q20,25 35,30 T65,30 T95,30" stroke="%235cd0b9" stroke-width="1" fill="none" opacity="0.1"/></svg>');
            opacity: 0.2;
            z-index: -1;
        }

        .title-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .title-icon {
            font-size: 3.5rem;
            color: var(--gold-secondary);
        }

        .title-text {
            font-size: 2.5rem;
            background: linear-gradient(to right, var(--gold-secondary), var(--jade-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(92, 208, 185, 0.3);
            letter-spacing: 3px;
            font-weight: bold;
        }

        .title-subtext {
            margin-top: 10px;
            font-size: 1.2rem;
            color: rgba(224, 225, 221, 0.8);
            max-width: 600px;
            line-height: 1.7;
            text-align: center;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--jade-light), transparent);
            margin: 20px 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: "✧";
            position: absolute;
            top: -12px;
            color: var(--gold-primary);
            font-size: 1.5rem;
        }

        .divider::before {
            left: 20%;
        }

        .divider::after {
            right: 20%;
        }

        .content {
            padding: 30px 40px 40px;
        }

        .login-container {
            background: rgba(26, 39, 59, 0.6);
            border-radius: 10px;
            padding: 30px;
            border: 1px solid rgba(92, 208, 185, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><path d="M10,10 Q20,5 30,10 T50,10 T70,10" stroke="%23d4af37" stroke-width="0.8" fill="none" opacity="0.1"/></svg>');
            opacity: 0.1;
            z-index: -1;
        }

        .form-title {
            font-size: 1.6rem;
            color: var(--gold-secondary);
            margin-bottom: 25px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .form-title i {
            font-size: 2rem;
            color: var(--jade-light);
            background: rgba(0, 0, 0, 0.3);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--jade-light);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 1.2rem;
            color: var(--jade-light);
            margin-bottom: 10px;
            padding-left: 10px;
            position: relative;
        }

        .form-label::before {
            content: "✧";
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold-primary);
        }

        .form-input {
            width: 100%;
            padding: 14px 20px;
            background: rgba(10, 25, 47, 0.7);
            border: 1px solid rgba(92, 208, 185, 0.4);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(92, 208, 185, 0.1);
            font-family: 'Microsoft YaHei', serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold-primary);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .submit-btn {
            display: block;
            width: 100%;
            background: linear-gradient(135deg, var(--jade-dark), var(--jade-light));
            color: var(--deep-blue);
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Microsoft YaHei', serif;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .submit-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(92, 208, 185, 0.5);
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .warning-container {
            margin-top: 30px;
            background: rgba(198, 46, 46, 0.1);
            border: 1px solid var(--silk-red);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .warning-title {
            color: var(--gold-secondary);
            font-size: 1.3rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .warning-content {
            color: rgba(255, 200, 200, 0.9);
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 25px;
            color: rgba(224, 225, 221, 0.6);
            border-top: 1px solid rgba(92, 208, 185, 0.2);
            font-size: 0.9rem;
            background: rgba(10, 25, 47, 0.5);
        }

        .footer a {
            color: var(--jade-light);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* 滚动条样式 */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(10, 25, 47, 0.5);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--gold-tertiary), var(--gold-primary));
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }

        /* 动画效果 */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .title-icon {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(92, 208, 185, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(92, 208, 185, 0); }
            100% { box-shadow: 0 0 0 0 rgba(92, 208, 185, 0); }
        }

        .submit-btn {
            animation: pulse 3s infinite;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                margin: 20px 0;
            }

            .header {
                padding: 20px;
            }

            .title-text {
                font-size: 2rem;
            }

            .content {
                padding: 20px;
            }

            .login-container {
                padding: 20px;
            }
        }

        /* 符文装饰 */
        .rune {
            position: absolute;
            font-size: 1.5rem;
            color: rgba(92, 208, 185, 0.3);
            z-index: 0;
        }

        .rune-1 { top: 10%; left: 5%; }
        .rune-2 { top: 15%; right: 5%; }
        .rune-3 { bottom: 20%; left: 7%; }
        .rune-4 { bottom: 15%; right: 8%; }

        /* 扩展内容区域 */
        .additional-content {
            padding: 20px;
            margin-top: 30px;
            background: rgba(26, 39, 59, 0.5);
            border-radius: 10px;
            border: 1px solid rgba(92, 208, 185, 0.2);
        }

        .additional-title {
            font-size: 1.4rem;
            color: var(--gold-secondary);
            margin-bottom: 15px;
            text-align: center;
        }

        .history-section {
            margin-bottom: 25px;
        }

        .history-title {
            color: var(--jade-light);
            font-size: 1.2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .history-content {
            color: rgba(224, 225, 221, 0.8);
            line-height: 1.7;
            padding-left: 28px;
        }

        .rules-section {
            background: rgba(10, 25, 47, 0.3);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .rules-title {
            color: var(--silk-red);
            font-size: 1.1rem;
            margin-bottom: 10px;
            text-align: center;
        }

        .rules-list {
            padding-left: 20px;
        }

        .rules-list li {
            margin-bottom: 8px;
            position: relative;
            padding-left: 25px;
        }

        .rules-list li::before {
            content: "⚔";
            position: absolute;
            left: 0;
            color: var(--gold-primary);
        }

        .login-fail {
            margin-top: 18px;
            color: #fff0f0;
            background: rgba(198,46,46,0.18);
            border: 1px solid #c62e2e;
            border-radius: 6px;
            padding: 14px 0;
            text-align: center;
            font-size: 1.15rem;
            font-weight: bold;
            box-shadow: 0 0 8px rgba(198,46,46,0.12);
            animation: shake 0.4s;
        }
        .login-success {
            margin-top: 18px;
            color: #2a9d8f;
            background: rgba(92,208,185,0.10);
            border: 1px solid #2a9d8f;
            border-radius: 6px;
            padding: 14px 0;
            text-align: center;
            font-size: 1.15rem;
            font-weight: bold;
            box-shadow: 0 0 8px rgba(92,208,185,0.12);
        }
        @keyframes shake {
            10%, 90% { transform: translateX(-2px);}
            20%, 80% { transform: translateX(4px);}
            30%, 50%, 70% { transform: translateX(-8px);}
            40%, 60% { transform: translateX(8px);}
        }
    </style>
</head>
<body>
<div class="container">
    <!-- 符文装饰 -->
    <div class="rune rune-1">☯</div>
    <div class="rune rune-2">䷀</div>
    <div class="rune rune-3">䷁</div>
    <div class="rune rune-4">☯</div>

    <div class="header">
        <div class="title-container">
            <div class="title-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h1 class="title-text">九重天衍禁制</h1>
            <p class="title-subtext">玄机阁第九重天 · 守阁人亲设 · 非天衍真言术不可破</p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="content">
        <div class="login-container">
            <h2 class="form-title">
                <i class="fas fa-user-secret"></i>
                叩关玄机阁
            </h2>
            <form action="" method="GET">
                <div class="form-group">
                    <label class="form-label">神识印记</label>
                    <input type="text" name="username" class="form-input" placeholder="输入你的神识印记...">
                </div>
                <div class="form-group">
                    <label class="form-label">心法密咒</label>
                    <input type="text" name="password" class="form-input" placeholder="输入你的心法密咒...">
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-dragon"></i> 叩关破禁
                </button>
            </form>
            <!-- 登录结果提示 -->
            <?php if (!empty($login_msg)) echo $login_msg; ?>

            <div class="warning-container">
                <h3 class="warning-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    禁制告示
                </h3>
                <p class="warning-content">
                    此禁制蕴含守阁人千年修为，非天衍真言术不可破！<br>
                    妄图强行破禁者，必遭血瞳破魂光反噬，神魂俱灭！<br>
                    玄天剑宗第三十七代宗主 · 玄机真人 立
                </p>
            </div>
        </div>

        <!-- 扩展内容区域 - 提供滚动空间 -->
        <div class="additional-content">
            <h3 class="additional-title"><i class="fas fa-scroll"></i> 玄机阁历史</h3>

            <div class="history-section">
                <h4 class="history-title"><i class="fas fa-landmark"></i> 创阁起源</h4>
                <p class="history-content">
                    玄机阁始建于三千七百年前，由玄天真人亲创。初为收藏宗门典籍之所，后经七代阁主扩建，终成九重天结构。每层阁楼皆设不同禁制，最高层第九重天由守阁人亲自镇守，藏有宗门最核心的秘法真传。
                </p>
            </div>

            <div class="history-section">
                <h4 class="history-title"><i class="fas fa-dragon"></i> 守阁人传说</h4>
                <p class="history-content">
                    守阁人乃玄机阁最神秘的存在，相传为玄天真人师弟玄机真人所化。在千年前的宗门大劫中，玄机真人以毕生修为化为守阁禁制，魂魄与玄机阁融为一体。其"血瞳破魂光"可洞穿虚妄，灭杀一切擅闯者。
                </p>
            </div>

            <div class="rules-section">
                <h4 class="rules-title">禁地规章</h4>
                <ul class="rules-list">
                    <li>亥时至卯时为禁制最强时段，万勿接近</li>
                    <li>非持宗主令者，不得踏入第七重天以上</li>
                    <li>禁制范围内禁用一切遁术及空间法宝</li>
                    <li>遇血瞳显化，需立即收敛气息，原地静立</li>
                    <li>阁内玉简不可带离，违者废去修为</li>
                </ul>
            </div>
            <div class="history-section">
                <h4 class="history-title"><i class="fas fa-book"></i> 天衍真言术</h4>
                <p class="history-content">
                    此术为破解玄机阁禁制的无上秘法，需精通"SELECT、UNION、FROM"三大真言精髓。相传此术修至大成，可洞悉万物本源，破解一切禁制。然修习此术需极高悟性，千年来唯xt长老等寥寥数人掌握。
                </p>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>玄天剑宗 · 玄机阁 · 天衍真言禁制</p>
        <p>三界六道之中，唯洞悉"SELECT、UNION、FROM"真谛者，方可窥此门径</p>
    </div>
</div>

<script>
    // 添加简单的交互效果
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-input');
        const submitBtn = document.querySelector('.submit-btn');

        // 输入框聚焦效果
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.boxShadow = '0 0 15px rgba(92, 208, 185, 0.3)';
            });

            input.addEventListener('blur', function() {
                this.style.boxShadow = '0 0 10px rgba(92, 208, 185, 0.1)';
            });
        });

        // 按钮点击效果
        submitBtn.addEventListener('click', function() {
            this.classList.remove('pulse');
            void this.offsetWidth; // 触发重绘
            this.classList.add('pulse');
        });

        // 随机生成修仙术语的提示
        const usernameExamples = ["玄天真君", "云缈仙子", "剑痴长老", "守阁人"];
        const passwordExamples = ["金曦玄轨", "周天星图", "龟息藏灵", "血瞳破魂"];

        let index = 0;
        setInterval(() => {
            inputs[0].placeholder = `输入你的神识印记，如：${usernameExamples[index]}`;
            inputs[1].placeholder = `输入你的心法密咒，如：${passwordExamples[index]}`;
            index = (index + 1) % usernameExamples.length;
        }, 3000);
    });
</script>
</body>
</html>