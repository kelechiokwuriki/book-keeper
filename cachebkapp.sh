#! /bin/bash

cd ~/Desktop/Dev/Book-keeper
docker-compose exec app php artisan config:cache
composer dumpautoload -o

