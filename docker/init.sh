#!/bin/sh

#php artisan migrate:fresh
#composer install --optimize-autoloader --no-dev --ignore-platform-req=ext-sockets
##php artisan serve --port=80
#supervisord -c /etc/supervisor/conf.d/supervisord.conf

cd /var/www

php artisan migrate:fresh
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
