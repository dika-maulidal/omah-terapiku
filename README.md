<p align="center">
  <img src="public/images/logo.png" alt="Logo Omah Terapiku" width="180">
</p>

<h1 align="center">🏠 Omah Terapiku</h1>

<p align="center">
  <strong>Sistem Informasi Pelayanan Terapi & Rekam Medis Penerima Manfaat</strong><br>
  Dinas Sosial Provinsi Jawa Timur
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 8">
  <img src="https://img.shields.io/badge/PHP-%3E%3D%208.1-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-4.5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 4">
</p>

---

## 📖 Tentang Aplikasi

**Omah Terapiku** adalah platform sistem informasi rekam medis dan manajemen pelayanan terapi bagi para penerima manfaat (anak berkebutuhan khusus / disabilitas / pasien terapi tumbuh kembang) yang berada di bawah naungan **Dinas Sosial Provinsi Jawa Timur**.

Sistem ini memudahkan alur kerja dari pendaftaran penerima manfaat, penjadwalan pemeriksaan, rekam medis klinis terapi, diagnosa standar ICD-10, tindakan terapis, hingga pelaporan data secara terpadu dan efisien.

---

## ✨ Fitur Utama

- 📊 **Dashboard Terintegrasi:** Ringkasan statistik jumlah periksa hari ini, total penerima manfaat, dan antrian aktif.
- 👶 **Manajemen Penerima Manfaat:** Pendaftaran data penerima manfaat baru, pencatatan wali, rekam riwayat pasien, dan pencarian cepat (*search*).
- 🩺 **Pelayanan Rekam Medis:**
  - Pencatatan keluhan dan riwayat terapi.
  - Pemeriksaan klinis beserta unggah foto kondisi/perkembangan fisik.
  - Diagnosis terstandarisasi **ICD-10**.
  - Tindakan terapi dan evaluasi penanganan.
  - Status alur pelayanan (*Antrian*, *Pemeriksaan*, *Selesai*).
- 🗂️ **Master Data:**
  - Manajemen Data Tindakan Terapi
  - Manajemen Data Petugas & Staf
  - Manajemen Data Terapis / Dokter
  - Manajemen Kode Diagnosa ICD-10
- 🔔 **Notifikasi Real-time:** Pemberitahuan antrian pasien baru langsung ke dokter/terapis.
- 🎨 **Desain Khusus Identitas Brand:** Antarmuka responsif dengan palet warna resmi Omah Terapiku (*Deep Navy Blue, Sky Cyan, Golden Amber, Leaf Green*).

---

## 👥 Hak Akses Pengguna (Roles)

| Role | Deskripsi Hak Akses |
|:---|:---|
| **1. Admin** | Memiliki kontrol penuh terhadap Dashboard, Penerima Manfaat, Rekam Medis, Master Data (Tindakan, Petugas, Terapis, ICD-10), dan Konfigurasi Sistem. |
| **2. Pendaftaran** | Mengelola pendaftaran penerima manfaat baru, pembaharuan data identitas pasien, dan antrian registrasi pelayanan. |
| **3. Dokter / Terapis** | Memproses antrian pasien, melakukan pemeriksaan klinis, input diagnosa ICD-10, input tindakan terapi, unggah dokumentasi, dan menyelesaikan rekam medis. |

---

## ⚙️ Kebutuhan Sistem (Prerequisites)

Sebelum melakukan instalasi, pastikan komputer Anda telah terpasang:
- **PHP** >= 8.1 (Direkomendasikan PHP 8.2 / 8.3)
- **Composer** >= 2.x
- **MySQL** / **MariaDB** >= 5.7
- **Web Server** (Apache / Nginx / Laragon / XAMPP)
- **Git**

---

## 🚀 Panduan Instalasi (Step-by-Step Installation)

Ikuti langkah-langkah berikut untuk meng-clone dan menjalankan aplikasi di komputer lokal:

### 1. Clone Repository
Buka terminal / Git Bash dan clone repository ini:
```bash
git clone https://github.com/username/omah-terapiku.git
```

### 2. Masuk ke Direktori Proyek
```bash
cd omah-terapiku
```

### 3. Install Dependensi PHP via Composer
Jalankan composer install untuk mengunduh semua pustaka Laravel yang dibutuhkan:
```bash
composer install
```

### 4. Konfigurasi File Environment (`.env`)
Salin file template `.env.example` menjadi `.env`:
- **Windows (PowerShell / Command Prompt):**
  ```powershell
  copy .env.example .env
  ```
- **Linux / macOS:**
  ```bash
  cp .env.example .env
  ```

Buka file `.env` menggunakan teks editor (VS Code, Notepad, dll) dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=omah_terapiku
DB_USERNAME=root
DB_PASSWORD=
```
> *Catatan: Pastikan Anda telah membuat database kosong bernama `omah_terapiku` di phpMyAdmin / MySQL.*

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi & Database Seeder
Jalankan migrasi tabel beserta data dummy default:
```bash
php artisan migrate --seed
```

### 7. Buat Symbolic Link Storage (Untuk Upload Foto)
```bash
php artisan storage:link
```

### 8. Jalankan Server Aplikasi
- **Menggunakan Artisan Serve:**
  ```bash
  php artisan serve
  ```
  Buka browser dan akses: `http://localhost:8000`

- **Menggunakan Laragon:**
  Cukup letakkan folder di `C:\laragon\www\omah-terapiku` dan akses via browser: `http://omah-terapiku.test`

---

## 🔐 Akun Login Default (Testing & Development)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat masuk menggunakan akun berikut:

| Role | Username / Email | Password |
|:---|:---|:---|
| **Admin** | `admin@rekammedis.local` *(atau NIP: `199001012026011001`)* | `password` |
| **Pendaftaran** | `registrasi@rekammedis.local` *(atau NIP: `199101012026011002`)* | `password` |
| **Dokter / Terapis** | `dokter@rekammedis.local` *(atau NIP: `199201012026011003`)* | `password` |

---

## 📁 Struktur Direktori Utama

```text
omah-terapiku/
├── app/
│   ├── Http/Controllers/     # Controller penanganan request HTTP
│   └── Models/               # Model Eloquent (Pasien, Rekam, Dokter, dll)
├── database/
│   ├── migrations/           # Skema tabel database
│   └── seeders/              # Seeder data awal & akun demo
├── public/
│   ├── css/                  # File CSS tema (style.css, brand-theme.css)
│   ├── images/               # Aset gambar & logo resmi
│   └── vendor/               # Vendor plugin aset statis
├── resources/
│   └── views/                # Blade views (Dashboard, Rekam, Pasien, Auth, Layout)
└── routes/
    └── web.php               # Rute navigasi aplikasi web
```

---

## 📄 Lisensi
Hak Cipta © {{ date('Y') }} **Omah Terapiku** - Dinas Sosial Provinsi Jawa Timur. Seluruh hak cipta dilindungi undang-undang.