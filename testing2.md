# Pengujian (Software Testing) — Kasus Uji Esensial

Pengujian sistem pada aplikasi **Omah Terapiku** difokuskan pada pengujian fungsionalitas inti (*core features*) yang mencakup seluruh alur bisnis utama sistem pelayanan terapi disabilitas Dinas Sosial. Metode yang diterapkan adalah *Black Box Testing* untuk memverifikasi kesesuaian antara masukan (*input*) pengguna dengan keluaran (*output*) serta perilaku sistem yang diharapkan tanpa menguji struktur kode internal. Pengujian ini berfokus pada 5 proses vital: autentikasi multi-peran, pendaftaran mandiri terintegrasi approval loket, penjadwalan sesi bebas bentrok, pencatatan rekam medis & asesmen perkembangan anak (Denver II & GMFM-88), serta portal monitoring keluarga dan pelaporan eksekutif. Setiap skenario diuji pada peramban web modern dengan kondisi prasyarat basis data yang telah disiapkan. Hasil evaluasi menunjukkan seluruh fungsi utama berjalan dengan stabil dan memenuhi kriteria kelulusan (*Pass* 100%).

---

## Tabel VI.1. Pengujian Autentikasi & Kontrol Hak Akses Multi-Role

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Login & Otorisasi Hak Akses Pengguna |
| **Test ID #** | `TC-CORE-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi proses autentikasi akun pengguna dan pembatasan hak akses antarmuka untuk role Admin, Terapis/Dokter, dan Petugas Pendaftaran guna mencegah akses tidak berwenang. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 09:00 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Apache PHP 8.2 / MySQL / Google Chrome v128+ |
| **Setup** | Akun pengguna untuk role Admin, Terapis, dan Pendaftaran telah terdaftar pada sistem; sesi peramban telah di-logout. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka halaman `/login`, masukkan *username* dan *password* valid untuk role **Admin**, lalu klik "Masuk". | Sistem berhasil login dan mengarahkan ke Dashboard Utama dengan hak akses penuh ke seluruh menu (Master Data, Laporan Eksekutif, Pengguna). | [x] | [ ] | [ ] | Akses Admin terbuka lengkap |
| **2** | Buka `/login`, masukkan kredensial valid untuk role **Dokter / Terapis**, lalu klik "Masuk". | Sistem login dan mengarahkan ke dashboard klinis; menu yang muncul terbatas pada Rekam Medis, Form Asesmen, dan Jadwal Terapi. | [x] | [ ] | [ ] | Menu terfilter sesuai peran |
| **3** | Buka `/login`, masukkan kredensial valid untuk role **Pendaftaran**, lalu klik "Masuk". | Sistem login dan mengarahkan ke dashboard front-office (Pendaftaran Online, Booking Sesi, Master Penerima Manfaat). | [x] | [ ] | [ ] | Menu terfilter sesuai peran |
| **4** | Masukkan kredensial yang salah (*password keliru*) pada halaman login. | Sistem menolak autentikasi, menampilkan pesan *"Username atau password salah"*, dan tidak membuat sesi login. | [x] | [ ] | [ ] | Proteksi kredensial bekerja |
| **5** | Pengguna non-Admin (role Pendaftaran) mencoba mengakses URL proteksi khusus (misal: `/laporan/eksekutif` atau `/omahterapiku`). | Sistem mencegat melalui middleware otorisasi dan menampilkan respon penolakan akses (*HTTP 403 Forbidden*). | [x] | [ ] | [ ] | Proteksi rute efektif |

**Overall Test Result:** **PASS** (Autentikasi dan pembagian hak akses multi-role berjalan aman dan sesuai spesifikasi).

---

## Tabel VI.2. Pengujian Pendaftaran Pasien Baru & Approval Front-Office

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pendaftaran Online Mandiri & Persetujuan Loket |
| **Test ID #** | `TC-CORE-02` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi alur pendaftaran mandiri oleh wali pasien di portal publik, unggah berkas KK/dokumen, penerbitan Kode Registrasi, hingga verifikasi & *Approval* oleh petugas loket yang menghasilkan Nomor Rekam Medis (No RM) baru otomatis. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 10:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Laravel 10 / Google Chrome & Mobile Browser |
| **Setup** | Web server aktif, tabel `pendaftaran_pasiens` siap menerima data, login sebagai Petugas Pendaftaran pada sesi terpisah. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka Portal Publik (`/`), klik "Daftar Penerima Manfaat Baru", isi biodata lengkap pasien & orang tua, pilih jenis disabilitas, layanan terapi, serta unggah file KK (PDF/JPG). | Formulir terisi lengkap, berkas terunggah tanpa galat, dan dropdown wilayah terisi otomatis via API. | [x] | [ ] | [ ] | Form interaktif berjalan lancar |
| **2** | Klik tombol "Kirim Pendaftaran" pada akhir formulir. | Data tersimpan dengan status *Menunggu Verifikasi*, sistem menghasilkan Kode Registrasi unik (misal: `REG-20260929-001`), dan menyediakan tombol "Cetak Bukti Pendaftaran". | [x] | [ ] | [ ] | Kode tiket & cetak PDF berhasil |
| **3** | Buka halaman "Lacak Status" (`/portal/lacak-status`), masukkan Kode Registrasi yang didapat. | Halaman menampilkan status pendaftaran secara *real-time* dengan *timeline* tahapan verifikasi. | [x] | [ ] | [ ] | Pelacakan status akurat |
| **4** | Login sebagai **Petugas Pendaftaran**, buka menu `/pendaftaran-online`, buka detail pendaftaran tadi, lalu klik "Setujui Pendaftaran". | Status berubah menjadi `Disetujui`, data otomatis masuk ke Master Pasien (`pasiens`), terbit Nomor RM baru, dan akun portal pasien aktif. | [x] | [ ] | [ ] | Integrasi master data sukses |

**Overall Test Result:** **PASS** (Alur registrasi mandiri hingga penerbitan rekam medis di loket pendaftaran berfungsi sempurna).

---

## Tabel VI.3. Pengujian Penjadwalan Terapi & Pencegahan Bentrok Jadwal

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Manajemen Jadwal Kalender & Deteksi Tabrakan Sesi |
| **Test ID #** | `TC-CORE-03` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi penjadwalan sesi terapi pada kalender operasional terapis, pemfilteran jadwal interaktif, serta validasi pencegahan jadwal ganda (*conflict detection*) pada slot waktu dan terapis yang sama. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 13:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / FullCalendar JS / AJAX Endpoints |
| **Setup** | Login sebagai Admin / Terapis; terdapat jadwal sesi aktif untuk Terapis A pada tanggal tertentu pukul 09:00 - 10:00 WIB. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Jadwal Terapi" (`/jadwal-terapi`). | Kalender interaktif termuat dengan indikator warna status sesi (Terjadwal, Selesai, Dibatalkan). | [x] | [ ] | [ ] | Visualisasi kalender jelas |
| **2** | Filter tampilan kalender berdasarkan Nama Terapis atau Layanan Terapi. | Kalender memfilter tampilan agenda secara instan via AJAX sesuai filter yang dipilih. | [x] | [ ] | [ ] | Filter data responsif |
| **3** | Klik salah satu agenda sesi pada kalender. | Muncul modal detail sesi yang menampilkan Nama Pasien, No RM, Layanan, Terapis, dan tautan Rekam Medis. | [x] | [ ] | [ ] | Informasi detail akurat |
| **4** | Coba tambahkan sesi kunjungan baru pada terapis yang sama di jam yang telah terisi (`09:00 - 10:00`). | Sistem memicu fungsi validasi (`checkTerapisAvailability`) dan menampilkan peringatan bahwa terapis sedang bertugas pada jam tersebut. | [x] | [ ] | [ ] | Proteksi bentrok jadwal aktif |

**Overall Test Result:** **PASS** (Manajemen kalender jadwal dan proteksi jadwal ganda bekerja dengan tepat).

---

## Tabel VI.4. Pengujian Pelayanan Klinis, SOAP & Asesmen Terstandarisasi

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Rekam Terapi, SOAP, Diagnosa ICD-10 & Asesmen Denver/GMFM |
| **Test ID #** | `TC-CORE-04` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi pencatatan log harian SOAP oleh terapis, input tindakan, diagnosa ICD-10, evaluasi perkembangan Denver II (4 sektor), kalkulasi persentase skor GMFM-88, dan pembuatan instruksi *Home Program*. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 15:00 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Modul Rekam Medis & Assessment Klinis |
| **Setup** | Login sebagai Dokter/Terapis; buka rekam kunjungan pasien aktif (`/rekam/{id}/assessment`). |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka halaman pemeriksaan pasien, isi formulir SOAP (*Subjektif, Objektif, Asesmen, Planning*), lalu klik "Simpan SOAP". | Catatan SOAP tersimpan ke database secara asinkron (AJAX) dan memunculkan notifikasi sukses. | [x] | [ ] | [ ] | Simpan catatan SOAP berhasil |
| **2** | Tambahkan jenis tindakan terapi (misal: *Sensory Integration*) dan cari kode ICD-10 (misal: `F84.0` / *Autism*). | Tindakan terapi dan kode diagnosa ICD-10 berhasil terhubung ke rekam kunjungan pasien bersangkutan. | [x] | [ ] | [ ] | Pencarian & simpan ICD-10 akurat |
| **3** | Buka form asesmen Denver II, isi skor *Pass/Fail* pada sektor uji (Personal Sosial, Motorik Halus, Bahasa, Motorik Kasar). | Sistem otomatis merekap hasil per sektor dan menyimpulkan interpretasi perkembangan (*Normal / Suspect*). | [x] | [ ] | [ ] | Kalkulasi otomatis Denver II tepat |
| **4** | Buka form GMFM-88, masukkan skor item Dimensi A s/d E, isi form *Home Program* (latihan rumahan), lalu klik "Simpan Asesmen". | Sistem mengkalkulasi persentase skor total GMFM-88 secara otomatis, dan seluruh data tersimpan lengkap. | [x] | [ ] | [ ] | Algoritma skor GMFM & Home Program valid |
| **5** | Klik tombol "Cetak Ringkasan SOAP" dan "Cetak Asesmen Lengkap". | Sistem menghasilkan dan mengunduh berkas PDF resmi lembar SOAP dan laporan asesmen klinis siap cetak. | [x] | [ ] | [ ] | Dokumen PDF rapi & lengkap |

**Overall Test Result:** **PASS** (Seluruh fitur pencatatan klinis, kalkulasi skor asesmen instrumen, dan cetak dokumen rekam terapi berjalan presisi).

---

## Tabel VI.5. Pengujian Portal Monitoring Pasien & Laporan Eksekutif

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Portal Monitoring Keluarga & Dashboard Eksekutif Dinsos |
| **Test ID #** | `TC-CORE-05` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi akses portal monitoring mandiri bagi wali pasien (grafik Denver/GMFM & unduh Home Program) serta dashboard pelaporan eksekutif Dinas Sosial dengan filter multi-UPT dan cetak rekapitulasi PDF. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 16:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Chart.js / Dompdf Generator |
| **Setup** | Sesi 1: Login Portal Pasien menggunakan No RM & Tanggal Lahir; Sesi 2: Login Admin pada Dashboard Eksekutif. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka Portal Pasien (`/portal`), masukkan No RM dan Tanggal Lahir pasien yang telah memiliki riwayat asesmen. | Pengguna berhasil masuk ke dashboard portal keluarga (`/portal/dashboard`). | [x] | [ ] | [ ] | Login portal keluarga lancar |
| **2** | Buka menu Grafik Denver (`/portal/denver`) dan menu Panduan Home Program (`/portal/home-program`). | Grafik tren perkembangan milestone anak tampil dengan jelas via Chart.js, dan panduan latihan rumah dapat dibaca/diunduh. | [x] | [ ] | [ ] | Transparansi rekam medis terpenuhi |
| **3** | Login sebagai **Admin**, buka menu "Laporan Eksekutif" (`/laporan/eksekutif`), lalu ubah pilihan filter UPT / Rentang Tanggal. | Seluruh kartu KPI (Total Kunjungan, Rata-rata Skor, Pasien Aktif) dan grafik distribusi memperbarui data secara dinamis. | [x] | [ ] | [ ] | Agregasi data & filter UPT sukses |
| **4** | Klik tombol "Cetak PDF Laporan Eksekutif" (`/laporan/eksekutif/print`). | Sistem mengunduh lembar Laporan Eksekutif Rekapitulasi Pelayanan Terapi & Rehabilitasi Disabilitas berformat PDF resmi siap tanda tangan. | [x] | [ ] | [ ] | Rekap PDF resmi terbit sempurna |

**Overall Test Result:** **PASS** (Portal monitoring keluarga dan modul pelaporan analitik eksekutif Dinas Sosial berfungsi optimal).

---

## Ringkasan Rekapitulasi Pengujian Inti

| No | ID Pengujian | Modul & Skenario Pengujian Inti | Jumlah Langkah Uji | Hasil (*Status*) |
| :---: | :---: | :--- | :---: | :---: |
| 1 | `TC-CORE-01` | Autentikasi & Kontrol Hak Akses Multi-Role | 5 Langkah | **LULUS (PASS)** |
| 2 | `TC-CORE-02` | Pendaftaran Pasien Baru Online & Approval Loket Front-Office | 4 Langkah | **LULUS (PASS)** |
| 3 | `TC-CORE-03` | Penjadwalan Terapi & Pencegahan Bentrok Jadwal Kalender | 4 Langkah | **LULUS (PASS)** |
| 4 | `TC-CORE-04` | Pelayanan Klinis, SOAP & Asesmen Terstandarisasi (Denver/GMFM) | 5 Langkah | **LULUS (PASS)** |
| 5 | `TC-CORE-05` | Portal Monitoring Pasien & Laporan Eksekutif Dinas Sosial | 4 Langkah | **LULUS (PASS)** |
| **Total** | | **5 Modul Pengujian Fungsional Utama** | **22 Kasus Uji** | **Tingkat Kelulusan: 100%** |

---

## Simpulan Pengujian

Pengujian fungsionalitas inti pada aplikasi **Omah Terapiku** dengan metode *Black Box Testing* telah berhasil menguji 5 pilar utama sistem yang merepresentasikan seluruh siklus layanan terapi disabilitas. Seluruh skenario pengujian yang mencakup 22 langkah kasus uji terbukti berhasil dieksekusi dengan status lulus (*Pass*) tanpa kegagalan sistem. Mekanisme keamanan login dan pembagian hak akses terbukti mampu membatasi wewenang antarmuka tiap peran dengan ketat. Alur pendaftaran mandiri yang terhubung dengan verifikasi front-office mampu mempercepat penerbitan nomor rekam medis baru secara akurat. Modul asesmen klinis (Denver II dan GMFM-88) bekerja presisi dalam kalkulasi otomatis skor tumbuh kembang anak, sementara portal keluarga dan laporan eksekutif mempermudah pemantauan serta rekapitulasi data pimpinan. Berdasarkan hasil pengujian terfokus ini, aplikasi Omah Terapiku dinyatakan andal, stabil, dan memenuhi seluruh kriteria kelayakan untuk digunakan secara operasional.
