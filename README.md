# GrosirKu - Premium Wholesale & Top-Up Terminal v.1.0

GrosirKu adalah platform e-commerce enterprise-grade yang dirancang untuk ekosistem pengadaan profesional (**Sourcing**) dan layanan **Top-Up**. Proyek ini fokus pada estetika premium ("Terminal Aesthetic") dengan integrasi sistem pembayaran otomatis tingkat tinggi.

---

## 🚀 Fitur Utama

- **Premium Design System**: Antarmuka modern dengan nuansa dark mode, glassmorphism, dan tipografi **Sora** (Heading) & **Inter** (Body).
- **Wholesale Workflow**: Alur pembelian grosir dengan validasi stok ketat dan sistem SKU.
- **Integrasi Midtrans Snap**: Pembayaran otomatis dengan verifikasi signature SHA512 untuk keamanan transaksi.
- **Automated Stock Management**: Pengurangan stok otomatis (atomic decrement) segera setelah status pembayaran menjadi *settlement*.
- **Social Login**: Autentikasi kilat menggunakan Discord via Laravel Socialite.
- **Developer Sandbox**: Route khusus untuk bypass pembayaran guna mempercepat testing di lingkungan lokal tanpa perlu tunnel (Ngrok).

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: SQLite (Default) / MySQL 8.0
- **Auth**: Laravel Breeze (Blade) + Socialite
- **Payment Gateway**: Midtrans PHP SDK v2.6
- **Testing**: Pest Framework

### Frontend
- **Build Tool**: Vite
- **Styling**: Tailwind CSS v4, Vanilla CSS (Variables system)
- **Interactivity**: Alpine.js, Axios

---

## 📋 Persyaratan Sistem

- PHP >= 8.2 (dengan ekstensi `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`)
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL 8.0 (jika menggunakan database eksternal) atau Laragon pada Windows.

---

## ⚙️ Panduan Instalasi (Development)

### 1. Persiapan Awal
```bash
git clone https://github.com/nizzarsmkn1sby/grosir.git
cd grosir
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database
**Opsi A: MySQL (Laragon)**
1. Pastikan MySQL running.
2. Klik kanan pada file `setup-database.bat` dan pilih **Run as Administrator** atau jalankan via terminal. Script ini akan membuat database `grosir` dan melakukan migrasi.

**Opsi B: SQLite**
1. Di `.env`, ubah `DB_CONNECTION=sqlite`.
2. Hapus line `DB_DATABASE`, `DB_USERNAME`, dll.
3. Buat file: `touch database/database.sqlite`.

### 3. Migrasi & Data Seed
Proyek ini menggunakan seeder khusus untuk membangun katalog produk industrial:
```bash
php artisan migrate:fresh --seed
```

### 4. Menjalankan Server
```bash
# Jalankan Vite & Laravel Serve secara bersamaan
npm run dev
```

---

## 🔐 Konfigurasi `.env` Penting

| Key | Deskripsi |
| :--- | :--- |
| `MIDTRANS_SERVER_KEY` | Server key dari dashboard Midtrans (Sandbox). |
| `MIDTRANS_CLIENT_KEY` | Client key dari dashboard Midtrans (Sandbox). |
| `MIDTRANS_IS_PRODUCTION` | Set `false` untuk testing. |
| `DISCORD_CLIENT_ID` | OAuth2 Client ID dari Discord Developer Portal. |
| `DISCORD_CLIENT_SECRET` | OAuth2 Client Secret dari Discord. |
| `DISCORD_REDIRECT_URI` | `${APP_URL}/auth/discord/callback` |

---

## 🔐 Akun Demo (Default Seeder)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@grosirku.com` | `admin123` |
| **User** | `user@grosirku.com` | `user123` |

---

## 🧪 Panduan Developer & Debugging

### 1. Bypass Pembayaran (Local Only)
Untuk mengetes flow paska-bayar (pengurangan stok, invoice, dll) tanpa harus membayar sungguhan:
```
GET /dev/complete-payment/{orderId}
```
*Logic: Route ini menggunakan Reflection API untuk memanggil method internal `markAsPaid`.*

### 2. UI Standards & Styling
Gunakan sistem variabel CSS di `resources/views/layouts/public.blade.php`:
- `--alibaba-orange`: `#FF5000` (Warna aksen utama)
- `--alibaba-black`: `#0f172a` (Warna header/footer)
- `--radius-xl`: `24px` (Standar rounded corners)

Komponen tombol standar:
- `.btn-terminal-primary`: Tombol orange gloss.
- `.btn-terminal-outline`: Tombol border tipis premium.

### 3. Menjalankan Test
Gunakan Pest untuk memastikan logika kalkulasi harga dan stok aman:
```bash
php artisan test
```

---

## 📂 Struktur Penting Proyek

- `app/Http/Controllers/Web`: Core logic (Cart, Checkout, Payment).
- `app/Models`: Definisi relasi Order -> OrderItem -> Product.
- `resources/js/app.js`: Entry point untuk Alpine.js dan integrasi Axios.
- `resources/css/app.css`: Custom utility classes di luar Tailwind.

---

## 🤝 Kontribusi

Jika ingin menambahkan fitur:
1. Buat branch baru: `git checkout -b feat/nama-fitur`.
2. Pastikan mengikuti standar penamaan **BEM** untuk CSS custom.
3. Jalankan `npm run build` sebelum melakukan commit final untuk memastikan aset terkompilasi.
4. Push dan buat Pull Request.

---
*Developed by Nizzar & Team with excellence for a seamless wholesale experience.*
