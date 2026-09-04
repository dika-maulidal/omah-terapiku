# Dokumen Rencana & Skenario UAT (User Acceptance Testing) End-to-End
**Aplikasi Omah Terapi-KU — Dinas Sosial Provinsi Jawa Timur**
*Sistem Informasi Rekam Medis & Manajemen Pelayanan Terapi Inklusif*

---

## 1. Informasi Dokumen & Panduan Pengujian

Dokumen ini memuat panduan lengkap skenario pengujian penerimaan pengguna (*User Acceptance Testing* - UAT) secara **End-to-End (dari awal pendaftaran hingga pelaporan selesai)** untuk memastikan seluruh fitur aplikasi berfungsi sesuai kebutuhan operasional klinis dan aturan bisnis Dinas Sosial Provinsi Jawa Timur.

### A. Akun Pengujian (Test Accounts)
Siapkan 3 akun uji dengan peran berbeda untuk melakukan simulasi:

| Peran (*Role*) | Username / NIP Default | Password | Tujuan Pengujian |
|---|---|---|---|
| **Administrator** *(Role 1)* | `admin` / NIP Admin | `password` / `123456` | Pengujian master data, monitoring dashboard, dan ekspor laporan. |
| **Petugas Pendaftaran** *(Role 2)* | `pendaftaran` / NIP Petugas | `password` / `123456` | Pengujian registrasi pasien, validasi DTKS, booking slot jadwal, dan antrian. |
| **Dokter / Terapis** *(Role 3)* | `terapis` / NIP Terapis | `password` / `123456` | Pengujian pemeriksaan SOAP, form asesmen 15 modul, dan cetak lembar klinis. |

### B. Lingkungan Pengujian
- **URL Aplikasi:** `http://omah-terapiku.test` (atau `http://localhost:8000`)
- **Browser yang Didukung:** Google Chrome / Microsoft Edge / Mozilla Firefox terbaru
- **Standar Format Data:** Hari operasional khusus **Rabu (08.00 - 13.00 WIB)**, Durasi sesi **30-45 menit**, Kriteria **Desil 1-5 DTKS**.

---

## 2. Peta Alur Pengujian End-to-End (Tahapan UAT)

Pengujian wajib dilakukan berurutan sesuai alur pelayanan riil di lapangan:

```
[FASE 1: Autentikasi & Global UPT]
   ↓
[FASE 2: Registrasi Penerima Manfaat & DTKS]
   ↓
[FASE 3: Penjadwalan Sesi & Antrian Terapi]
   ↓
[FASE 4: Pemanggilan Pasien & Transisi Status]
   ↓
[FASE 5: Pelayanan Klinis SOAP & Unggah Foto]
   ↓
[FASE 6: Asesmen 15 Modul Klinis & Cetak Hasil]
   ↓
[FASE 7: Finalisasi Sesi & Edukasi Home Program]
   ↓
[FASE 8: Monitoring Dashboard, Master Data & Ekspor CSV]
```

---

## 3. Matriks Skenario Pengujian UAT Lengkap

### FASE 1: Autentikasi, Hak Akses (RBAC) & Global UPT Filter

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-01** | Login Multi-Kredensial (Username / Email / NIP) | Semua Aktor | 1. Buka halaman login (`/`).<br>2. Masukkan Username, Email, atau NIP.<br>3. Masukkan password yang benar.<br>4. Klik tombol **"Masuk Aplikasi"**. | Sistem berhasil memvalidasi kredensial dan mengarahkan pengguna ke dashboard sesuai role masing-masing. | [ ] | |
| **UAT-02** | Validasi Login Gagal & Keamanan | Semua Aktor | 1. Masukkan Username benar tetapi password salah.<br>2. Klik tombol login. | Sistem menolak akses, menampilkan pesan error *"Mohon periksa Nama/Username dan password dengan benar"*, dan password tetap aman. | [ ] | |
| **UAT-03** | Isolasi Hak Akses Role (RBAC) | Petugas & Dokter | 1. Login sebagai Petugas Pendaftaran.<br>2. Coba akses menu Master Dokter / Pengaturan Petugas.<br>3. Login sebagai Dokter/Terapis.<br>4. Coba akses menu Master Data Admin. | Menu yang tidak diizinkan disembunyikan dari sidebar / sistem memblokir akses tidak sah (*Error 403 / Redirect*). | [ ] | |
| **UAT-04** | Penggunaan Global UPT Selector | Semua Aktor | 1. Di bagian Topbar Header, klik dropdown **"Pilih Lokasi UPT"**.<br>2. Pilih *"UPT PPSAB Sidoarjo"*.<br>3. Buka menu Pasien / Jadwal.<br>4. Ganti pilihan ke *"UPT RSBN Malang"* atau *"Semua UPT"*. | Data pasien, jadwal, dan rekam medis otomatis terfilter sesuai UPT yang dipilih pada sesi aktif pengguna. | [ ] | |
| **UAT-05** | Ubah Password & Profil Pengguna | Semua Aktor | 1. Buka menu Profil / Pengaturan Akun.<br>2. Masukkan password baru (min. 6 karakter) & konfirmasi.<br>3. Simpan perubahan.<br>4. Logout dan login kembali menggunakan password baru. | Password berhasil diperbarui dan pengguna sukses login dengan password baru. | [ ] | |

---

### FASE 2: Pendaftaran Penerima Manfaat & Verifikasi DTKS

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-06** | Pendaftaran Penerima Manfaat Baru | Petugas Pendaftaran / Admin | 1. Buka menu **Penerima Manfaat** (`/penerima-manfaat`).<br>2. Klik tombol **"Tambah Penerima Manfaat"**.<br>3. Isi Data Pribadi (Nama, NIK 16 digit, Tempat/Tgl Lahir, Jenis Kelamin, Alamat).<br>4. Pilih UPT Lokasi. | Form input terbuka dengan validasi lengkap tanpa kendala. | [ ] | |
| **UAT-07** | Validasi Desil DTKS 1 s.d. 5 | Petugas Pendaftaran | 1. Pada dropdown **Desil DTSEN / DTKS**, pilih *"Desil 1"*, *"Desil 2"*, s.d. *"Desil 5"*.<br>2. Amati badge status eligibilitas bantuan sosial. | Sistem menerima pilihan Desil 1–5 sebagai syarat sah penerima manfaat gratis Dinas Sosial. | [ ] | |
| **UAT-08** | Input Multiselect Disabilitas & Alat Bantu | Petugas Pendaftaran | 1. Pada field **Jenis Disabilitas**, pilih lebih dari satu (contoh: *Fisik + Sensorik Netra*).<br>2. Pada field **Alat Bantu**, pilih *Kursi Roda* dan *Tongkat*. | Input multiselect berfungsi lancar, tag pilihan muncul rapi, dan tersimpan dalam format array/string gabungan. | [ ] | |
| **UAT-09** | Auto-Generate Nomor Rekam Medis (No. RM) | Petugas Pendaftaran | 1. Kosongkan field No. RM (atau biarkan default).<br>2. Submit form registrasi.<br>3. Cek No. RM yang terbentuk di tabel pasien. | Sistem secara otomatis menerbitkan No. RM unik dengan format `OTK-26-XXXXX` (contoh: `OTK-26-00001`) berurutan. | [ ] | |
| **UAT-10** | Upload Berkas KK & File Resume Medis | Petugas Pendaftaran | 1. Unggah file Kartu Keluarga (JPG/PNG/PDF).<br>2. Unggah file Resume Medis Asal.<br>3. Klik Simpan.<br>4. Buka detail pasien dan klik tombol lihat berkas. | File terunggah ke direktori storage dengan aman dan dapat dibuka/diunduh kembali oleh petugas. | [ ] | |
| **UAT-11** | Pencarian Cepat & Filter DataTables Pasien | Petugas Pendaftaran | 1. Di halaman index pasien, ketik NIK / Nama / No. RM pada kotak pencarian AJAX.<br>2. Filter berdasarkan status (*Pasien Baru / Sudah Periksa*). | Data tabel melakukan filter secara instan (*server-side/client-side DataTables*) tanpa reload halaman. | [ ] | |

---

### FASE 3: Penjadwalan Sesi Terapi & Manajemen Slot Waktu

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-12** | Pembagian Slot Sesi Operasional (Hari Rabu) | Petugas Pendaftaran | 1. Buka menu **Jadwal Terapi** (`/jadwal-terapi`).<br>2. Pilih tanggal yang jatuh pada hari **Rabu**.<br>3. Periksa ketersediaan 7 slot sesi utama (08.00–13.00 WIB) & slot khusus. | Sistem menampilkan pembagian slot waktu: Sesi 1 (08.00–08.45) s.d. Sesi 7 (12.30–13.00) dengan durasi 30–45 menit. | [ ] | |
| **UAT-13** | Pendaftaran Sesi Baru & Multi-Terapis | Petugas Pendaftaran | 1. Klik **"Input Sesi Terapi Baru"**.<br>2. Pilih Penerima Manfaat via modal pencarian.<br>3. Pilih Layanan (contoh: *Fisioterapi*).<br>4. Pilih Terapis Utama dan opsional **Terapis Pendamping**.<br>5. Isi keluhan awal & pilih slot jam.<br>6. Klik Simpan. | Sesi berhasil didaftarkan, otomatis berstatus **1 (Antrian)**, cara bayar diset otomatis *"Gratis"*, dan No. Registrasi terbit (`REG#YYYYMMDD{id}`). | [ ] | |
| **UAT-14** | Validasi Anti-Duplikasi Sesi Aktif | Petugas Pendaftaran | 1. Coba daftarkan kembali pasien yang sama yang masih memiliki sesi berstatus *Antrian* atau *Pemeriksaan*. | Sistem menolak pendaftaran dan memunculkan notifikasi: *"Pasien ini masih belum selesai periksa, harap selesaikan pemeriksaan sebelumnya"*. | [ ] | |
| **UAT-15** | Tampilan Kalender Jadwal & Filter | Semua Aktor | 1. Buka halaman Jadwal Terapi.<br>2. Ubah filter Layanan (Fisioterapi/Okupasi/Wicara/Sensorik) dan filter Dokter.<br>3. Klik tanggal pada FullCalendar / Grid slot. | Jadwal terfilter secara akurat dan kartu antrian pasien tampil pada slot waktu yang tepat. | [ ] | |

---

### FASE 4: Pemanggilan Pasien, Notifikasi & Transisi Status

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-16** | Pemanggilan Pasien ke Ruang Terapi | Petugas Pendaftaran | 1. Pada daftar antrian pasien, klik tombol **"Panggil Pasien"** (Ubah Status ke 2 - Pemeriksaan). | Status sesi pasien berubah dari `Antrian (1)` menjadi `Pemeriksaan (2)`. | [ ] | |
| **UAT-17** | Penerimaan Notifikasi Real-Time Terapis | Dokter / Terapis | 1. Login sebagai Dokter/Terapis yang ditunjuk.<br>2. Amati lonceng notifikasi di Topbar saat pasien dipanggil oleh pendaftaran. | Terapis menerima notifikasi: *"Pasien [Nama], silahkan diproses"* secara *real-time* (Pusher/Database Notification). | [ ] | |
| **UAT-18** | Akses Halaman Detail Rekam Medis | Dokter / Terapis | 1. Klik notifikasi atau klik tombol aksi di dashboard/jadwal.<br>2. Masuk ke halaman `/rekam/pasien/{id}`. | Halaman terbuka dengan menampilkan 2 Tab Utama yang terpisah rapi: **Tab 1: Asesmen Baseline & Re-evaluasi** dan **Tab 2: Log Sesi Terapi (SOAP)**. | [ ] | |

---

### FASE 5: Pelayanan Klinis — Pencatatan Log Harian (SOAP)

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-19** | Pencatatan Subjective (S) | Dokter / Terapis | 1. Pada Tab SOAP, periksa bagian Keluhan / Subjektif.<br>2. Pastikan keluhan awal dari pendaftaran tampil dan dapat disesuaikan. | Data keluhan utama dari pasien/wali tercatat dengan benar. | [ ] | |
| **UAT-20** | Pencatatan Objective (O) & Unggah Foto Fisik | Dokter / Terapis | 1. Buka form Pemeriksaan Fisik (O).<br>2. Masukkan catatan hasil observasi fisik.<br>3. Lampirkan foto kondisi fisik pasien (JPG/PNG).<br>4. Klik Simpan Pemeriksaan (O). | Data pemeriksaan tersimpan, file foto tersimpan di server (`/images/pemeriksaan/PEM-...`), dan thumbnail foto dapat diklik untuk preview. | [ ] | |
| **UAT-21** | Pencatatan Assessment (A) & Diagnosa ICD-10 | Dokter / Terapis | 1. Buka form Diagnosa Terapi (A).<br>2. Cari kode ICD-10 (contoh: *G80.0 Cerebral Palsy*).<br>3. Klik Simpan Diagnosa.<br>4. Tambah diagnosa penyerta kedua jika diperlukan.<br>5. Uji hapus diagnosa jika salah input. | Diagnosa ICD-10 tersimpan di tabel diagnosa dan tampil sebagai badge kode diagnosa yang rapi. | [ ] | |
| **UAT-22** | Pencatatan Plan (P), Tindakan & Foto Tindakan | Dokter / Terapis | 1. Buka form Tindakan & Plan (P).<br>2. Masukkan deskripsi intervensi terapi.<br>3. Unggah foto saat sesi terapi berlangsung.<br>4. Klik Simpan Tindakan (P). | Data rencana dan bukti foto tindakan tersimpan (`/images/pemeriksaan/TIND-...`) dengan status update sukses. | [ ] | |
| **UAT-23** | Validasi Kelengkapan Sebelum Ubah Status | Dokter / Terapis | 1. Coba ubah status ke 3 (Menunggu) atau 4/5 (Selesai) tanpa mengisi Pemeriksaan (O) atau Tindakan (P). | Sistem memvalidasi dan memunculkan peringatan error: *"Pemeriksaan / Tindakan belum diisi"*. | [ ] | |
| **UAT-24** | Tabel Riwayat Log SOAP Bersih | Dokter / Terapis | 1. Amati tabel riwayat sesi terapi di bagian bawah Tab SOAP.<br>2. Klik tombol utilitas **"Lihat Detail Catatan"**. | Tabel tampil bersih tanpa tumpukan tombol warna-warni, dan modal detail membuka ringkasan S, O, A, P lengkap beserta fotonya. | [ ] | |

---

### FASE 6: Asesmen Klinis Komprehensif (15 Modul Klinis)

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-25** | Navigasi 4 Kategori Tab Asesmen | Dokter / Terapis | 1. Klik tombol **"Buka Form Asesmen Terapis"** (`/rekam/{id}/assessment`).<br>2. Klik bergantian 4 Kategori Utama: *Motorik & ADL*, *Sensorik & Khusus*, *Pemeriksaan Fisik*, dan *Perkembangan & Rencana*. | Perpindahan antar 4 kategori tab berjalan mulus responsif tanpa horizontal scroll bar yang rusak. | [ ] | |
| **UAT-26** | Pengisian Modul Motorik, ADL & Wicara | Dokter / Terapis | 1. Isi kemampuan mengangkat kepala, tengkurap, duduk, merangkak, berjalan.<br>2. Isi indikator ADL (kontak mata, makan, mandi, berpakaian, BAB/BAK).<br>3. Isi kemampuan wicara dan menelan. | Data radio button dan opsi penilaian terpilih dengan jelas. | [ ] | |
| **UAT-27** | Modul Status Penglihatan (Low Vision/Netra) | Dokter / Terapis | 1. Pilih klasifikasi (Low Vision / Buta Total), Onset, Visus OD/OS.<br>2. Centang alat bantu yang digunakan (Tongkat Putih, Guide Dog, Kacamata, Screen Reader). | Data tersimpan rapi dan mendukung asesmen disabilitas netra (khusus UPT RSBN Malang). | [ ] | |
| **UAT-28** | Modul GMFM-88 (Grid Matrix & Auto-Calc) | Dokter / Terapis | 1. Buka sub-tab GMFM-88.<br>2. Klik skor (0, 1, 2, 3, NT) pada tabel grid matrix Dimensi A s.d. E.<br>3. Amati kotak total skor dan persentase (%) otomatis. | Skor terhitung otomatis secara *real-time* via JavaScript dan persentase dimensi tampil tanpa perlu kalkulator manual. | [ ] | |
| **UAT-29** | Modul Nyeri & Interactive Canvas Body Chart | Dokter / Terapis | 1. Atur Skala Nyeri VAS (0–10) & Sifat Nyeri.<br>2. Pada gambar anatomi tubuh (*Body Chart Canvas*), pilih simbol (`~` Nyeri, `#` Kesemutan, `X` Kaku).<br>3. Klik titik tubuh pada gambar (depan/belakang). | Tanda titik nyeri muncul tepat di posisi klik pada kanvas dan data koordinat/gambar tersimpan saat disubmit. | [ ] | |
| **UAT-30** | Modul ROM & MMT Matrix + Tombol "Set All Normal" | Dokter / Terapis | 1. Buka tabel ROM & MMT.<br>2. Klik tombol akselerator **"Set All Normal"**.<br>3. Ubah nilai khusus pada bagian sendi yang mengalami keterbatasan. | Semua kolom terisi nilai default normal secara instan, menghemat waktu terapis saat menginput data pasien. | [ ] | |
| **UAT-31** | Modul Pemeriksaan Neurologis, Postur, Keseimbangan & Gait | Dokter / Terapis | 1. Isi refleks tendon, tonus otot, temuan postur.<br>2. Isi instrumen keseimbangan (BBS, TUG dalam detik, Romberg Test).<br>3. Isi karakteristik gaya berjalan & 10-Meter Walk Test (10MWT). | Seluruh isian pemeriksaan fisik tersimpan dengan parameter klinis yang akurat. | [ ] | |
| **UAT-32** | Modul Sensoris & Skrining Vestibular (HIT / Dix-Hallpike) | Dokter / Terapis | 1. Isi sensasi taktil, propriosepsi posisi sendi.<br>2. Pilih hasil Head Impulse Test (HIT) dan Dix-Hallpike (Normal / Abnormal / Positif / Negatif). | Data skrining vestibular tersimpan dengan interpretasi klinis yang sesuai. | [ ] | |
| **UAT-33** | Modul Perencanaan Terapi & Skala Denver II (DDST II) | Dokter / Terapis | 1. Centang modalitas fisik, manual terapi, latihan terapi, edukasi.<br>2. Atur dosis: frekuensi (x/minggu), durasi (menit), estimasi total sesi.<br>3. Isi Matrix Skala Denver II (Personal Sosial, Motorik Halus, Bahasa, Motorik Kasar).<br>4. Amati auto-count (Pass, Fail, Refusal, No Opportunity). | Dosis terapi dan kalkulasi skor Denver II terhitung otomatis dengan rekapitulasi jumlah tugas perkembangan. | [ ] | |
| **UAT-34** | Simpan Draft & Indikator Kelengkapan Form | Dokter / Terapis | 1. Isi sebagian form asesmen.<br>2. Klik **"Simpan Form Asesmen"**.<br>3. Buka kembali halaman Detail Pasien. | Badge persentase kelengkapan asesmen (contoh: *85% Lengkap*) tampil di tab riwayat asesmen. | [ ] | |
| **UAT-35** | Cetak Lembar Asesmen Klinis (Print Preview) | Dokter / Terapis | 1. Klik tombol **"Cetak Form Asesmen"** (`/rekam/{id}/assessment/print`).<br>2. Periksa tampilan halaman cetak (*print-friendly layout*).<br>3. Uji cetak ke PDF / Printer fisik. | Halaman cetak tampil profesional dengan kop surat resmi, tabel rapi, tanda tangan terapis, dan tanpa elemen navigasi website yang mengganggu. | [ ] | |

---

### FASE 7: Finalisasi Sesi, Edukasi & Tindak Lanjut

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-36** | Penyelesaian Sesi Terapi & Home Program | Dokter / Terapis | 1. Berikan catatan edukasi / program latihan mandiri di rumah (*Home Exercise Program*) kepada wali pasien.<br>2. Klik tombol **"Selesaikan Sesi Terapi"** (Status: 4 atau 5 - Selesai). | Status sesi terapi berubah menjadi `Selesai` (Badge Hijau), dan data sesi terkunci dari perubahan tidak sengaja. | [ ] | |
| **UAT-37** | Notifikasi Balik ke Bagian Pendaftaran | Petugas Pendaftaran | 1. Login sebagai Petugas Pendaftaran.<br>2. Amati lonceng notifikasi saat terapis menyelesaikan sesi pasien. | Pendaftaran menerima notifikasi: *"Rekam medis pasien [Nama] siap diproses / selesai"*. | [ ] | |
| **UAT-38** | Reservasi Sesi Terapi Rabu Pekan Depan | Petugas Pendaftaran | 1. Wali pasien menuju meja pendaftaran untuk jadwal berikutnya.<br>2. Petugas membuka menu pendaftaran sesi baru.<br>3. Pilih tanggal hari Rabu minggu depan dan slot jam yang disepakati. | Pasien berhasil terdaftar untuk sesi terapi lanjutan tanpa perlu mengisi ulang biodata dasar. | [ ] | |
| **UAT-39** | Komparasi Riwayat Asesmen Baseline vs Re-Evaluasi | Dokter / Terapis | 1. Buka kembali Tab 1 (Asesmen Baseline & Re-Evaluasi) pada pasien yang telah menjalani lebih dari 1 kali asesmen. | Riwayat seluruh asesmen berurutan secara kronologis, memungkinkan terapis melihat progres perkembangan pasien dari waktu ke waktu. | [ ] | |

---

### FASE 8: Monitoring Dashboard, Master Data & Ekspor CSV

| ID Test | Skenario Pengujian | Aktor | Langkah-langkah Pengujian (*Step-by-Step*) | Hasil yang Diharapkan (*Expected Result*) | Status (P/F) | Catatan |
|---|---|---|---|---|:---:|---|
| **UAT-40** | Verifikasi Kartu Statistik Dashboard Admin | Administrator | 1. Login sebagai Administrator (`/dashboard`).<br>2. Periksa kartu metrik: Total Pasien, Total Sesi Terapi, Pasien Aktif, dan Antrian Hari Ini. | Angka statistik di kartu dashboard terakumulasi secara akurat sesuai data di database. | [ ] | |
| **UAT-41** | Filter Dropdown Universal pada Grafik Analitik | Administrator | 1. Pada kartu *Tren Pelayanan*, ubah filter rentang waktu (7 Hari / 30 Hari / Tahun Ini).<br>2. Pada kartu *Top 5 Tindakan*, ubah filter periode (Bulan Ini / Tahun Ini).<br>3. Pada kartu *Top Diagnosa Kasus Terbanyak*, ubah filter periode. | Seluruh grafik analitik dan ranking bar memperbarui data secara dinamis sesuai filter yang dipilih. | [ ] | |
| **UAT-42** | Manajemen Master Data Dokter & Terapis | Administrator | 1. Buka menu **Dokter / Terapis** (`/dokter`).<br>2. Tambah data Terapis baru (Nama, NIP, Spesialisasi, Akun Login).<br>3. Uji fitur Edit dan Nonaktifkan Terapis. | Data terapis tersimpan, akun login langsung aktif, dan terapis baru muncul di dropdown pilihan jadwal. | [ ] | |
| **UAT-43** | Manajemen Master Petugas & Hak Akses | Administrator | 1. Buka menu **Petugas** (`/petugas`).<br>2. Tambah akun Petugas Pendaftaran baru.<br>3. Uji login menggunakan akun baru tersebut. | Akun petugas berhasil dibuat dan dapat login dengan batasan hak akses role 2. | [ ] | |
| **UAT-44** | Manajemen Master UPT / Poli | Administrator | 1. Buka menu **Poli / UPT** (`/omahterapiku`).<br>2. Tambah / Ubah data unit pelayanan (UPT PPSAB, RS PMKS, RSBN). | Master lokasi UPT tersimpan dan terintegrasi dengan Global UPT selector. | [ ] | |
| **UAT-45** | Manajemen Master Tindakan & ICD-10 | Administrator | 1. Buka menu **Tindakan** (`/tindakan`) & menu **ICD-10** (`/icd`).<br>2. Tambah kode diagnosa atau tindakan terapi baru.<br>3. Uji pencarian data. | Data master tindakan dan katalog ICD-10 tersimpan dan dapat langsung dipilih pada form rekam medis. | [ ] | |
| **UAT-46** | Ekspor Data Penerima Manfaat ke CSV | Administrator | 1. Buka menu Penerima Manfaat.<br>2. Terapkan filter UPT (opsional).<br>3. Klik tombol **"Export CSV"**.<br>4. Buka file hasil unduhan menggunakan Microsoft Excel. | File `data-penerima-manfaat-....csv` terunduh dengan format UTF-8 BOM (karakter rapi tanpa error encoding di Excel, NIK/No. HP tidak terpotong). | [ ] | |
| **UAT-47** | Ekspor Data Rekam Medis ke CSV | Administrator | 1. Buka menu Rekam Medis (`/rekam`).<br>2. Klik tombol **"Export CSV"**.<br>3. Buka file di Microsoft Excel. | Seluruh riwayat kunjungan, diagnosa ICD, tindakan, dan nama terapis terekspor lengkap dalam format tabel Excel. | [ ] | |

---

## 4. Formulir Persetujuan & Serah Terima UAT (*Sign-Off Sheet*)

Setelah seluruh skenario pengujian di atas dieksekusi, dokumen ini ditandatangani oleh pihak-pihak terkait sebagai bukti bahwa aplikasi telah memenuhi seluruh kriteria penerimaan pengguna:

| Peran Penguji | Nama Lengkap | NIP / Jabatan | Tanggal Pengujian | Tanda Tangan |
|---|---|---|:---:|:---:|
| **Koordinator IT / Admin Sistem** | ................................................... | ................................................... | ...... / ...... / 2026 | [ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] |
| **Perwakilan Petugas Pendaftaran** | ................................................... | ................................................... | ...... / ...... / 2026 | [ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] |
| **Perwakilan Dokter / Terapis** | ................................................... | ................................................... | ...... / ...... / 2026 | [ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] |
| **Kepala Seksi / Penanggung Jawab UPT** | ................................................... | ................................................... | ...... / ...... / 2026 | [ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ] |

---

> **Catatan:** Jika terdapat temuan atau ketidaksesuaian (*defect/bug*) selama proses pengujian, catat nomor ID Test dan deskripsi kendala pada kolom catatan untuk segera ditindaklanjuti sebelum implementasi *live* di lingkungan operasional.
