<?php
highlight_file(__FILE__);
if(isset($_GET['shell'])){
    $shell = $_GET['shell'];
    if(strlen($shell)>35){
        die("Too L0o0o0o0o0o0ong!!!");
    }
    if(preg_match("/[A-Za-z0-9_$]+/",$shell)){
        die("HhHhHhHhHacker!!!");
    }
    eval($shell);
}
?>