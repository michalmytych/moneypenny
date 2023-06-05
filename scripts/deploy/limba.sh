#!/bin/bash

# Script for deploying moneypenny application on UJ server

cd ~/moneypenny && \
git reset --hard origin/bachelor && \
git pull origin bachelor && \
composer install && \
composer du && \
php artisan migrate && \
npm install && \
npm run build && \
php artisan moneypenny:create-users-personal-accounts && \
php artisan optimize:clear
