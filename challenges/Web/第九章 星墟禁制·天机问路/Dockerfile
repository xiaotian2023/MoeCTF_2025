FROM php:8.2-cli-alpine
LABEL authors="HDdss"

# 安装 nslookup 工具
RUN apk add --no-cache bind-tools

WORKDIR /app

COPY index.php /app/index.php

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app"]
