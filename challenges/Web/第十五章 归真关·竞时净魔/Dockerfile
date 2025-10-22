FROM php:8.2-apache

# 安装依赖
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd mysqli pdo pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 启用Apache重写模块
RUN a2enmod rewrite

# 设置工作目录
WORKDIR /var/www/html

# 复制配置文件
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf

# 复制网页文件
COPY web/ /var/www/html/

# 创建上传目录并设置权限
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads && \
    chmod -R 755 /var/www/html/uploads

# 添加启动脚本并设置权限
COPY web/start.sh /start.sh
RUN chmod +x /start.sh

# 暴露端口
EXPOSE 80

# 使用自定义启动脚本
CMD ["/start.sh"]