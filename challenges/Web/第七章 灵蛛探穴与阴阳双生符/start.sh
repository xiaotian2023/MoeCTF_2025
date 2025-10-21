#!/bin/sh

# 启动 PHP-FPM
php-fpm -D

# 启动 Nginx（前台）
nginx -g "daemon off;"
