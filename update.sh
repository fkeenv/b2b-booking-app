#/bin/sh

git fetch origin
git merge
php artisan migrate
