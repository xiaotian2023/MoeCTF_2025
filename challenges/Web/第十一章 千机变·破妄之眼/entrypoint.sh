#!/bin/sh
set -e

sed -i "s/{{FLAG}}/$FLAG/" /app/flag.php

php -S 0.0.0.0:80 -t /app
