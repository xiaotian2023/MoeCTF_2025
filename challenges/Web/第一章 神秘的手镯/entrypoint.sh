#!/bin/sh

FLAG_VALUE="${FLAG:-flag{default_flag}}"

sed -i "s|{{FLAG}}|$FLAG_VALUE|g" /usr/share/nginx/html/shouzhuo.js

nginx -g "daemon off;"

