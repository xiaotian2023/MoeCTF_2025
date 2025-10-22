<?php
// chapter10.php - 天机符阵后端处理器

// 设置响应头
header('Content-Type: text/plain; charset=utf-8');


// 检查是否收到天机符
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contract'])) {
    $xml = $_POST['contract'];
    
    // 创建DOM文档
    $dom = new DOMDocument();
    
    try {
        // 设置解析选项
        $dom->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
        
        // 尝试解析契约内容
        $契约 = $dom->getElementsByTagName('契约')->item(0);
        $解析 = $dom->getElementsByTagName('解析')->item(0);
        $输出 = $dom->getElementsByTagName('输出')->item(0);
        
        // 构建响应
        $response = "<阵枢>引魂玉</阵枢>\n";
        $response .= "<解析>" . ($解析 ? htmlspecialchars($解析->nodeValue) : '未定义') . "</解析>\n";
        $response .= "<输出>" . ($输出 ? htmlspecialchars($输出->nodeValue) : '未定义') . "</输出>\n";
        
        // 检查契约内容
        if ($契约) {
            $response .= "\n<契约内容>\n";
            
            // 检查CDATA部分
            $cdata = $契约->getElementsByTagName('CDATA')->item(0);
            if ($cdata) {
                $response .= htmlspecialchars($cdata->nodeValue);
            } else {
                $response .= htmlspecialchars($契约->nodeValue);
            }
            
            $response .= "\n</契约内容>\n";
        }
        
        // 输出响应
        echo $response;
    } catch (Exception $e) {
        echo "天机符解析失败：契约格式错误\n";
        echo "错误详情：" . htmlspecialchars($e->getMessage());
    }
} else {
    // 显示初始状态
    echo "天机符阵待激活...\n";
    echo "请通过符阵界面提交天机契约\n";
}
?>