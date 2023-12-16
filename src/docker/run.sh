#!/bin/sh

cd /var/www

composer install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

/usr/bin/supervisord -c /etc/supervisord.conf