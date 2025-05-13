# KonserKUY - Data Seeder Konser

Direktori ini berisi seeder untuk mengisi database dengan data konser yang realistis, termasuk konser/acara, jenis tiket, dan kategori.

## Seeder yang Tersedia

1. **EventSeeder**: Membuat 12 konser/acara berbeda dengan berbagai genre, lokasi, dan tanggal.
2. **TicketSeeder**: Membuat berbagai jenis tiket untuk setiap konser (VIP, Gold, Silver, Regular, dll.).
3. **CategorySeeder**: Membuat 8 kategori konser (K-Pop, Pop, Rock, Jazz, dll.).
4. **ImageDirectoriesSeeder**: Membuat direktori yang diperlukan untuk gambar konser dan kategori serta menghasilkan gambar placeholder.

## Cara Menjalankan Seeder

### Opsi 1: Menggunakan Perintah Kustom (Direkomendasikan)

Kami telah membuat perintah Artisan kustom untuk mempermudah seeding:

```bash
php artisan konser:seed
```

Perintah ini akan menjalankan semua seeder terkait konser dalam urutan yang benar.

### Opsi 2: Menggunakan Database Seeder Standar

Jika Anda ingin menjalankan semua seeder termasuk pengguna dan data konser:

```bash
php artisan db:seed
```

### Opsi 3: Menjalankan Seeder Individual

Jika Anda ingin menjalankan seeder tertentu saja:

```bash
# Siapkan direktori dan gambar placeholder terlebih dahulu
php artisan db:seed --class=ImageDirectoriesSeeder

# Seed data kategori
php artisan db:seed --class=CategorySeeder

# Seed data konser
php artisan db:seed --class=EventSeeder

# Seed data tiket (jalankan setelah EventSeeder)
php artisan db:seed --class=TicketSeeder
```

### Opsi 4: Menggunakan Script Shell

Untuk kemudahan, kami telah menyertakan skrip shell yang dapat Anda jalankan:

```bash
# Di Linux/Mac
./seed_concerts.sh

# Di Windows
.\seed_concerts.bat
```

## Melihat Data yang Telah Di-seed

Kami telah menyertakan perintah untuk melihat data konser yang telah di-seed dalam format yang mudah dibaca:

```bash
# Lihat semua konser
php artisan konser:view

# Lihat semua kategori
php artisan konser:view --categories

# Lihat detail konser tertentu (ganti ID dengan ID konser)
php artisan konser:view ID
```

## Catatan

- Seeder mengasumsikan Anda memiliki pengguna Event Organizer dengan ID 2. `DatabaseSeeder` standar membuat pengguna ini secara otomatis.
- Semua konser diatur ke status "active" secara default.
- Jumlah tiket didistribusikan sebagai:
  - VIP: 10% dari total tiket
  - Gold: 20% dari total tiket
  - Silver: 30% dari total tiket
  - Regular: 40% dari total tiket
  - Jenis tiket spesial dibuat untuk konser tertentu
- Semua konser yang di-seed ditetapkan ke pengguna Event Organizer
- Gambar konser menggunakan path placeholder. Anda perlu menambahkan gambar yang sebenarnya ke direktori `/public/images/events/` dengan nama yang sesuai dengan path di seeder.

## Menambahkan Gambar Konser yang Sebenarnya

Untuk pengalaman terbaik, Anda harus menambahkan gambar yang sebenarnya untuk setiap konser. Path gambar yang diharapkan adalah:

- `/public/images/events/blackpink.jpg`
- `/public/images/events/coldplay.jpg`
- `/public/images/events/edsheeran.jpg`
- `/public/images/events/bts.jpg`
- `/public/images/events/tameimpala.jpg`
- `/public/images/events/javajazz.jpg`
- `/public/images/events/justinbieber.jpg`
- `/public/images/events/dwp.jpg`
- `/public/images/events/adele.jpg`
- `/public/images/events/metallica.jpg`
- `/public/images/events/redvelvet.jpg`
- `/public/images/events/classical.jpg`

## Menambahkan Gambar Kategori yang Sebenarnya

Gambar kategori diharapkan berada di direktori berikut dengan nama yang sesuai:

- `/public/images/categories/kpop.jpg`
- `/public/images/categories/pop.jpg`
- `/public/images/categories/rock.jpg`
- `/public/images/categories/jazz.jpg`
- `/public/images/categories/electronic.jpg`
- `/public/images/categories/indie.jpg`
- `/public/images/categories/classical.jpg`
- `/public/images/categories/festival.jpg` 