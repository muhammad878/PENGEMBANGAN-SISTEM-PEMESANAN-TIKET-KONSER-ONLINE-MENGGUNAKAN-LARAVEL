@echo off
REM Script pengisian data konser untuk KonserKUY
echo === KonserKUY Pengisian Data Konser ===
echo Script ini akan mengisi database Anda dengan data konser.
echo.

REM Periksa apakah proyek adalah proyek Laravel
if not exist "artisan" (
    echo Error: file artisan tidak ditemukan. Pastikan Anda menjalankan ini dari root proyek Laravel Anda.
    exit /b 1
)

REM Bersihkan cache terlebih dahulu
echo Membersihkan cache...
php artisan cache:clear

REM Buat direktori yang diperlukan dan gambar
echo.
echo Membuat direktori gambar...
php artisan db:seed --class=ImageDirectoriesSeeder

REM Seed kategori
echo.
echo Mengisi data kategori...
php artisan db:seed --class=CategorySeeder

REM Seed konser
echo.
echo Mengisi data konser...
php artisan db:seed --class=EventSeeder

REM Seed tiket
echo.
echo Mengisi data tiket...
php artisan db:seed --class=TicketSeeder

echo.
echo === Pengisian data konser selesai! ===
echo Anda sekarang dapat menjelajahi konser di website Anda.
echo Untuk melihat data konser, jalankan: php artisan konser:view
echo. 