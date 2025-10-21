#!/bin/sh

echo "$FLAG" > /flag
unset FLAG

chmod 600 /flag
chown root:root /flag

chmod 4755 /usr/bin/rev

useradd -m MoeCTFer
chmod -R 777 /app
su MoeCTFer -c "python /app/app.py"