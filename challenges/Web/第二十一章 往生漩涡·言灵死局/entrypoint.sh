#!/bin/sh

echo "$FLAG" > /flag

unset FLAG

python /app/app.py
