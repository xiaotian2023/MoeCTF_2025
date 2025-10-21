#!/bin/sh
set -e

author="HDdss"

sleep 2

sed "s/\${FLAG}/$FLAG/g" /docker-entrypoint-initdb.d/init.sql > /tmp/init_filled.sql

mysql -uroot -proot < /tmp/init_filled.sql