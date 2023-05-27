#!/bin/bash

php artisan migrate:fresh && \
php artisan optimize:clear && \
php artisan queue:clear && \
php artisan db:seed && \
php artisan moneypenny:create-users-settings && \
php artisan moneypenny:create-users-personal-accounts
