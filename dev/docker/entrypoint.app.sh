#!/bin/bash

set -e

env

if [[ -n "$1" ]]; then
    exec "$@"
else
    composer install
    wait-for-it db:3306 -t 45
    php artisan migrate --database=mysql
    php artisan db:seed
    php artisan moneypenny:create-users-settings
    php artisan moneypenny:create-users-personal-accounts
    chown -R www-data:www-data storage
    exec apache2-foreground
fi
