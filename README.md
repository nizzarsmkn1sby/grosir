# GrosirKu - Premium Wholesale & Top-Up Terminal v.1.0

GrosirKu adalah platform e-commerce enterprise-grade yang dirancang untuk ekosistem pengadaan profesional (**Sourcing**) dan layanan **Top-Up**. Proyek ini fokus pada estetika premium ("Terminal Aesthetic") dengan integrasi sistem pembayaran otomatis.

## 🚀 Fitur Utama

- **Premium Design System**: Antarmuka modern dengan nuansa dark mode, glassmorphism, dan tipografi **Sora** (Heading) & **Inter** (Body).
- **Wholesale Workflow**: Alur pembelian grosir dengan validasi stok ketat dan sistem SKU.
- **Integrasi Midtrans Snap**: Pembayaran otomatis dengan verifikasi signature SHA512 untuk keamanan transaksi.
- **Automated Stock Management**: Pengurangan stok otomatis (atomic decrement) segera setelah status pembayaran menjadi *settlement*.
- **Social Login**: Autentikasi kilat menggunakan Discord via Laravel Socialite.
- **Developer Sandbox**: Route khusus untuk bypass pembayaran guna mempercepat testing di lingkungan lokal.

## 🛠️ Tech Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: Vite, Tailwind CSS v4 (Alpha/Full), Alpine.js
- **Database**: SQLite (Default) / MySQL 8.0
- **Payment Gateway**: Midtrans PHP SDK v2.6
- **Auth**: Laravel Breeze & Laravel Socialite

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- Laragon (Direkomendasikan pada Windows) / MySQL 8.0

## ⚙️ Panduan Instalasi (Development)

### 1. Persiapan Awal
```bash
git clone [url-repo]
cd grosir
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database
Anda dapat menggunakan **SQLite** (buat file `database/database.sqlite`) atau **MySQL**. Jika menggunakan MySQL di Laragon:
- Jalankan `setup-database.bat` untuk otomatisasi pembuatan DB `grosir` dan migrasi.

### 3. Migrasi & Data Seed
Proyek ini dilengkapi dengan data contoh yang sangat lengkap:
```bash
php artisan migrate:fresh --seed
```
*Note: Seeder akan membuat kategori Industrial Logic, Robotic Sourcing, dsb.*

### 4. Menjalankan Server
```bash
npm run dev
```

## 🔐 Akun Demo (Default Seeder)

Gunakan akun berikut untuk login setelah menjalankan seeder:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@grosirku.com` | `admin123` |
| **User** | `user@grosirku.com` | `user123` |

## 🧪 Tips Development & Debugging

### Bypass Pembayaran (Local Only)
Gunakan endpoint ini untuk mensimulasikan pembayaran tanpa webhook:
```
GET /dev/complete-payment/{orderId}
```
*Logic: Secara otomatis memanggil private method `markAsPaid` di `PaymentController`.*

### Monitoring Transaksi
Semua log penting (error signature, pengurangan stok, notifikasi Midtrans) dicatat secara mendalam di:
`storage/logs/laravel.log`

## 📂 Struktur Penting Proyek

- `app/Http/Controllers/Web`: Logika utama Cart, Checkout, dan Product.
- `app/Http/Controllers/PaymentController`: Endpoint webhook Midtrans & verifikasi signature.
- `database/seeders`: Konfigurasi produk (Game vs Industrial).
- `resources/views/layouts/public.blade.php`: Sistem desain global dan komponen UI Terminal.

---
*Developed by Nizzar & Team with excellence for a seamless wholesale experience.*
