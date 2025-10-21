<?php
session_start();

$now = time();

if (isset($_SESSION['last_request']) && ($now - $_SESSION['last_request']) < 1) {
    http_response_code(429); // Too Many Requests
    echo "Too many requests.";
    exit;
}

$_SESSION['last_request'] = $now;

if (!isset($_SESSION['param'])) {
    // 生成随机参数名，长度5
    $_SESSION['param'] = str_shuffle('mnopq');
}

$param = $_SESSION['param'];

if (isset($_GET[$param]) && $_GET[$param] == $param) {
    // 条件满足，跳转到 find.php
    header("Location: find.php");
    echo "SUCCESS: parameter $param matched";
    exit;
}
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>千机禁域 - 阵枢破阵</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Microsoft YaHei', 'STKaiti', serif;
        }

        body {
            background: linear-gradient(135deg, #0a0c1a, #1a2030, #1c1525);
            color: #e0d0a0;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            padding: 20px;
        }

        /* 星辰背景 */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .star {
            position: absolute;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: twinkle 5s infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* 符箓背景 */
        .runes-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                    radial-gradient(circle, rgba(120, 90, 40, 0.1) 1px, transparent 1px),
                    radial-gradient(circle, rgba(150, 110, 50, 0.15) 1px, transparent 1px);
            background-size: 80px 80px, 50px 50px;
            background-position: 0 0, 40px 40px;
            z-index: -1;
            opacity: 0.3;
        }

        /* 移动的符箓 */
        .floating-rune {
            position: absolute;
            font-size: 24px;
            color: rgba(180, 150, 80, 0.6);
            opacity: 0.7;
            z-index: -1;
        }

        /* 主容器 */
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(20, 15, 10, 0.85);
            border: 2px solid #8a6d3b;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(180, 150, 80, 0.4),
            inset 0 0 30px rgba(100, 75, 30, 0.5);
            padding: 30px;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        /* 青铜边框装饰 */
        .border-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 3px solid #8a6d3b;
        }

        .corner-tl {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
            border-top-left-radius: 15px;
        }

        .corner-tr {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
            border-top-right-radius: 15px;
        }

        .corner-bl {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
            border-bottom-left-radius: 15px;
        }

        .corner-br {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
            border-bottom-right-radius: 15px;
        }

        /* 标题区域 */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #8a6d3b;
            position: relative;
        }

        h1 {
            font-size: 2.8em;
            color: #e0c070;
            text-shadow: 0 0 10px #8a6d3b, 0 0 20px #8a6d3b;
            letter-spacing: 3px;
            margin-bottom: 10px;
            font-weight: normal;
            position: relative;
        }

        h1:after {
            content: "";
            display: block;
            width: 150px;
            height: 3px;
            background: linear-gradient(to right, transparent, #8a6d3b, transparent);
            margin: 15px auto;
        }

        .subtitle {
            font-size: 1.2em;
            color: #c9b27d;
            font-style: italic;
            margin-top: 10px;
        }

        /* 阵法描述 */
        .matrix-description {
            background: rgba(15, 10, 5, 0.7);
            border: 1px solid #8a6d3b;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            line-height: 1.8;
            position: relative;
        }

        .description-title {
            text-align: center;
            font-size: 1.4em;
            margin-bottom: 15px;
            color: #d4b15f;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .description-title i {
            margin: 0 10px;
            color: #8a6d3b;
        }


        .param-title i {
            margin-right: 10px;
            color: #8a6d3b;
        }

        .result-title i {
            margin-right: 10px;
            color: #8a6d3b;
        }


        /* 页脚 */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(138, 109, 59, 0.3);
            color: #8a7d6a;
            font-size: 0.9em;
        }

        /* 响应式调整 */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }

            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
<!-- 星辰背景 -->
<div class="stars" id="stars-container"></div>

<!-- 符箓背景 -->
<div class="runes-bg"></div>

<!-- 主容器 -->
<div class="container">
    <!-- 青铜边框装饰 -->
    <div class="border-decoration">
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>
    </div>

    <div class="header">
        <h1>千机禁域</h1>
        <p class="subtitle">十万八千虚门，唯有一实门可通阵眼</p>
    </div>

    <!-- 阵法描述 -->
    <div class="matrix-description">
        <div class="description-title">
            <i class="fas fa-dungeon"></i> 阵枢玄机
            <i class="fas fa-dungeon"></i>
        </div>
        <p>此阵乃天衍阁无上秘术，由十万八千青铜符箓构成，每道符箓皆蕴含随机参数真名。阵眼核心藏有《破阵真言》，唯有同时破解参数之谜与路径禁制者，方可破此千机大阵。</p>
        <p>阵中符箓瞬息万变，参数真名每时不同。欲破此阵，需以神念穷举推演，寻得正确参数，再以虚空穿行之法，穿越层层禁制，直抵阵眼核心。</p>
    </div>

    <!-- 页脚 -->
    <div class="footer">
        <p>天衍阁 · 千机禁制</p>
        <p>破阵者：HDdss</p>
    </div>
</div>

<script>
    // 创建星辰背景
    function createStars() {
        const container = document.getElementById('stars-container');
        const starCount = 200;

        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.classList.add('star');

            // 随机属性
            const size = Math.random() * 3;
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const duration = 3 + Math.random() * 10;
            const delay = Math.random() * 5;

            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.left = `${posX}%`;
            star.style.top = `${posY}%`;
            star.style.animationDuration = `${duration}s`;
            star.style.animationDelay = `${delay}s`;

            container.appendChild(star);
        }
    }

    // 创建浮动符箓
    function createFloatingRunes() {
        const runes = ['䷀', '䷁', '䷂', '䷃', '䷄', '䷅', '䷆', '䷇', '䷈', '䷉', '䷊', '䷋'];
        const body = document.body;

        for (let i = 0; i < 30; i++) {
            const rune = document.createElement('div');
            rune.classList.add('floating-rune');
            rune.textContent = runes[Math.floor(Math.random() * runes.length)];

            // 随机属性
            const size = 20 + Math.random() * 30;
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const duration = 20 + Math.random() * 30;
            const delay = Math.random() * 5;

            rune.style.fontSize = `${size}px`;
            rune.style.left = `${posX}%`;
            rune.style.top = `${posY}%`;
            rune.style.animation = `float ${duration}s ${delay}s infinite linear`;

            body.appendChild(rune);
        }

        // 添加浮动动画
        const style = document.createElement('style');
        style.textContent = `
                @keyframes float {
                    0% { transform: translate(0, 0) rotate(0deg); }
                    25% { transform: translate(20px, -15px) rotate(5deg); }
                    50% { transform: translate(40px, 10px) rotate(0deg); }
                    75% { transform: translate(20px, 25px) rotate(-5deg); }
                    100% { transform: translate(0, 0) rotate(0deg); }
                }
            `;
        document.head.appendChild(style);
    }

    // 初始化
    window.onload = function() {
        createStars();
        createFloatingRunes();
    };

</script>
</body>
</html>
