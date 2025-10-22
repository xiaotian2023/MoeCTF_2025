<?php
define('UPLOAD_PATH', '/var/www/html/uploads');

// 初始化变量
$is_upload = false;
$msg = null;

// 如果是上传后的重定向，显示结果
if(isset($_GET['upload_result'])) {
    $is_upload = $_GET['upload_result'] === 'success';
    $msg = isset($_GET['message']) ? urldecode($_GET['message']) : null;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>引魂玉·归真关 - 竞时净魔</title>
    <style>
        /* 完全保留原有的CSS样式 */
        :root {
            --jade-light: #a8e6cf;
            --jade-dark: #0a5c36;
            --spirit-blue: #5d93c5;
            --soul-purple: #8a2be2;
            --dark-abyss: #0a0e2a;
            --golden-path: #e0c070;
        }
        
        body {
            background: linear-gradient(135deg, var(--dark-abyss), #1a1f4b, #2c1b4e);
            color: var(--golden-path);
            font-family: "楷体", "STKaiti", serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-image: 
                radial-gradient(rgba(168, 230, 207, 0.1) 1px, transparent 1px),
                radial-gradient(rgba(168, 230, 207, 0.15) 1px, transparent 1px);
            background-size: 50px 50px, 80px 80px;
            background-position: 0 0, 25px 25px;
            position: relative;
            overflow-x: hidden;
        }
        
        .void-portal {
            position: fixed;
            top: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(93, 147, 197, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(30px);
            opacity: 0.4;
            z-index: -1;
            animation: portal-pulse 12s infinite ease-in-out;
        }
        
        @keyframes portal-pulse {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.1); opacity: 0.6; }
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(10, 15, 35, 0.85);
            border: 2px solid var(--spirit-blue);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(93, 147, 197, 0.5),
                        inset 0 0 20px rgba(93, 147, 197, 0.3);
            padding: 30px;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(5px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--spirit-blue);
            position: relative;
        }
        
        h1 {
            font-size: 2.8em;
            color: var(--jade-light);
            text-shadow: 0 0 10px var(--spirit-blue), 0 0 20px var(--spirit-blue);
            letter-spacing: 5px;
            margin-bottom: 10px;
            font-weight: normal;
        }
        
        h1:after {
            content: "";
            display: block;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, transparent, var(--spirit-blue), transparent);
            margin: 15px auto;
        }
        
        .subtitle {
            font-size: 1.2em;
            color: #a8c6ff;
            font-style: italic;
            margin-top: 10px;
        }
        
        .challenge-container {
            background: rgba(5, 10, 25, 0.7);
            border: 1px solid var(--spirit-blue);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: inset 0 0 15px rgba(93, 147, 197, 0.4),
                        0 0 10px rgba(93, 147, 197, 0.3);
        }
        
        .challenge-title {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #a8c6ff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .challenge-title:before,
        .challenge-title:after {
            content: "❖";
            margin: 0 15px;
            color: var(--spirit-blue);
        }
        
        .rules {
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--jade-dark);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .rules h3 {
            color: var(--jade-light);
            display: flex;
            align-items: center;
            margin-top: 0;
        }
        
        .rules h3:before {
            content: "⚠";
            margin-right: 10px;
            color: #ff6b6b;
        }
        
        .rules ul {
            padding-left: 20px;
        }
        
        .rules li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }
        
        .rules li:before {
            content: "•";
            color: var(--spirit-blue);
            position: absolute;
            left: 0;
            font-size: 1.5em;
            top: -5px;
        }
        
        .upload-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 30px 0;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        label {
            font-size: 1.1em;
            color: #c9d7ff;
            display: flex;
            align-items: center;
        }
        
        label:before {
            content: "✧";
            margin-right: 8px;
            color: var(--spirit-blue);
        }
        
        .file-input {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--spirit-blue);
            border-radius: 8px;
            color: #fff;
            font-size: 1.1em;
            font-family: "楷体", "STKaiti", serif;
            flex-grow: 1;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: inset 0 0 10px rgba(93, 147, 197, 0.2);
        }
        
        .file-input-label:hover {
            border-color: var(--jade-light);
            box-shadow: 0 0 15px rgba(168, 230, 207, 0.5),
                        inset 0 0 10px rgba(168, 230, 207, 0.3);
        }
        
        .file-name {
            margin-left: 10px;
            color: #aaa;
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .upload-btn {
            padding: 12px;
            background: linear-gradient(to bottom, var(--spirit-blue), #0a2c6e);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1.2em;
            font-family: "楷体", "STKaiti", serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(93, 147, 197, 0.5);
            position: relative;
            overflow: hidden;
        }
        
        .upload-btn:before {
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
        
        .upload-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 20px rgba(93, 147, 197, 0.8);
        }
        
        .upload-btn:hover:before {
            transform: rotate(45deg) translate(50%, 50%);
        }
        
        .result-container {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid var(--spirit-blue);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .result-title {
            font-size: 1.5em;
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 0 0 5px var(--spirit-blue);
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .result-title:before {
            content: "⟡";
            margin-right: 10px;
            color: var(--spirit-blue);
        }
        
        pre {
            background: rgba(10, 20, 50, 0.5);
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            color: var(--golden-path);
            font-family: monospace;
            border: 1px solid var(--spirit-blue);
            white-space: pre-wrap;
            line-height: 1.4;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .success {
            color: #a8e6cf;
            border-color: #0a5c36;
        }
        
        .error {
            color: #ff6b6b;
            border-color: #8b0000;
        }
        
        .rune {
            position: absolute;
            font-size: 2em;
            opacity: 0.1;
            z-index: -1;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(93, 147, 197, 0.3);
            color: #8a9bb8;
            font-size: 0.9em;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .challenge-container {
                padding: 15px;
            }
            
            .void-portal {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="void-portal"></div>
    
    <div class="container">
        <div class="header">
            <h1>引魂玉·归真关</h1>
            <p class="subtitle">竞时净魔，与魔气赛跑</p>
        </div>
        
        <div class="challenge-container">
            <div class="challenge-title">净化符文上传</div>
            
            <div class="rules">
                <h3>归真关规则</h3>
                <ul>
                    <li>仅受天道认可的<span class="highlight">「净化符文」</span>可修复玉魄（扩展名：.jpg/.png/.gif）</li>
                    <li>符文尺寸不得大于三寸（30000字节）</li>
                    <li>符文上传后将进行「重命名净化」</li>
                    <li>魔气会快速清除违规符文，请把握时机！</li>
                </ul>
            </div>
            
            <form class="upload-form" action="upload.php" method="POST" enctype="multipart/form-data" id="purifyUploadForm">
                <div class="form-group">
                    <label for="purifyRune">请选择净化符文</label>
                    <div class="file-input">
                        <input type="file" name="upload_file" id="purifyRune" required>
                        <div class="file-input-label">
                            <span>选择净化符文</span>
                            <span class="file-name" id="fileName">未选择文件</span>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="submit" value="上传" class="upload-btn">上传净化符文</button>
            </form>

            <?php if($is_upload): ?>
                <div class="result-container success">
                    <div class="result-title">净化成功</div>
                    <pre>符文已成功上传并被净化！</pre>
                </div>
            <?php elseif($msg): ?>
                <div class="result-container error">
                    <div class="result-title">净化失败</div>
                    <pre><?php echo htmlspecialchars($msg); ?></pre>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>星殒禁域 · 玄微子设</p>
            <p>破归真关者，可掌引魂玉十成威能</p>
        </div>
    </div>

    <script>
        // 文件选择显示
        const fileInput = document.getElementById('purifyRune');
        const fileNameDisplay = document.getElementById('fileName');
        
        fileInput.addEventListener('change', function() {
            fileNameDisplay.textContent = this.files.length > 0 
                ? this.files[0].name 
                : '未选择文件';
        });
    </script>
</body>
</html>