#!/bin/bash

cd ~/moneypenny && \
git pull origin bachelor && \
php artisan migrate && \
php artisan optimize:clear && \
npm run build && \
php artisan moneypenny:create-users-personal-accounts
