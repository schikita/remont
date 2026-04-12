#!/bin/sh
set -e

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force --no-interaction
fi

php artisan migrate --force --no-interaction
php artisan storage:link --force --no-interaction 2>/dev/null || true

php-fpm -D
exec nginx -g 'daemon off;'
