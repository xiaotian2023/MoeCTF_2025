<?php
// 引魂玉御神关上传处理
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
    <title>御神关结果</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="void-portal"></div>
    <div class="container">
        <div class="result-container $themeClass">
            <div class="result-title">$title</div>
            <pre>$content</pre>
            <div class="footer">
                <a href="index.php">返回玉碑修复</a>
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
    $forbiddenExtensions = [
        '.php','.php5','.php4','.php3','.php2','.php1',
        '.html','.htm','.phtml','.pht','.pHp','.pHp5',
        '.pHp4','.pHp3','.pHp2','.pHp1','.Html','.Htm',
        '.pHtml','.jsp','.jspa','.jspx','.jsw','.jsv',
        '.jspf','.jtml','.jSp','.jSpx','.jSpa','.jSw',
        '.jSv','.jSpf','.jHtml','.asp','.aspx','.asa',
        '.asax','.ascx','.ashx','.asmx','.cer','.aSp',
        '.aSpx','.aSa','.aSax','.aScx','.aShx','.aSmx',
        '.cEr','.sWf','.swf','.ini'
    ];
    
    if (isset($_FILES['jadeStele'])) {
        $file = $_FILES['jadeStele'];
        $fileName = basename($file['name']);
        $fileExt = strtolower(strrchr($fileName, '.'));
        $targetPath = $uploadDir . $fileName;
        
        // 校验文件大小
        if ($file['size'] > $maxSize) {
            echo renderResultPage(
                "九幽雷劫！", 
                "玉碑不得大于三寸（30000字节）！\n检测到尺寸：{$file['size']}字节"
            );
            exit;
        }
        
        // 校验扩展名
        if (in_array($fileExt, $forbiddenExtensions)) {
            $detected = $fileExt;
            echo renderResultPage(
                "九幽雷劫！", 
                "禁止上传攻伐符咒！\n检测到危险扩展名：$detected"
            );
            exit;
        }
        
        // 保存文件
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $resultContent = "玉碑碎片上传成功！守护大阵正在解析...\n\n";
            $resultContent .= "玉碑已存储于阵枢空间：/uploads/$fileName";
            
            echo renderResultPage(
                "玉碑已接收", 
                $resultContent,
                true
            );
        } else {
            echo renderResultPage(
                "空间震荡", 
                "玉碑上传失败！空间能量不稳定！"
            );
        }
    } else {
        echo renderResultPage(
            "玉碑缺失", 
            "未检测到玉碑碎片！请返回重新选择"
        );
    }
} else {
    header('Location: index.php');
    exit;
}
?>