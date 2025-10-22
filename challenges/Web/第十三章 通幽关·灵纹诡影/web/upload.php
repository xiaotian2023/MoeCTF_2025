<?php
// 引魂玉通幽关上传处理
header('Content-Type: text/html; charset=utf-8');

// 修仙主题结果页面模板
function renderResultPage($title, $content, $isSuccess = false) {
    $themeClass = $isSuccess ? 'success' : 'error';
    return <<<HTML
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通幽关结果</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="void-portal"></div>
    <div class="container">
        <div class="result-container $themeClass">
            <div class="result-title">$title</div>
            <pre>$content</pre>
            <div class="footer">
                <a href="index.php">返回灵纹上传</a>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
}

// 主处理逻辑
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $maxSize = 30000;
    $magicHeader = "\xFF\xD8\xFF"; // 魔印校验码
    
    if (isset($_FILES['spiritPattern'])) {
        $file = $_FILES['spiritPattern'];
        $fileName = basename($file['name']);
        $targetPath = $uploadDir . $fileName; // 保留原始文件名
        
        // 校验文件大小
        if ($file['size'] > $maxSize) {
            echo renderResultPage(
                "九幽雷劫！", 
                "灵纹不得大于三寸（30000字节）！\n检测到尺寸：{$file['size']}字节"
            );
            exit;
        }
        
        // 校验魔印（文件头）
        $handle = fopen($file['tmp_name'], 'rb');
        $header = fread($handle, 3);
        fclose($handle);
        
        if ($header !== $magicHeader) {
            $detected = bin2hex($header);
            echo renderResultPage(
                "九幽雷劫！", 
                "噬心魔印校验失败！\n预期魔印：ffd8ff\n检测到魔印：$detected"
            );
            exit;
        }
        
        // 保存文件
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $resultContent = "灵纹上传成功！玉魄核心正在解析...\n\n";
            $resultContent .= "灵纹已存储于玉魄空间：/uploads/$fileName";
            
            echo renderResultPage(
                "灵纹已接收", 
                $resultContent,
                true
            );
        } else {
            echo renderResultPage(
                "空间震荡", 
                "灵纹上传失败！空间能量不稳定！"
            );
        }
    } else {
        echo renderResultPage(
            "灵纹缺失", 
            "未检测到灵纹图！请返回重新选择"
        );
    }
} else {
    header('Location: index.php');
    exit;
}
?>