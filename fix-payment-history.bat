@echo off
echo [KonserKUY] Fixing Payment History Issues...
echo ================================================
echo This script clears all Laravel cache types to fix
echo common issues with the payment and ticket system.
echo This is especially useful if you're experiencing:
echo - Blank or error pages when viewing tickets
echo - Outdated ticket status information
echo - Payment history not appearing correctly
echo - 404 errors on ticket-related pages
echo ================================================
echo.

echo [1/5] Clearing view cache...
php artisan view:clear

echo [2/5] Clearing route cache...
php artisan route:clear

echo [3/5] Clearing application cache...
php artisan cache:clear

echo [4/5] Clearing configuration cache...
php artisan config:clear

echo [5/5] Optimizing application...
php artisan optimize:clear

echo.
echo ==============================================
echo Payment History Fix Complete!
echo.
echo The system will now correctly display:
echo - Your ticket history
echo - Payment records
echo - Updated ticket statuses
echo.
echo If you're still having issues, please contact
echo the development team for further assistance.
echo ==============================================
echo.

pause 