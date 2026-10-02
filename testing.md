# Pengujian (Software Testing)

Pengujian sistem pada aplikasi **Sistem Informasi Pelayanan Terapi & Rehabilitasi Disabilitas (Omah Terapiku)** dilakukan untuk memverifikasi bahwa seluruh kebutuhan fungsional dan teknis yang telah dirumuskan dalam Dokumen Spesifikasi Kebutuhan Perangkat Lunak (SRS) telah diimplementasikan secara tepat. Metodologi pengujian yang digunakan adalah *Black Box Testing* melalui pendekatan *Equivalence Partitioning* dan *Boundary Value Analysis* untuk memastikan setiap antarmuka, alur kerja, validasi logika klinis, serta hak akses multi-peran berjalan tanpa galat. Pengujian mencakup modul portal publik pasien, verifikasi front-office, rekam medis dan asesmen klinis komprehensif (Denver II, GMFM-88, Skala Nyeri), penjadwalan terapis, asisten cerdas AI, hingga laporan eksekutif Dinas Sosial. Seluruh skenario pengujian dieksekusi pada lingkungan pengujian berbasis peramban web modern dengan basis data relasional MySQL terintegrasi. Berdasarkan hasil pengujian keseluruhan, seluruh skenario berhasil memenuhi kriteria penerimaan (*acceptance criteria*) dengan status lulus (*Pass*), sehingga sistem dinyatakan andal dan siap dioperasikan.

---

## Tabel VI.1. Pengujian Modul Autentikasi & Kontrol Hak Akses Multi-Role

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Login & Hak Akses Pengguna (Multi-Role) |
| **Test ID #** | `TC-AUTH-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi fungsionalitas login sistem untuk role Administrator, Dokter/Terapis, Petugas Pendaftaran, serta mencegah akses tidak sah (*unauthorized access*) ke modul terproteksi berdasarkan hak akses masing-masing role. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 09:00 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Apache PHP 8.2 / MySQL / Google Chrome v128+ |
| **Setup** | Akun pengguna untuk role Admin, Terapis, dan Pendaftaran telah terdaftar pada basis data; sesi peramban dalam keadaan bersih (*logged out*). |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka halaman `/login`, masukkan *username* dan *password* yang valid untuk role **Admin**, lalu klik tombol "Masuk". | Sistem berhasil memvalidasi kredensial, membuat sesi autentikasi, dan mengarahkan pengguna ke halaman Dashboard Admin (`/dashboard`) dengan menu lengkap (Master Data, Laporan Eksekutif, Manajemen Pengguna). | [x] | [ ] | [ ] | Sesuai ekspektasi |
| **2** | Lakukan *logout*, buka kembali `/login`, masukkan kredensial untuk role **Dokter / Terapis**, lalu klik tombol "Masuk". | Sistem berhasil login dan mengarahkan ke dashboard klinis; menu yang ditampilkan terbatas pada Rekam Medis, Form Asesmen, Jadwal Terapi, dan Profil (Menu Master Pengguna/Petugas tidak ditampilkan). | [x] | [ ] | [ ] | Sesuai hak akses |
| **3** | Lakukan *logout*, buka kembali `/login`, masukkan kredensial untuk role **Pendaftaran**, lalu klik tombol "Masuk". | Sistem berhasil login dan mengarahkan ke dashboard; pengguna dapat mengakses menu Pendaftaran Online, Booking Sesi, dan Penerima Manfaat, namun dibatasi dari form asesmen medis dan master sistem. | [x] | [ ] | [ ] | Sesuai hak akses |
| **4** | Masukkan *username* terdaftar dengan *password* yang salah pada halaman login, lalu klik tombol "Masuk". | Sistem menolak proses autentikasi, menampilkan pesan peringatan *"Username atau password salah"*, dan tetap berada di halaman login tanpa membuat sesi aktif. | [x] | [ ] | [ ] | Validasi keamanan bekerja |
| **5** | Pengguna dengan role **Pendaftaran** mencoba mengakses rute khusus Admin/Terapis secara langsung via URL (misal: `/rekam/1/assessment` atau `/laporan/eksekutif`). | Sistem mencegat permintaan melalui Middleware `role:Admin,Dokter`, memblokir akses, dan mengembalikan respon *HTTP 403 Forbidden* atau pesan penolakan akses. | [x] | [ ] | [ ] | Proteksi middleware efektif |

**Overall Test Result:** **PASS** (Semua skenario pengujian autentikasi dan otorisasi peran berhasil memenuhi spesifikasi).

---

## Tabel VI.2. Pengujian Modul Pendaftaran Mandiri Pasien Baru (Public Portal)

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Pendaftaran Penerima Manfaat Baru Online |
| **Test ID #** | `TC-REG-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memvalidasi formulir pendaftaran daring publik bagi calon penerima manfaat baru, mencakup pengisian biodata, wali/orang tua, riwayat disabilitas, pemilihan layanan & jadwal, unggah berkas (KK/Resume Medis), serta penerbitan Kode Registrasi dan Bukti Pendaftaran PDF. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 10:15 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Laravel 10 / Google Chrome v128+ / Resolusi Desktop & Mobile |
| **Setup** | Web server aktif, tabel `pendaftaran_pasiens` siap menerima data baru, folder direktori upload berkas memiliki izin tulis (*write permission*). |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka halaman utama Portal Pasien (`/`), klik tombol "Daftar Penerima Manfaat Baru", lalu isi formulir dengan data lengkap dan valid (Nama, NIK 16 digit, No HP, Alamat, Jenis Disabilitas, Layanan Terapi, Tgl Rencana Kunjungan). | Seluruh input formulir terisi dengan benar; dropdown wilayah (Provinsi, Kab/Kota, Kecamatan, Kelurahan) memuat data secara dinamis via API Wilayah. | [x] | [ ] | [ ] | Autocomplete wilayah lancar |
| **2** | Unggah file Kartu Keluarga (KK) dan Dokumen Medis dalam format PDF/JPG dengan ukuran masing-masing < 5MB. | File berhasil diunggah ke formulir, nama file tampil pada area preview, dan tidak ada galat ukuran/tipe berkas. | [x] | [ ] | [ ] | Upload preview berjalan baik |
| **3** | Klik tombol "Kirim Pendaftaran". | Sistem menyimpan data ke basis data dengan status awal *Menunggu Verifikasi*, menghasilkan Kode Registrasi unik (format: `REG-YYYYMMDD-XXXX`), dan memicu notifikasi sistem ke petugas front-office. | [x] | [ ] | [ ] | Kode registrasi otomatis dibuat |
| **4** | Sistem mengarahkan ke halaman ringkasan sukses dan pengguna menekan tombol "Cetak Bukti Pendaftaran". | Halaman mencetak lembar karcis bukti pendaftaran digital/PDF yang memuat QR Code / Barcode, Kode Registrasi, data pasien, serta instruksi verifikasi lanjutan. | [x] | [ ] | [ ] | Lembar cetak rapi & terbaca |
| **5** | Uji validasi batas: Kirim formulir tanpa mengisi field wajib (*Nama Pasien*, *No HP*, *Layanan Terapi*, *Tgl Rencana Kunjungan*) atau unggah file non-dokumen (misal `.exe`). | Sistem menolak pengiriman, menampilkan pesan galat validasi merah di bawah masing-masing field yang belum terisi/salah format, dan mempertahankan input data sebelumnya (*old value*). | [x] | [ ] | [ ] | Validasi client & server aktif |

**Overall Test Result:** **PASS** (Alur pendaftaran mandiri calon penerima manfaat baru berfungsi sempurna dan berkas tersimpan aman).

---

## Tabel VI.3. Pengujian Modul Booking Sesi Terapi & Pelacakan Status Tiket

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Reservasi Sesi Terapi & Lacak Status |
| **Test ID #** | `TC-BOOK-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi proses reservasi jadwal sesi terapi mandiri oleh pasien lama/wali terdaftar menggunakan Nomor Rekam Medis (No RM) atau NIK, pemilihan slot waktu dan terapis, serta fitur pelacakan status registrasi/booking secara *real-time*. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 11:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Laravel 10 / Google Chrome & Mobile Safari |
| **Setup** | Data pasien lama dengan No RM `RM-0001` telah aktif dalam sistem; master data poli dan dokter/terapis telah terkonfigurasi. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Booking Sesi Terapi" pada Portal Pasien, masukkan No RM `RM-0001` atau NIK yang valid, lalu klik "Cari Data Pasien". | Sistem menemukan data pasien dan secara otomatis mengisi nama pasien, tanggal lahir, alamat, serta riwayat layanan terapi sebelumnya. | [x] | [ ] | [ ] | Pencarian instan berfungsi |
| **2** | Pilih Poli/Layanan (misal: *Fisioterapi Pediatrik*), pilih Terapis yang tersedia, pilih tanggal dan jam sesi rencana kunjungan. | Sistem menampilkan ketersediaan slot terapis; jika terapis tidak berhalangan, opsi jam sesi dapat dipilih secara interaktif. | [x] | [ ] | [ ] | Seleksi jadwal interaktif |
| **3** | Klik tombol "Konfirmasi Booking Sesi". | Sistem menyimpan data booking dengan status *Menunggu Persetujuan*, menerbitkan Kode Booking (misal: `BKG-202609-0012`), dan memicu event notifikasi ke dashboard petugas. | [x] | [ ] | [ ] | Data tersimpan dengan aman |
| **4** | Buka halaman "Lacak Status" (`/portal/lacak-status`), masukkan Kode Registrasi / Booking yang baru didapatkan, lalu tekan tombol "Lacak". | Sistem menampilkan *timeline* status verifikasi terkini secara visual (Menunggu Verifikasi $\rightarrow$ Disetujui / Dijadwalkan $\rightarrow$ Selesai), nama petugas verifikator, serta catatan tindak lanjut. | [x] | [ ] | [ ] | Visualisasi status real-time |
| **5** | Uji input No RM yang tidak terdaftar (misal: `RM-999999`) pada formulir booking sesi. | Sistem menampilkan pesan notifikasi *"Data Rekam Medis tidak ditemukan. Silakan lakukan pendaftaran pasien baru terlebih dahulu."* | [x] | [ ] | [ ] | Penanganan error tepat |

**Overall Test Result:** **PASS** (Reservasi sesi terapi mandiri dan penelusuran status berjalan konsisten).

---

## Tabel VI.4. Pengujian Modul Front-Office: Verifikasi & Approval Pendaftaran

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Approval Pendaftaran & Penerbitan No RM |
| **Test ID #** | `TC-FO-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi fungsi petugas pendaftaran dan admin dalam memvalidasi berkas pendaftaran online, menyetujui (*Approve*) dengan *auto-generate* Nomor Rekam Medis & pembuatan akun portal, menolak (*Reject*) dengan alasan, serta sinkronisasi data master pasien. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 13:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Dashboard Admin & Petugas Pendaftaran |
| **Setup** | Login sebagai Petugas Pendaftaran; terdapat 1 data pendaftaran baru berstatus *Menunggu Verifikasi* di tabel `pendaftaran_pasiens`. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Pendaftaran Online" (`/pendaftaran-online`), pilih salah satu entri pendaftaran, lalu klik tombol "Detail / Show". | Halaman menampilkan rincian komprehensif calon pasien, biodata wali, foto/file KK, resume medis, dan tombol aksi (*Setujui* / *Tolak*). | [x] | [ ] | [ ] | Berkas terlampir dapat diakses |
| **2** | Klik tombol "Setujui Pendaftaran", tentukan UPT Penanganan, pilih Terapis Penanggung Jawab, lalu klik "Konfirmasi Setujui". | Status pendaftaran berubah menjadi `Disetujui`; sistem otomatis memasukkan data ke tabel Master Pasien (`pasiens`), menerbitkan Nomor RM baru secara berurutan, dan membuat akun login portal pasien. | [x] | [ ] | [ ] | Transaksi DB atomik & berhasil |
| **3** | Buka menu "Data Penerima Manfaat" (`/penerima-manfaat`) dan lakukan pencarian nama pasien yang baru disetujui. | Data pasien baru telah terdaftar di master data penerima manfaat lengkap dengan Nomor RM baru dan siap dijadwalkan sesi rekam terapinya. | [x] | [ ] | [ ] | Sinkronisasi data akurat |
| **4** | Pilih pendaftaran lain dengan data tidak valid, klik tombol "Tolak Pendaftaran", masukkan alasan penolakan (misal: *"File KK tidak terbaca"*), lalu konfirmasi. | Status pendaftaran berubah menjadi `Ditolak`; alasan penolakan tersimpan di database dan langsung terbaca saat calon pasien melakukan pelacakan status. | [x] | [ ] | [ ] | Catatan penolakan tersimpan |
| **5** | Klik tombol "Ekspor CSV" pada tabel Pendaftaran Online dan Booking Sesi. | Sistem mengunduh file spreadsheet `.csv` yang memuat seluruh rekapan data pendaftaran sesuai filter tanggal/status yang dipilih. | [x] | [ ] | [ ] | Ekspor file berjalan lancar |

**Overall Test Result:** **PASS** (Verifikasi dan persetujuan registrasi front-office terintegrasi sempurna dengan master pasien).

---

## Tabel VI.5. Pengujian Modul Penjadwalan & Kalender Terapi

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Kalender Jadwal & Deteksi Bentrok Sesi |
| **Test ID #** | `TC-SCHED-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi visualisasi kalender sesi terapi terapis, penjadwalan kunjungan rekam terapi, serta mekanisme deteksi bentrok jadwal (*conflict detection*) saat seorang terapis dijadwalkan pada waktu yang bersamaan. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 14:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / FullCalendar JS / AJAX Endpoints |
| **Setup** | Login sebagai Admin / Terapis; terdapat jadwal sesi aktif untuk Terapis A pada tanggal tertentu pukul 09:00 - 10:00 WIB. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Jadwal Terapi" (`/jadwal-terapi`). | Kalender interaktif FullCalendar berhasil dimuat dengan indikator warna sesi sesuai status (Terjadwal, Selesai, Dibatalkan). | [x] | [ ] | [ ] | Antarmuka responsif |
| **2** | Filter kalender berdasarkan Terapis dan Ruangan/UPT tertentu. | Tampilan kalender secara instan memfilter dan hanya menampilkan agenda sesi yang sesuai dengan kriteria filter yang dipilih. | [x] | [ ] | [ ] | Filter AJAX bekerja cepat |
| **3** | Klik salah satu entri agenda pada kalender. | Muncul modal detail sesi yang menampilkan Nama Pasien, No RM, Layanan Terapi, Terapis, Waktu Pelaksanaan, dan tautan menuju Rekam Medis terkait. | [x] | [ ] | [ ] | Pop-up modal akurat |
| **4** | Tambah jadwal kunjungan baru pada menu Rekam Medis dengan memilih Terapis A pada waktu yang sama persis dengan sesi yang sudah ada. | Sistem memicu fungsi validasi ketersediaan terapis (`/check-jadwal-terapis`) dan menampilkan notifikasi peringatan bentrok jadwal terapis. | [x] | [ ] | [ ] | Deteksi tabrakan jadwal sukses |

**Overall Test Result:** **PASS** (Manajemen kalender jadwal dan proteksi jadwal ganda bekerja dengan akurat).

---

## Tabel VI.6. Pengujian Modul Pelayanan Klinis: Rekam Medis, SOAP & Tindakan

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Rekam Terapi, Catatan SOAP & Diagnosa ICD-10 |
| **Test ID #** | `TC-CLINIC-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi pencatatan rekam terapi oleh Dokter/Terapis, pengisian catatan perkembangan SOAP (*Subjective, Objective, Assessment, Plan*), penetapan tindakan terapi, integrasi kode diagnosa ICD-10, serta cetak lembar rekam medis. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 15:15 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Modul Rekam Medis Klinis |
| **Setup** | Login sebagai Dokter/Terapis; terdapat data kunjungan pasien berstatus *Antrian / Sedang Berjalan*. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Rekam Medis", pilih data kunjungan pasien, lalu klik tombol "Detail & Pemeriksaan". | Halaman rekam terapi terbuka menampilkan data identitas pasien, riwayat kunjungan terdahulu, tab formulir SOAP, tab Tindakan, dan tab Diagnosa ICD-10. | [x] | [ ] | [ ] | Halaman memuat lengkap |
| **2** | Pada tab Pemeriksaan SOAP, isi kolom *Subjektif* (Keluhan), *Objektif* (Tanda Vital & Kondisi Fisik), *Asesmen* (Kesimpulan Klinis), dan *Planning* (Rencana Terapi), lalu klik "Simpan SOAP". | Data SOAP tersimpan ke basis data secara asinkron tanpa *reload* halaman penuh dan muncul notifikasi sukses. | [x] | [ ] | [ ] | Simpan instan & aman |
| **3** | Pada tab Tindakan Terapi, pilih jenis tindakan master (misal: *Sensory Integration Therapy* atau *Latihan Motorik Kasar*), masukkan durasi dan keterangan, lalu klik "Tambah Tindakan". | Tindakan masuk ke dalam daftar tabel tindakan rekam medis pasien beserta kalkulasi biaya/layanan secara benar. | [x] | [ ] | [ ] | Penambahan tindakan tepat |
| **4** | Pada tab Diagnosa ICD-10, ketik kata kunci kode/penyakit (misal: `F84.0` atau `Cerebral Palsy`), pilih dari hasil pencarian dropdown, lalu simpan. | Kode diagnosa ICD-10 dan deskripsi terhubung ke rekam kunjungan pasien bersangkutan. | [x] | [ ] | [ ] | Autocomplete ICD-10 lancar |
| **5** | Ubah status kunjungan menjadi `Selesai` dan klik tombol "Cetak Ringkasan SOAP". | Status kunjungan terupdate dan sistem mengunduh dokumen cetak PDF lembar SOAP resmi berstempel dan bertanda tangan terapis. | [x] | [ ] | [ ] | Lembar cetak rapi sesuai standar |

**Overall Test Result:** **PASS** (Alur pendokumentasian terapi klinis, SOAP, tindakan, dan diagnosa ICD-10 beroperasi tanpa kendala).

---

## Tabel VI.7. Pengujian Modul Asesmen Klinis Khusus (Denver II, GMFM-88, Nyeri & Home Program)

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Form Asesmen Komprehensif (Denver II & GMFM) |
| **Test ID #** | `TC-ASSESS-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi pengisian instrumen asesmen perkembangan anak Denver II (4 sektor: Personal Sosial, Motorik Halus, Bahasa, Motorik Kasar), kalkulasi persentase skor GMFM-88 (Dimensi A-E), Skala Nyeri (Wong-Baker/NRS), Asesmen Neurologis, serta perumusan Panduan Latihan Rumahan (*Home Program*). |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 16:00 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Modul Rekam Assessment |
| **Setup** | Login sebagai Terapis; buka halaman asesmen rekam medis pasien pediatrik (`/rekam/{id}/assessment`). |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka form asesmen klinis, pilih instrumen **Denver II**, masukkan hasil uji item tiap sektor (*Pass*, *Fail*, *Refusal*, *No Opportunity*). | Sistem secara otomatis menghitung rekapitulasi jumlah *Pass/Fail* per sektor dan menentukan interpretasi hasil (*Normal*, *Suspect*, atau *Untestable*). | [x] | [ ] | [ ] | Kalkulasi Denver II otomatis |
| **2** | Pilih instrumen **GMFM-88**, masukkan nilai skor (skala 0-3) untuk Dimensi A (Berbaring & Berguling), B (Duduk), C (Merangkak & Berlutut), D (Berdiri), dan E (Berjalan, Berlari & Melompat). | Sistem secara otomatis menghitung persentase skor per dimensi dan Total Score persentase GMFM secara *real-time* via Javascript. | [x] | [ ] | [ ] | Algoritma kalkulasi skor akurat |
| **3** | Pilih instrumen **Skala Nyeri**, tentukan derajat nyeri menggunakan visual *Wong-Baker Faces Scale* / skala angka 0-10, serta pilih lokasi nyeri pada diagram tubuh. | Nilai skala nyeri, kategori nyeri (Ringan/Sedang/Berat), dan deskripsi lokasi tersimpan dengan benar. | [x] | [ ] | [ ] | Visualisasi skala nyeri interaktif |
| **4** | Isi bagian **Panduan Latihan Rumahan (Home Program)** yang memuat instruksi latihan postur, frekuensi latihan harian, dan pantangan bagi orang tua/keluarga di rumah, lalu klik "Simpan Asesmen". | Seluruh data asesmen multidimensi tersimpan ke tabel `rekam_assessments` dan `rekams` secara utuh tanpa pemotongan data (*data truncation*). | [x] | [ ] | [ ] | Data tersimpan lengkap |
| **5** | Klik tombol "Cetak Form Asesmen Lengkap" dan "Cetak Panduan Home Program". | Sistem mengunduh lembar laporan asesmen komprehensif berformat PDF dan lembar edukasi Home Program siap cetak untuk diberikan ke keluarga pasien. | [x] | [ ] | [ ] | Format cetak profesional |

**Overall Test Result:** **PASS** (Perhitungan instrumen asesmen terstandarisasi Denver II, GMFM-88, dan formulasi Home Program berjalan presisi).

---

## Tabel VI.8. Pengujian Modul Portal Pasien & Keluarga (Self-Service Monitoring)

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Dashboard Pasien, Grafik Milestone & Dokumen |
| **Test ID #** | `TC-PORTAL-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi fungsionalitas Portal Pasien & Keluarga yang memungkinkan orang tua/wali login menggunakan Nomor RM / NIK dan Tanggal Lahir untuk memantau grafik tumbuh kembang anak, melihat riwayat terapi, dan mengunduh berkas laporan secara mandiri. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 17:00 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Chart.js / Google Chrome Mobile & Desktop |
| **Setup** | Data pasien `RM-0001` telah memiliki minimal 2 riwayat rekam medis dan asesmen klinis Denver II / GMFM. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka halaman login Portal Pasien (`/portal`), masukkan Nomor RM `RM-0001` dan tanggal lahir pasien yang terdaftar, lalu klik "Masuk Portal". | Pasien/Wali berhasil terautentikasi dan diarahkan ke Dashboard Portal Keluarga (`/portal/dashboard`). | [x] | [ ] | [ ] | Login portal lancar |
| **2** | Periksa visualisasi grafik pada menu "Grafik Denver II" (`/portal/denver`) dan "Grafik GMFM" (`/portal/gmfm`). | Chart.js merender kurva grafik perkembangan skor pasien dari sesi ke sesi secara kronologis dengan legenda yang jelas dan informatif. | [x] | [ ] | [ ] | Visualisasi tren mudah dipahami |
| **3** | Buka menu "Panduan Home Program" (`/portal/home-program`). | Halaman menampilkan panduan latihan rumahan yang diresepkan oleh terapis terakhir beserta tips stimulasi mandiri di rumah. | [x] | [ ] | [ ] | Edukasi keluarga tampil jelas |
| **4** | Buka menu "Dokumen & Riwayat" (`/portal/dokumen`), lalu klik tombol unduh pada salah satu riwayat rekam medis. | Pasien/wali dapat mengunduh dokumen resume medis atau resep latihan berformat PDF langsung ke perangkat mereka. | [x] | [ ] | [ ] | Unduh mandiri berhasil |
| **5** | Lakukan *logout* dari portal pasien, kemudian coba akses URL `/portal/dashboard` secara langsung. | Sistem mendeteksi ketiadaan sesi aktif portal dan otomatis mengalihkan pengguna kembali ke halaman login portal (`/portal`). | [x] | [ ] | [ ] | Sesi terproteksi |

**Overall Test Result:** **PASS** (Portal pasien dan keluarga berfungsi sebagai sarana transparansi rekam perkembangan terapi yang andal).

---

## Tabel VI.9. Pengujian Modul Asisten Cerdas AI (AI Assistant Chatbot)

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Chatbot AI Layanan Informasi & Terapi |
| **Test ID #** | `TC-AI-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi fungsionalitas asisten virtual cerdas berbasis AI pada antarmuka publik untuk menjawab pertanyaan umum seputar rehabilitasi disabilitas, konsultasi alur layanan Omah Terapiku, dan panduan stimulasi awal secara interaktif. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 18:30 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / API AI Assistant / Axios AJAX |
| **Setup** | Widget AI Assistant aktif di pojok kanan bawah halaman portal publik; koneksi jaringan internet aktif. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Klik ikon widget AI Chatbot di pojok kanan bawah halaman utama. | Jendela pop-up obrolan AI terbuka dengan animasi halus, menampilkan pesan sambutan selamat datang dan opsi topik cepat (*quick prompts*). | [x] | [ ] | [ ] | Antarmuka interaktif responsif |
| **2** | Kirim pesan pertanyaan umum: *"Bagaimana alur pendaftaran terapi anak di Omah Terapiku?"*. | Sistem memproses input via endpoint `/ai-assistant/chat`, menampilkan indikator *typing*, dan mengembalikan jawaban yang terstruktur mengenai syarat dan alur pendaftaran. | [x] | [ ] | [ ] | Respon cepat (< 3 detik) |
| **3** | Kirim pesan klinis edukatif: *"Apa perbedaan fisioterapi dan terapi okupasi untuk anak cerebral palsy?"*. | AI memberikan penjelasan edukatif yang akurat, santun, dan menyertakan saran untuk mengonsultasikannya langsung dengan terapis ahli di Omah Terapiku. | [x] | [ ] | [ ] | Jawaban kontekstual & aman |
| **4** | Uji pengiriman pesan kosong atau karakter spasi saja. | Tombol kirim tidak aktif (*disabled*) atau sistem mencegah pengiriman tanpa memicu galat aplikasi. | [x] | [ ] | [ ] | Validasi input chat berfungsi |

**Overall Test Result:** **PASS** (Asisten virtual AI merespon dengan cepat, kontekstual, dan meningkatkan aksesibilitas informasi layanan).

---

## Tabel VI.10. Pengujian Modul Laporan Eksekutif Dinas Sosial & Filter Multi-UPT

| Atribut | Keterangan | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| **Test Writer** | Tim Pengembang Omah Terapiku | **Test Case Name** | Pengujian Dashboard Eksekutif, Filter UPT & Cetak Rekap |
| **Test ID #** | `TC-EXEC-01` | **Type** | [ ] White Box &nbsp;&nbsp;&nbsp;&nbsp; [x] Black Box |
| **Description** | Memverifikasi fungsionalitas pelaporan data eksekutif Dinas Sosial, filter multi-wilayah/UPT (Sentra Terpadu), agregasi metrik kunjungan, demografi disabilitas (Desil, Usia, Jenis Disabilitas), serta ekspor cetak PDF Laporan Eksekutif. |
| **Tester Information** | Tim QA & Penguji Sistem | **Date / Time** | 2026-09-29 / 19:15 WIB |
| **Software Ver / Env** | Omah Terapiku v1.0 / Modul Laporan Eksekutif / Dompdf Generator |
| **Setup** | Login sebagai role **Admin**; basis data telah memuat data riwayat kunjungan dan penerima manfaat dari berbagai UPT. |

### Langkah-Langkah Pengujian

| Step | Action | Expected Result | Pass | Fail | N/A | Comments |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| **1** | Buka menu "Laporan Eksekutif" (`/laporan/eksekutif`). | Dashboard analitik menampilkan kartu KPI (Total Penerima Manfaat, Total Sesi Terapi Bulan Ini, Rata-rata Skor GMFM, Pasien Aktif), serta diagram distribusi disabilitas & desil ekonomi. | [x] | [ ] | [ ] | Metrik data tampil lengkap |
| **2** | Gunakan dropdown filter UPT di bagian atas (misal memilih UPT tertentu atau *"Semua UPT"*). | Seluruh widget statistik, tabel ringkasan, dan grafik data teragregasi ulang secara otomatis menyesuaikan cakupan wilayah UPT yang dipilih. | [x] | [ ] | [ ] | Filter multi-UPT reaktif |
| **3** | Tentukan rentang tanggal periode laporan (misal: *01 September 2026 s/d 29 September 2026*), lalu klik "Terapkan Filter". | Tabel data rekapitulasi memperbarui daftar kunjungan dan tindakan terapi hanya pada periode tanggal tersebut. | [x] | [ ] | [ ] | Filter tanggal akurat |
| **4** | Klik tombol "Cetak PDF Laporan Eksekutif" (`/laporan/eksekutif/print`). | Sistem men-generate dokumen resmi Laporan Eksekutif Rekapitulasi Pelayanan Terapi & Rehabilitasi Disabilitas berformat PDF dengan kop dinas resmi, tabel statistik, dan kolom pengesahan pimpinan. | [x] | [ ] | [ ] | Dokumen PDF rapi & siap cetak |

**Overall Test Result:** **PASS** (Dashboard eksekutif dan pelaporan rekapitulasi data dinas sosial beroperasi secara optimal dan akurat).

---

## Ringkasan Rekapitulasi Hasil Pengujian

| No | ID Pengujian | Modul & Skenario Pengujian | Jumlah Kasus Uji | Hasil (*Status*) |
| :---: | :---: | :--- | :---: | :---: |
| 1 | `TC-AUTH-01` | Autentikasi & Kontrol Hak Akses Multi-Role | 5 Langkah | **LULUS (PASS)** |
| 2 | `TC-REG-01` | Pendaftaran Mandiri Pasien Baru (Public Portal) | 5 Langkah | **LULUS (PASS)** |
| 3 | `TC-BOOK-01` | Booking Sesi Terapi & Pelacakan Status Tiket | 5 Langkah | **LULUS (PASS)** |
| 4 | `TC-FO-01` | Verifikasi Front-Office & Approval Pendaftaran Pasien | 5 Langkah | **LULUS (PASS)** |
| 5 | `TC-SCHED-01` | Penjadwalan & Kalender Terapi (Deteksi Bentrok) | 4 Langkah | **LULUS (PASS)** |
| 6 | `TC-CLINIC-01` | Pelayanan Klinis: Rekam Medis, SOAP, Tindakan & ICD-10 | 5 Langkah | **LULUS (PASS)** |
| 7 | `TC-ASSESS-01` | Asesmen Klinis Khusus: Denver II, GMFM-88, Nyeri & Home Program | 5 Langkah | **LULUS (PASS)** |
| 8 | `TC-PORTAL-01` | Portal Pasien & Keluarga (Monitoring Mandiri & Riwayat) | 5 Langkah | **LULUS (PASS)** |
| 9 | `TC-AI-01` | Asisten Cerdas AI (Virtual Therapy Chatbot) | 4 Langkah | **LULUS (PASS)** |
| 10 | `TC-EXEC-01` | Laporan Eksekutif Dinas Sosial & Filter Multi-UPT | 4 Langkah | **LULUS (PASS)** |
| **Total** | | **10 Modul Pengujian Fungsional Utama** | **47 Kasus Uji** | **Tingkat Kelulusan: 100%** |

---

## Simpulan Pengujian

Pengujian fungsionalitas aplikasi **Omah Terapiku** yang dilakukan dengan metode *Black Box Testing* telah berhasil mengevaluasi seluruh modul inti mulai dari sisi publik (portal pendaftaran, booking sesi, pelacakan status, dan monitoring perkembangan anak) hingga sisi backoffice (verifikasi pendaftaran, rekam medis klinis, kalkulasi asesmen Denver II & GMFM-88, penjadwalan terapis, dan pelaporan eksekutif). Seluruh 10 skenario pengujian dengan total 47 langkah kasus uji menunjukkan hasil yang sesuai dengan kriteria penerimaan yang diharapkan (*Expected Result*) tanpa ditemukannya galat fatal (*zero critical defects*). Sistem kontrol hak akses multi-role terbukti mampu mengamankan data rekam medis sensitif sesuai batasan wewenang pengguna. Integrasi perhitungan otomatis skor asesmen perkembangan dan fitur *Home Program* memberikan nilai tambah yang signifikan bagi terapis maupun keluarga penerima manfaat dalam proses rehabilitasi. Dengan demikian, perangkat lunak Sistem Informasi Layanan Terapi & Rehabilitasi Disabilitas Omah Terapiku disimpulkan telah memenuhi seluruh spesifikasi kebutuhan fungsional dan teknis, beroperasi dengan stabil, dan layak untuk diimplementasikan pada lingkungan produksi Dinas Sosial.
