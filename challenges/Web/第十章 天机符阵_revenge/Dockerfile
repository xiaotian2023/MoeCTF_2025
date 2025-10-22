# 使用官方PHP镜像
FROM php:8.2-apache

# 设置工作目录
WORKDIR /var/www/html

# 安装必要的扩展
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 启用Apache重写模块
RUN a2enmod rewrite

# 复制public目录内容到web根目录
COPY public/ /var/www/html/

# 修改PHP配置以允许外部实体加载
RUN echo "allow_url_fopen = On" >> /usr/local/etc/php/conf.d/xxe.ini && \
    echo "allow_url_include = On" >> /usr/local/etc/php/conf.d/xxe.ini && \
    echo "libxml_disable_entity_loader = Off" >> /usr/local/etc/php/conf.d/xxe.ini

# 设置Apache配置
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 设置正确的文件权限
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# 暴露端口
EXPOSE 80

# 复制启动脚本并设置执行权限
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 确保/flag.txt的父目录存在且可写
RUN mkdir -p / && chown www-data:www-data / && chmod 755 /

# 启动Apache
CMD ["/start.sh"]