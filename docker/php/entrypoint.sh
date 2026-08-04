#!/bin/sh
set -e

cp -a /opt/public-src/. /var/www/html/public/

[ -L /var/www/html/public/storage ] || php artisan storage:link --quiet

chown -R www-data:www-data /var/www/html/public /var/www/html/storage

exec "$@"
