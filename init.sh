#!/bin/bash

# This script is used to initialize the environment for the project.
cp .env.example .env
cp docker-compose.yml.example docker-compose.yml
docker compose up -d

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app chmod -R 777 storage

docker compose stop
docker compose up -d
