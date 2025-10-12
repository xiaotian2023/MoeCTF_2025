#!/bin/sh

echo "$FLAG" > "/tmp/therealflag_$(echo $FLAG | sha3sum -a 512 | head -c 32)"
export FLAG="flag{kirakira_dokidoki}"

FILE=$(which "$0")
DIR=$(dirname "$FILE")

exec /usr/local/bin/python "$DIR/main.py" "$@"