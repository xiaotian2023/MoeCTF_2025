FROM php:8.2-cli-alpine
LABEL authors="HDdss"

WORKDIR /app

COPY index.php /app/index.php
COPY flag.php /app/flag.php
COPY entrypoint.sh /usr/entrypoint.sh
COPY find.php /app/find.php

RUN chmod +x /usr/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/entrypoint.sh"]
