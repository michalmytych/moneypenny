#!/bin/bash

cd ~/moneypenny && \
git pull origin bachelor && \
composer install && \
composer du && \
php artisan migrate && \
php artisan optimize:clear && \
npm install && \
npm run build && \
php artisan moneypenny:create-users-personal-accounts
