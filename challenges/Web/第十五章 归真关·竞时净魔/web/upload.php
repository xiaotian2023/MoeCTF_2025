<?php
define('UPLOAD_PATH', '/var/www/html/uploads');

$is_upload = false;
$msg = null;

if(isset($_POST['submit'])){
    $ext_arr = array('jpg','png','gif');
    $file_name = $_FILES['upload_file']['name'];
    $temp_file = $_FILES['upload_file']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_file = UPLOAD_PATH . '/' . $file_name;

    if(move_uploaded_file($temp_file, $upload_file)){
        if(in_array($file_ext, $ext_arr)){
             $img_path = UPLOAD_PATH . '/'. rand(10, 99).date("YmdHis").".".$file_ext;
             rename($upload_file, $img_path);
             $is_upload = true;
             $msg = "净化符文上传成功！";
        }else{
            $msg = "只允许上传.jpg|.png|.gif类型文件！";
            unlink($upload_file);
        }
    }else{
        $msg = '上传出错！';
    }
}

// 重定向回首页显示结果
$redirect_url = "index.php?upload_result=" . ($is_upload ? 'success' : 'error');
if($msg) {
    $redirect_url .= "&message=" . urlencode($msg);
}
header("Location: " . $redirect_url);
exit;
?>