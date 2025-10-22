FROM php:5.6-apache

# 复制题目文件
COPY www/ /var/www/html/

# 复制启动脚本并设置权限
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 启动Apache
CMD ["/start.sh"]