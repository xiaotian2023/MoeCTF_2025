FROM php:8.2-cli-alpine
LABEL authors="HDdss"

# 安装 bash
RUN apk add --no-cache bash

COPY index.php /app/index.php

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /app

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
