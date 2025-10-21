FROM python:3.11-alpine
LABEL authors="HDdss"

WORKDIR /app

COPY app /app
COPY entrypoint.sh /

RUN chmod +x /entrypoint.sh

RUN pip install --no-cache-dir flask

EXPOSE 80

CMD ["/entrypoint.sh"]
