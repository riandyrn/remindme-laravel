#!/bin/sh

cd /var/www

# composer install --optimize-autoloader --no-dev

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

/usr/bin/supervisord -c /etc/supervisord.conf