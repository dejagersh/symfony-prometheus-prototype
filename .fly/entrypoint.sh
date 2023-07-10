#!/usr/bin/env sh

chown -R www-data:www-data /var/www/html

if [ $# -gt 0 ]; then
    # If we passed a command, run it as root
    exec "$@"
else
    exec supervisord -c /etc/supervisor/supervisord.conf
fi
