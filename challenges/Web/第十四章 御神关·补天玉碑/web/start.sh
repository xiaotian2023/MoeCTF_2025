#!/bin/bash

# 将环境变量FLAG写入/flag.txt
echo $FLAG > /flag.txt
chmod 644 /flag.txt

# 启动Apache
exec apache2-foreground