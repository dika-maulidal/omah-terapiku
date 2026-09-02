<p align="center">
  <img src="public/images/logo.png" alt="Logo Omah Terapi-KU" width="160">
</p>

<h1 align="center">🏥 Omah Terapi-KU</h1>

<p align="center">
  <strong>Sistem Informasi Pelayanan Terapi & Rekam Medis Penerima Manfaat</strong><br>
  Dinas Sosial Provinsi Jawa Timur
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 8">
  <img src="https://img.shields.io/badge/PHP-%3E%3D%208.1-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/FullCalendar-v5-3788D8?style=for-the-badge&logo=calendar&logoColor=white" alt="FullCalendar">
  <img src="https://img.shields.io/badge/Bootstrap-4.5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 4">
</p>

---

## 📌 Tentang Aplikasi

**Omah Terapi-KU** adalah platform digital manajemen pelayanan rehabilitasi terapi terpadu dan rekam medis klinis berbasis *evidence-based assessment* bagi Penerima Manfaat Disabilitas, Lansia, dan Anak Berkebutuhan Khusus (ABK) di lingkungan **Dinas Sosial Provinsi Jawa Timur**.

Sistem ini mendukung operasional multi-UPT dan multi-disiplin terapi:
1. **Fisioterapi (Physiotherapy)**
2. **Terapi Okupasi & Sensorik Integrasi (Occupational Therapy / SI)**
3. **Terapi Wicara & Menelan (Speech Therapy & Dysphagia)**
4. **Terapi Netra (Orientasi & Mobilitas / Braille)**

---

## 🏢 Unit Pelaksana Teknis (UPT) Terintegrasi

| No | Unit Pelaksana Teknis (UPT) | Lokasi | Fokus Layanan Unggulan |
|:--:|:---|:---|:---|
| **1** | **UPT PPSAB Sidoarjo** | Sidoarjo | Anak Berkebutuhan Khusus (ABK), Cerebral Palsy, GDD, Autisme |
| **2** | **Balai PRS PMKS Sidoarjo** | Sidoarjo | Dewasa, Lansia, ODGJ, Rehabilitasi Pasca-Stroke |
| **3** | **UPT RSBN Malang** | Malang | Disabilitas Netra & Olahraga Adaptif |

---

## 🌟 Fitur Utama Sistem

### 1. 👥 Manajemen Penerima Manfaat (Pasien)
* **Registrasi Terstruktur:** Pencatatan NIK, No. Rekam Medis (Auto-format `OTK-YY-NNNNN`), data demografi, data wali, dan klasifikasi disabilitas.
* **Filter Desil Kemiskinan:** Kategori ekonomi Desil 1 s/d Desil 4 untuk prioritas bantuan sosial.
* **Manajemen Dokumen Digital:** Upload Surat Rujukan, Kartu Keluarga (KK), KTP, dan General Consent digital.
* **Export Data:** Unduh rekapitulasi data penerima manfaat ke format CSV/Excel.

### 2. 📅 Modul Jadwal & Kalender Terapi (Sesi Rabu)
* **Jadwal Sesi Terapi:** Manajemen 8 slot waktu kunjungan (08.00 s/d 14.30 WIB) khusus hari pelayanan Rabu.
* **Quick Presets:** Filter cepat *Hari Ini*, *Rabu Terdekat*, dan pencarian nama terapis / penerima manfaat.
* **Kalender Interaktif:** Integrasi FullCalendar untuk visualisasi agenda dan kuota sesi.

### 3. 📋 Rekam Medis & SOAP Harian (Dual-Tab Interface)
* **Tab 1: Profil Klinis & Capaian Fungsional Terkini**
  * 4 Indikator Live: GMFM-88 Total Score, Skala Denver II, Tingkat Nyeri, dan Rencana Terapi Aktif.
  * Riwayat Asesmen Komprehensif berkala.
* **Tab 2: Log Sesi Terapi Harian (SOAP)**
  * **S (Subjektif):** Keluhan penerima manfaat / keluarga.
  * **O (Objektif):** Tanda-tanda vital, inspeksi fisik, dan dokumentasi foto.
  * **A (Assessment):** Kesimpulan evaluasi klinis terapis terintegrasi kode **ICD-10** dan chip kondisi fungsional.
  * **P (Plan):** Rencana tindakan terapi harian dari 30 daftar master tindakan.

### 4. 🧠 Form Asesmen Klinis Komprehensif (15 Modul Standar)
1. **Kemampuan Motorik Kasar** (Head control, berguling, duduk, merangkak, berlutut, berdiri, berjalan).
2. **Skala GMFM-88** (*Gross Motor Function Measure* Dimensi A s/d E dengan kalkulasi persentase otomatis).
3. **Kemandirian ADL** (*Activities of Daily Living* - Skala Barthel Index).
4. **Status Terapi Wicara & Menelan** (Organ wicara, artikulasi, reseptif/ekspresif, disfagia).
5. **Status Penglihatan & Orientasi Mobilitas** (Ketajaman visual, lapang pandang, tongkat putih, Braille).
6. **Body Chart & Skala Nyeri Visual** (Canvas interaktif untuk penandaan lokasi & intensitas nyeri).
7. **Pemeriksaan ROM & MMT** (*Range of Motion & Manual Muscle Testing*).
8. **Pemeriksaan Neurologis** (Tonus otot spastisitas Ashworth, refleks fisiologis, klonus).
9. **Postur & Keseimbangan** (Skoliosis, lordosis, kyphosis, uji Romberg, *single leg stance*).
10. **Analisis Pola Jalan (Gait)** (*Cadence, step length*, tren *toe-walking, circumduction*).
11. **Sensori & Vestibular** (Taktil, proprioseptif, vestibular, toleransi sensorik).
12. **Psikososial & Emosional** (Kontak mata, regulasi emosi, interaksi sosial).
13. **Perencanaan Intervensi Terapi** (Modalitas fisik, manual terapi, latihan terapeutik, edukasi keluarga).
14. **Kesimpulan Klinis & Target Terapi** (Target jangka pendek & jangka panjang).
15. **Skala Denver II / DDST II** (125 Task perkembangan 4 sektor dengan kesimpulan otomatis: *Normal / Suspect / Keterlambatan / Untestable*).
* **Fitur Form:** *Floating Sticky Save Bar*, *Auto-Save Draft ke LocalStorage*, dan *Cetak PDF Lembar Asesmen Resmi*.

### 5. 🗄️ Master Data Terintegrasi
* **Master Omah Terapi-KU:** Pengelolaan lokasi UPT, fokus layanan, dan penugasan multi-terapis.
* **Master Tindakan (30 Tindakan):** Fisioterapi (`FIS`), Terapi Okupasi (`OKU`), Terapi Wicara (`WIC`), dan Terapi Netra (`NET`).
* **Master ICD-10 (18 Diagnosa):** Kode klasifikasi penyakit & disabilitas internasional.
* **Master Petugas & Terapis:** Pengelolaan hak akses, NIP, kontak, dan ganti password.

---

## 👥 Hak Akses (Roles)

| Role | Identitas | Hak Akses Utama |
|:---|:---:|:---|
| **Super Admin** | `Role 1` | Kontrol penuh sistem, kelola Master Data (UPT, Tindakan, ICD-10, Petugas, Terapis), rekam medis, dan pengaturan akun. |
| **Petugas Registrasi** | `Role 2` | Pendaftaran penerima manfaat baru, verifikasi berkas/desil, dan manajemen antrian/sesi terapi. |
| **Terapis / Dokter** | `Role 3` | Input Asesmen 15 Modul, pencatatan log SOAP harian, pemilihan tindakan terapi, dan evaluasi berkala. |

---

## 💻 Panduan Instalasi (Development / Server)

### 1. Clone Repository & Setup Environment
```bash
# Clone repository
git clone https://github.com/dika-maulidal/omah-terapiku.git
cd omah-terapiku

# Install dependencies PHP
composer install

# Salin file konfigurasi environment
cp .env.example .env
```

### 2. Konfigurasi Database `.env`
Sesuaikan kredensial database pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=omah_terapiku
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeding Data Otomatis
```bash
# Generate application key
php artisan key:generate

# Jalankan migrasi database beserta seeder data master
php artisan migrate --seed

# Buat symbolic link storage
php artisan storage:link

# Bersihkan cache
php artisan optimize:clear
```

### 4. Menjalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser: **`http://localhost:8000`**

---

## 🔑 Akun Login Default (Hasil Database Seeder)

Semua akun di bawah ini otomatis dibuat saat menjalankan perintah `php artisan db:seed` atau `php artisan migrate --seed` dengan password default: **`password`**

| No | Peran / Role | Nama Akun | Unit Penugasan | Email Login | NIP | Password Default |
|:--:|:---|:---|:---|:---|:---:|:---:|
| **1** | **Super Admin** | Administrator Omah Terapi-KU | Dinas Sosial Prov. Jatim | `admin@rekammedis.local` | `199001012026011001` | **`password`** |
| **2** | **Petugas Registrasi** | Petugas Registrasi & Asesmen | Loket Pendaftaran Terpadu | `registrasi@rekammedis.local` | `199101012026011002` | **`password`** |
| **3** | **Terapis** | Budi Hartanto, S.Tr.Kes | UPT PPSAB Sidoarjo | `terapis.ppsab@rekammedis.local` | `199201012026011003` | **`password`** |
| **4** | **Terapis** | Siti Rahmawati, A.Md.OT | Balai PRS PMKS Sidoarjo | `terapis.pmks@rekammedis.local` | `199301012026011004` | **`password`** |
| **5** | **Terapis** | Dadar Putra, S.Pd | UPT RSBN Malang | `terapis.rsbn@rekammedis.local` | `199401012026011005` | **`password`** |

---

## 📄 Lisensi
Dikembangkan untuk **Dinas Sosial Provinsi Jawa Timur** dalam rangka digitalisasi pelayanan rehabilitasi sosial dan terapi terpadu bagi masyarakat.