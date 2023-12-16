# Remindme App

This app is mainly run in Docker using Laravel Sail.
Why I choose Sail?
- Official package and full support by Laravel.
- Easy to set up, fully customizable and adjustable.
- Save a lot of time.

## Installation
### Using Docker

If you have PHP and Composer installed on your machine, simply run:
- `composer install`
- `./vendor/bin/sail up`

If you don't have php and composer in your machine, simply run this docker container command:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
This command uses a small Docker container containing PHP and Composer to install the application's dependencies.
After that you can run any php artisan command with Sail.
