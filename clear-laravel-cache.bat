@echo off
echo Clearing Laravel application caches...

php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear

echo Cache cleared successfully!
pause 