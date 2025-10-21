FROM python:3.11-slim
LABEL authors="HDdss"

WORKDIR /app

COPY app /app
COPY entrypoint.sh /entrypoint.sh
COPY rev.c /usr/bin/rev.c

RUN apt-get update \
    && apt-get install gcc sudo bash xxd bsdmainutils -y \
    && gcc /usr/bin/rev.c -o /usr/bin/rev

RUN chmod 700 /entrypoint.sh

RUN pip install --no-cache-dir flask

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
