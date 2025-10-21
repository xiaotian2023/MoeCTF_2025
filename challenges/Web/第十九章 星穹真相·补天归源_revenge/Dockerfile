FROM php:8.2-cli-alpine
LABEL authors="HDdss"

# 安装 bash
RUN apk add --no-cache bash

COPY index.php /app/index.php

WORKDIR /app

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app"]
