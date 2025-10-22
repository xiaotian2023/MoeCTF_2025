FROM nginx:alpine

SHELL ["/bin/sh", "-c"]

COPY html/ /usr/share/nginx/html/
COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
