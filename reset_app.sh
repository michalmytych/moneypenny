#!/bin/zsh

docker compose restart app --remove-orphans
docker compose run --rm app php artisan optimize:clear
docker compose run --rm app composer dump-autoload
docker compose run --rm app php artisan migrate:fresh
docker compose run --rm app php artisan db:seed
