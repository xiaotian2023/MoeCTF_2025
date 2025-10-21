#!/bin/bash
echo $FLAG > /flag-$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | head -c 30).txt

unset FLAG

apache2-foreground