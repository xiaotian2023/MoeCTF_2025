#!/bin/bash
echo $FLAG > /flag.txt
chmod 644 /flag.txt
exec apache2-foreground