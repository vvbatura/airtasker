#!/bin/sh

ESC_SEQ="\033["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_GREEN=$ESC_SEQ"32;01m"
CELL_LINE="========================================="
CELL_BEGIN="\n$COL_MAGENTA $CELL_LINE \n"
CELL_DONE_BEGIN="\n$COL_GREEN $CELL_LINE \n"
CELL_END="\n $CELL_LINE $COL_RESET \n"

echo "$CELL_BEGIN ============= Pull master ============== $CELL_END"
git remote add origin https://github.com/vvbatura/airtasker.git
git pull origin master

echo "$CELL_BEGIN =========== Composer install ============ $CELL_END"
composer install

echo "$CELL_BEGIN =========== Install/update composer dependecies ============ $CELL_END"
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "$CELL_BEGIN =========== Create .env ============ $CELL_END"
cp .env.host .env

echo "$CELL_BEGIN =========== Generate JWT ============ $CELL_END"
php artisan jwt:secret

echo "$CELL_BEGIN =========== Run database migrations ============ $CELL_END"
php artisan migrate --seed

echo "$CELL_BEGIN =========== Create symbolic link for storage  ============ $CELL_END"
php artisan storage:link

echo "$CELL_BEGIN =========== Clear and cache routes ============ $CELL_END"
php artisan clear-compiled
php artisan route:clear
php artisan route:cache
php artisan cache:clear

echo "$CELL_BEGIN =========== Clear and cache config ============ $CELL_END"
php artisan config:clear
php artisan config:cache

echo "$CELL_DONE_BEGIN ================= DONE ================== $CELL_END"
