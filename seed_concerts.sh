#!/bin/bash

# Script pengisian data konser untuk KonserKUY
echo "=== KonserKUY Pengisian Data Konser ==="
echo "Script ini akan mengisi database Anda dengan data konser."
echo ""

# Periksa apakah proyek adalah proyek Laravel
if [ ! -f "artisan" ]; then
    echo "Error: file artisan tidak ditemukan. Pastikan Anda menjalankan ini dari root proyek Laravel Anda."
    exit 1
fi

# Bersihkan cache terlebih dahulu
echo "Membersihkan cache..."
php artisan cache:clear

# Buat direktori yang diperlukan dan gambar
echo ""
echo "Membuat direktori gambar..."
php artisan db:seed --class=ImageDirectoriesSeeder

# Seed kategori
echo ""
echo "Mengisi data kategori..."
php artisan db:seed --class=CategorySeeder

# Seed konser
echo ""
echo "Mengisi data konser..."
php artisan db:seed --class=EventSeeder

# Seed tiket
echo ""
echo "Mengisi data tiket..."
php artisan db:seed --class=TicketSeeder

echo ""
echo "=== Pengisian data konser selesai! ==="
echo "Anda sekarang dapat menjelajahi konser di website Anda."
echo "Untuk melihat data konser, jalankan: php artisan konser:view"
echo "" 