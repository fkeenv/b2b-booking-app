#!/bin/bash

cd "$(dirname "$0")/.." || exit 1
php artisan migrate:fresh
php artisan permissions:sync -P
php artisan db:seed
