#!/bin/bash
cd `dirname $0`

# permission
chmod -R 777 ./storage
chmod -R 777 ./bootstrap/cache

# composer install
composer install

# env
cp .env.dev .env
php artisan key:generate

# db migration
php artisan migrate

# npm
source ~/.nvm/nvm.sh
npm install
npm run dev
