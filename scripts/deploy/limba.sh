#!/bin/bash

# Script for deploying moneypenny application on UJ server

cd ~/moneypenny && \
git reset --hard origin/bachelor && \
git pull origin bachelor && \
composer install && \
composer du && \
php artisan migrate && \
npm install && \
php artisan optimize:clear && \
npm run build && \
php artisan moneypenny:create-users-personal-accounts
