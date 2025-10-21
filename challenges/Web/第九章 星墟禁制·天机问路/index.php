<?php
$output = "";
if (isset($_GET['url'])) {
    $domain = $_GET['url'];
    ob_start();
    system("nslookup " . $domain);
    $output = ob_get_clean();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>星域真名推演阵</title>
    <style>
        /* 基础样式重置 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "楷体", "STKaiti", serif;
            background-color: #0b1e3d; /* 深蓝色背景 */
            color: #e0c070;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;

            /* 保留星空点阵效果 */
            background-image:
                    radial-gradient(white, rgba(255,255,255,.2) 1px, transparent 1px),
                    radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 1px),
                    radial-gradient(white, rgba(255,255,255,.1) 1px, transparent 1px);
            background-size: 550px 550px, 350px 350px, 250px 250px;
            background-position: 0 0, 40px 60px, 130px 270px;
            position: relative;
            overflow-x: hidden;
        }


        /* 星辰背景动画 */
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle var(--duration) infinite ease-in-out;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        
        /* 容器样式 */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(10, 15, 35, 0.85);
            border: 1px solid #4d7fff;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(77, 127, 255, 0.5),
                        inset 0 0 20px rgba(77, 127, 255, 0.3);
            padding: 30px;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(5px);
        }
        
        /* 古墟入口装饰 */
        .void-portal {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0,234,255,0.5) 0%, rgba(0,234,255,0) 70%);
            border-radius: 50%;
            filter: blur(20px);
            opacity: 0.4;
            z-index: -1;
            animation: portal-pulse 8s infinite ease-in-out;
        }
        
        @keyframes portal-pulse {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.1); opacity: 0.6; }
        }
        
        /* 标题区域 */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #4d7fff;
            position: relative;
        }
        
        h1 {
            font-size: 2.8em;
            color: #fff;
            text-shadow: 0 0 10px #4d7fff, 0 0 20px #4d7fff;
            letter-spacing: 5px;
            margin-bottom: 10px;
            font-weight: normal;
            position: relative;
        }
        
        h1:after {
            content: "";
            display: block;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, transparent, #4d7fff, transparent);
            margin: 15px auto;
        }
        
        .subtitle {
            font-size: 1.2em;
            color: #a8c6ff;
            font-style: italic;
            margin-top: 10px;
        }
        
        /* 星域推演阵 */
        .divination-matrix {
            background: rgba(5, 10, 25, 0.7);
            border: 1px solid #4d7fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: inset 0 0 15px rgba(77, 127, 255, 0.4),
                        0 0 10px rgba(77, 127, 255, 0.3);
        }
        
        .matrix-title {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #a8c6ff;
            position: relative;
        }
        
        .matrix-title:before,
        .matrix-title:after {
            content: "✧";
            margin: 0 15px;
            color: #4d7fff;
        }
        
        .divination-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        label {
            font-size: 1.1em;
            color: #c9d7ff;
            display: flex;
            align-items: center;
        }
        
        label:before {
            content: "✦";
            margin-right: 8px;
            color: #4d7fff;
        }
        
        .domain-input {
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid #4d7fff;
            border-radius: 8px;
            color: #fff;
            font-size: 1.1em;
            font-family: "楷体", "STKaiti", serif;
            transition: all 0.3s ease;
            box-shadow: inset 0 0 10px rgba(77, 127, 255, 0.2);
        }
        
        .domain-input:focus {
            outline: none;
            border-color: #00eaff;
            box-shadow: 0 0 15px rgba(0, 234, 255, 0.5),
                        inset 0 0 10px rgba(0, 234, 255, 0.3);
        }
        
        .divination-btn {
            padding: 12px;
            background: linear-gradient(to bottom, #4d7fff, #0a2c6e);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1.2em;
            font-family: "楷体", "STKaiti", serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(77, 127, 255, 0.5);
            position: relative;
            overflow: hidden;
        }
        
        .divination-btn:before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }
        
        .divination-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 20px rgba(77, 127, 255, 0.8);
        }
        
        .divination-btn:hover:before {
            transform: rotate(45deg) translate(50%, 50%);
        }
        
        .divination-btn:active {
            transform: translateY(1px);
        }
        
        /* 推演结果 */
        .divination-result {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid #4d7fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .result-title {
            font-size: 1.5em;
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 0 0 5px #4d7fff;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .result-title:before {
            content: "⟡";
            margin-right: 10px;
            color: #4d7fff;
        }
        
        pre {
            background: rgba(10, 20, 50, 0.5);
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            color: #e0c070;
            font-family: monospace;
            border: 1px solid #4d7fff;
            white-space: pre-wrap;
            line-height: 1.4;
            max-height: 300px;
            overflow-y: auto;
        }
        
        /* 符文装饰 */
        .rune {
            position: absolute;
            font-size: 2em;
            opacity: 0.1;
            z-index: -1;
        }
        
        /* 页脚 */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(77, 127, 255, 0.3);
            color: #8a9bb8;
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
            
            .divination-matrix {
                padding: 15px;
            }
            
            .void-portal {
                display: none;
            }
        }
    </style>
</head>
<body>
<!-- 动态星辰背景 -->
<div class="void-portal"></div>

<div class="container">
    <div class="header">
        <h1>星域真名推演阵</h1>
        <p class="subtitle">虚空星域皆有名，真名隐于天机链</p>
    </div>

    <div class="divination-matrix">
        <div class="matrix-title">天机推演阵</div>
        <form method="GET" class="divination-form">
            <div class="form-group">
                <label for="domain">请输入要推演的星域真名(url)</label>
                <input type="text" name="url" id="domain" class="domain-input" placeholder="如：www.baidu.com" required>
            </div>
            <button type="submit" class="divination-btn">推演天机</button>
        </form>

        <div class="divination-result" id="result" style="<?php echo $output ? '' : 'display:none'; ?>">
            <div class="result-title">推演结果</div>
            <pre id="result-content"><?php echo $output; ?></pre>
        </div>
    </div>

    <div class="footer">
        <p>玄天剑宗 · 葬星古墟入口禁制</p>
        <p>破解天机链者，可入墟眼护引魂玉</p>
    </div>
</div>

<script>
    // 创建星辰背景
    function createStars() {
        const container = document.body;
        const starCount = 150;

        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            const size = Math.random() * 3;
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const duration = 3 + Math.random() * 10;
            const delay = Math.random() * 5;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.left = `${posX}%`;
            star.style.top = `${posY}%`;
            star.style.setProperty('--duration', `${duration}s`);
            star.style.animationDelay = `${delay}s`;
            container.appendChild(star);
        }
    }
    createStars();
</script>
</body>
</html>