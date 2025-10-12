#!/bin/sh

echo "$FLAG" > "/tmp/flag.txt"
export FLAG="flag{fake_flag}"

FILE=$(which "$0")
DIR=$(dirname "$FILE")

exec /usr/local/bin/python "$DIR/main.py" "$@"