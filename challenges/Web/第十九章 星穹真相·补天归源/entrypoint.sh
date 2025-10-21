#!/bin/sh
set -e

echo "$FLAG" > /flag
unset FLAG

php -S 0.0.0.0:80 -t /app
