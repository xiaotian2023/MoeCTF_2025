#!/bin/bash

# 将环境变量中的FLAG写入文件（如果使用动态flag）
echo $FLAG > /flag.txt
chmod 644 /flag.txt

# 确保Apache有读取权限
chown www-data:www-data /flag.txt

# 启动Apache
exec apache2-foreground