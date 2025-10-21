#!/bin/sh
set -e

echo "$FLAG" > /flag

php -S 0.0.0.0:80 -t /app
