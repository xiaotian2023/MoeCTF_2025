# 使用官方PHP镜像
FROM php:8.2-apache

# 设置工作目录
WORKDIR /var/www/html

# 安装必要的扩展
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 启用Apache重写模块
RUN a2enmod rewrite

# 复制应用程序文件
COPY public/ /var/www/html/
COPY config/flag.txt /var/www/html/flag.txt

# 设置文件权限
RUN chown -R www-data:www-data /var/www/html
RUN chmod 644 /var/www/html/flag.txt

# 设置Apache配置
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 暴露端口
EXPOSE 80

# 启动Apache
CMD ["apache2-foreground"]