<?php
// 获取文件路径参数
$target = isset($_GET['file']) ? $_GET['file'] : '';
$now_target = './user/' . $target;
// 检查请求的文件是否存在
$file_exists = file_exists($now_target);
$is_file = is_file($now_target);
$is_dir = is_dir($now_target);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金曦玄轨·破界之眼 - 玄天剑宗秘宝</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --gold-primary: #d4af37;
            --gold-secondary: #f9e076;
            --gold-tertiary: #b8860b;
            --deep-blue: #0a192f;
            --dark-bg: #0d1b2a;
            --scrollbar: #2c3e50;
            --text-light: #e0e1dd;
            --text-gold: #ffd700;
            --danger: #e63946;
            --success: #2a9d8f;
            --folder-color: #4ec9b0;
            --file-color: #64b5f6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1b263b 100%);
            color: var(--text-light);
            font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23d4af37' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.2;
            z-index: -1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(13, 27, 42, 0.85);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(212, 175, 55, 0.3);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        .header {
            background: linear-gradient(90deg, var(--deep-blue) 0%, rgba(10, 25, 47, 0.8) 100%);
            padding: 25px 30px;
            border-bottom: 2px solid var(--gold-primary);
            position: relative;
            overflow: hidden;
        }
        
        .title-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .title-icon {
            font-size: 2.5rem;
            color: var(--gold-secondary);
            background: rgba(0, 0, 0, 0.3);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--gold-primary);
        }
        
        .title-text {
            font-size: 2.2rem;
            background: linear-gradient(to right, var(--gold-secondary), var(--gold-primary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
            letter-spacing: 1px;
        }
        
        .title-subtext {
            margin-top: 8px;
            font-size: 1.1rem;
            color: rgba(224, 225, 221, 0.7);
            max-width: 800px;
            line-height: 1.7;
        }
        
        .content {
            padding: 30px;
        }
        
        .form-container {
            background: rgba(26, 39, 59, 0.6);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .form-title {
            font-size: 1.4rem;
            color: var(--gold-secondary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-title i {
            color: var(--gold-primary);
        }
        
        .form-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .path-label {
            font-size: 1.1rem;
            color: var(--text-light);
            white-space: nowrap;
        }
        
        .path-input {
            flex: 1;
            min-width: 300px;
            padding: 14px 18px;
            background: rgba(10, 25, 47, 0.7);
            border: 1px solid rgba(212, 175, 55, 0.4);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.1);
        }
        
        .path-input:focus {
            outline: none;
            border-color: var(--gold-primary);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--gold-tertiary), var(--gold-primary));
            color: var(--deep-blue);
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
        }
        
        .submit-btn:active {
            transform: translateY(1px);
        }
        
        .result-container {
            margin-top: 20px;
        }
        
        .result-title {
            font-size: 1.3rem;
            color: var(--gold-secondary);
            margin: 25px 0 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        .file-table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(15, 30, 46, 0.7);
        }
        
        .file-table th {
            background: linear-gradient(to right, rgba(10, 25, 47, 0.9), rgba(26, 39, 59, 0.9));
            color: var(--gold-secondary);
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid var(--gold-primary);
        }
        
        .file-table td {
            padding: 12px 20px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .file-table tr:hover {
            background: rgba(212, 175, 55, 0.1);
        }
        
        .file-table tr:last-child td {
            border-bottom: none;
        }
        
        .folder-cell {
            color: var(--folder-color);
            cursor: pointer;
        }
        
        .folder-cell:hover {
            text-decoration: underline;
            color: var(--gold-secondary);
        }
        
        .folder-cell i {
            margin-right: 8px;
        }
        
        .file-cell {
            color: var(--file-color);
            cursor: pointer;
        }
        
        .file-cell:hover {
            color: var(--gold-secondary);
        }
        
        .file-cell i {
            margin-right: 8px;
        }
        
        .file-content {
            background: rgba(15, 30, 46, 0.7);
            border-radius: 8px;
            padding: 25px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-break: break-all;
            line-height: 1.8;
            max-height: 500px;
            overflow-y: auto;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.4);
            color: #a9b7c6;
        }
        
        .file-content h3 {
            color: var(--gold-secondary);
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 10px;
        }
        
        .file-content h4 {
            color: var(--folder-color);
            margin: 15px 0 10px;
        }
        
        .error-message {
            background: rgba(230, 57, 70, 0.15);
            border: 1px solid var(--danger);
            border-radius: 8px;
            padding: 20px;
            color: #ff6b6b;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .current-path {
            background: rgba(26, 39, 59, 0.6);
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
            font-family: monospace;
            color: var(--gold-secondary);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .footer {
            text-align: center;
            padding: 25px;
            color: rgba(224, 225, 221, 0.6);
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            font-size: 0.9rem;
        }
        
        .footer a {
            color: var(--gold-secondary);
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(15, 30, 46, 0.5);
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-container, .result-container {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(212, 175, 55, 0); }
            100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        /* 响应式设计 */
        @media (max-width: 768px) {
            .header {
                padding: 20px;
            }
            
            .title-container {
                flex-direction: column;
                text-align: center;
            }
            
            .title-icon {
                margin-bottom: 15px;
            }
            
            .form-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .path-input {
                min-width: 100%;
            }
            
            .file-table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title-container">
                <div class="title-icon">
                    <i class="fas fa-dragon"></i>
                </div>
                <div>
                    <h1 class="title-text">金曦玄轨·破界之眼</h1>
                    <p class="title-subtext">以金曦玄轨之力窥探天地本源，破除万法禁制。此乃天衍秘术与金曦破禁术结合之无上法器，可洞悉信标迷宫，溯源归墟之径。</p>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="form-container">
                <h2 class="form-title"><i class="fas fa-search"></i> 玄轨探查</h2>
                <form method="GET">
                    <div class="form-group">
                        <label class="path-label">信标路径：</label>
                        <input type="text" name="file" class="path-input" value="<?php echo htmlspecialchars($target); ?>" placeholder="输入信标路径或玉简名称..." id="pathInput">
                        <button type="submit" class="submit-btn pulse">
                            <i class="fas fa-eye"></i> 窥探本源
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="result-container">
                <?php if ($file_exists): ?>
                    <?php if ($is_dir): ?>
                        <div class="current-path">
                            <i class="fas fa-folder-open"></i> 当前路径: <?php echo htmlspecialchars($target); ?>
                        </div>
                        
                        <h3 class="result-title"><i class="fas fa-folder-open"></i> 信标空间</h3>
                        
                        <div class="table-container">
                            <table class="file-table">
                                <thead>
                                    <tr>
                                        <th>玉简名称</th>
                                        <th>玄轨类型</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 上级目录链接 -->
                                    <?php if ($target !== './' && $target !== '/' && $target !== ''): ?>
                                        <tr>
                                            <td class="folder-cell" onclick="navigateTo('<?php echo dirname($target) === '.' ? './' : dirname($target); ?>')">
                                                <i class="fas fa-level-up-alt"></i> ..
                                            </td>
                                            <td>上级信标库</td>
                                        </tr>
                                    <?php endif; ?>

                                    <!-- 实际文件系统中的内容 -->
                                    <?php
                                    $entries = scandir($now_target);
                                    foreach ($entries as $entry):
                                        if ($entry === '.' || $entry === '..') continue;
                                        $fullPath = rtrim($target, '/') . 'index.php/' . $entry;
                                        $judgePath = rtrim($now_target, '/') . 'index.php/' . $entry;
                                        if (is_dir($judgePath)):
                                    ?>
                                        <tr>
                                            <td class="folder-cell" onclick="navigateTo('<?php echo htmlspecialchars($fullPath); ?>')">
                                                <i class="fas fa-folder"></i> <?php echo htmlspecialchars($entry); ?>
                                            </td>
                                            <td>信标之库</td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td class="file-cell" onclick="viewFile('<?php echo htmlspecialchars($fullPath); ?>')">
                                                <i class="fas fa-file"></i> <?php echo htmlspecialchars($entry); ?>
                                            </td>
                                            <td>玄轨玉简</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif ($is_file): ?>
                        <div class="current-path">
                            <i class="fas fa-file"></i> 当前玉简: <?php echo htmlspecialchars($target); ?>
                        </div>
                        
                        <h3 class="result-title"><i class="fas fa-file-code"></i> 玉简内容</h3>

                        <?php
                        $filename = basename($now_target);
                        $content = file_get_contents($now_target);
                        ?>

                        <pre class="file-content"><?php echo htmlspecialchars($content); ?></pre>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>玄轨断裂！</strong> 指定的信标路径不存在或无法解析。请检查路径是否正确，或尝试其他信标。
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="footer">
            <p>玄天剑宗 · 织云阁 · 金曦破禁术传承 | 当前使用者：HDdss</p>
            <p>金曦玄轨乃宗门秘传，擅用者需持长老令牌。泄露宗门秘法者，废去修为，打入寒铁矿洞！</p>
        </div>
    </div>

    <script>
        // 添加交互功能
        document.addEventListener('DOMContentLoaded', function() {
            const pathInput = document.getElementById('pathInput');
            const submitBtn = document.querySelector('.submit-btn');
            
            // 按钮点击效果
            submitBtn.addEventListener('click', function() {
                this.classList.remove('pulse');
                void this.offsetWidth;
                this.classList.add('pulse');
            });
            
            // 输入框提示
            pathInput.addEventListener('focus', function() {
                this.style.boxShadow = '0 0 15px rgba(212, 175, 55, 0.3)';
            });
            
            pathInput.addEventListener('blur', function() {
                this.style.boxShadow = '0 0 10px rgba(212, 175, 55, 0.1)';
            });
            
            // 随机生成玄轨路径的提示
            const pathExamples = [
                './天衍符箓_基础篇.lst',
                './周天星算_入门禁制.fld',
                './金曦玄轨感应篇.txt',
                './七绝傀儡阵_破阵要诀.md',
                './五行遁甲_防护阵图.sec'
            ];
            
            let exampleIndex = 0;
            setInterval(() => {
                pathInput.placeholder = `输入信标路径或玉简名称，如：${pathExamples[exampleIndex]}`;
                exampleIndex = (exampleIndex + 1) % pathExamples.length;
            }, 3000);
        });
        
        // 导航函数
        function navigateTo(path) {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'file';
            input.value = path;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
        
        // 查看文件函数
        function viewFile(filePath) {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'file';
            input.value = filePath;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>