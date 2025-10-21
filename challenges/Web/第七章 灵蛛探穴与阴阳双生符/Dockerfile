FROM php:8.0-fpm-alpine
LABEL authors="HDdss"
# 安装 nginx
RUN apk add --no-cache nginx

# 创建目录
RUN mkdir -p /run/nginx /var/www/html

# 拷贝文件
COPY nginx.conf /etc/nginx/nginx.conf
COPY index.html robots.txt flag.php /var/www/html/
COPY default.conf /etc/nginx/conf.d/default.conf
COPY start.sh /start.sh

# 设置权限
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]