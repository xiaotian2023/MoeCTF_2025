FROM php:8.2-cli-alpine
LABEL authors="HDdss"
WORKDIR /app

COPY index.php /app/index.php
COPY user /app/user
COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:80", "-t", "/app"]
