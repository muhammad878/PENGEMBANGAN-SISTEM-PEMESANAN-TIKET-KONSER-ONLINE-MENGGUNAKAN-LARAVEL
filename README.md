# Sistem Pemesanan Tiket Konser Online

Selamat datang di **Sistem Pemesanan Tiket Konser Online** berbasis Laravel! Proyek ini dirancang untuk memudahkan pembelian tiket konser secara digital, baik untuk pengguna umum, event organizer (EO), maupun admin sistem.

---

## 🚀 Deskripsi Singkat
Aplikasi ini memungkinkan pengguna untuk:
- Menjelajah dan membeli tiket konser secara online
- Mengelola event dan penjualan tiket (untuk EO)
- Melakukan monitoring dan manajemen sistem (untuk Admin)

Dengan fitur lengkap, tampilan modern, dan keamanan terjamin.

---

## 🎯 Fitur Utama Berdasarkan Role

### 👤 **User (Pembeli Tiket)**
- Registrasi & Login
- Verifikasi email & reset password
- Edit profil & ubah password
- Jelajah & cari event konser
- Lihat detail event & kategori
- Tambah tiket ke keranjang
- Checkout & pembayaran (termasuk payment gateway)
- Upload bukti pembayaran (jika manual)
- Mendapatkan e-ticket digital
- Riwayat transaksi & status pembayaran
- Notifikasi email terkait pesanan

### 🎤 **Event Organizer (EO)**
- Registrasi & login EO
- Dashboard EO (statistik penjualan, notifikasi)
- Manajemen event (buat, edit, hapus event)
- Manajemen tiket (jenis, harga, stok)
- Laporan penjualan & komisi
- Export data penjualan ke Excel
- Notifikasi status event & penjualan

### 🛡️ **Admin**
- Login admin
- Dashboard admin (statistik global, notifikasi)
- Manajemen user & EO (aktif/nonaktif, hapus)
- Manajemen event & kategori (validasi, edit, hapus)
- Laporan transaksi & komisi seluruh sistem
- Export laporan ke Excel
- Monitoring aktivitas sistem
- Pengaturan aplikasi (jika ada)

---

## 🛠️ Teknologi yang Digunakan
- **Laravel** (Backend & Routing)
- **Blade** (Template Engine)
- **Tailwind CSS** (Styling)
- **Maatwebsite/Laravel-Excel** (Export Excel)
- **SQLite/MySQL** (Database)
- **Jetstream & Fortify** (Autentikasi)
- **Livewire** (Jika diaktifkan)

---

## ⚡ Cara Instalasi & Menjalankan

1. **Clone repository**
   ```bash
   git clone <url-repo-anda>
   cd PENGEMBANGAN-SISTEM-PEMESANAN-TIKET-KONSER-ONLINE-MENGGUNAKAN-LARAVEL
   ```
2. **Install dependency**
   ```bash
   composer install
   npm install && npm run dev
   ```
3. **Copy file environment**
   ```bash
   cp .env.example .env
   ```
4. **Generate key**
   ```bash
   php artisan key:generate
   ```
5. **Migrasi & seeder database**
   ```bash
   php artisan migrate --seed
   ```
6. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```
7. **Akses aplikasi**
   Buka browser ke [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📸 Tampilan Antarmuka
- Dashboard User, EO, dan Admin yang modern & responsif
- Navigasi mudah, filter event, dan riwayat transaksi
- Export laporan ke Excel hanya dengan satu klik

---

## 🤝 Kontribusi & Kontak
- Pull request & issue sangat diterima!
- Untuk pertanyaan, silakan hubungi: [email@domain.com]

---

Selamat menggunakan dan semoga sukses dengan event Anda! 🎉
