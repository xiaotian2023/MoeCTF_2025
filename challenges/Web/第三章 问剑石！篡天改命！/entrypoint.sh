#!/bin/bash

# 从环境变量获取 FLAG，如果没有设置则使用默认值
FLAG=${FLAG:-"flag{default_flag_here}"}

# 使用 sed 替换 app.py 中的占位符
sed -i "s|FLAG_PLACEHOLDER|${FLAG}|g" app.py

# 执行 CMD 中的命令
exec "$@"