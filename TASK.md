### 1. Refactoring Alur & Layout Rekam Medis (SOAP vs. Asesmen)
- [x] **Pemisahan Tab Asesmen & Log Sesi Harian**
    - Buat 2 tab utama di halaman Detail Penerima Manfaat: **Tab 1: Asesmen Baseline & Re-evaluasi** dan **Tab 2: Log Sesi Terapi (SOAP)**.
- [x] **Cleanup Kolom Aksi SOAP**
    - Hapus tombol _tagging_ warna-warni yang bertumpuk (`[Assesment]`, `[(O) Fisik]`, `[(A) ICD]`, `[(P) Plan]`) di tabel riwayat.
    - Ganti dengan 1 tombol aksi utilitas tunggal (tombol `<Detail Catatan Sesi>` / `<Cetak>`) yang membuka _drawer_ atau _modal pop-up_.
- [x] **Penyesuaian Label Tombol Utama**
    - Ubah label tombol **"Tambah Rekam Medis"** di bagian header menjadi **"Input Sesi Terapi Baru"** agar lebih intuitif bagi terapis.
### 2. Optimasi Form Asesmen Terapi (15 Bagian Klinis)
- [x] **Sistem Navigasi & Grouping Tab Asesmen**
    - Kelompokkan 15 _pill tabs_ asesmen ke dalam 4 kategori besar (Motorik & ADL, Sensorik & Khusus, Pemeriksaan Fisik, serta Perkembangan & Rencana) agar tidak memicu _horizontal overflow_ di layar tablet/laptop.
- [x] **Indikator Progres (_Completion Badge_)**
    - Tambahkan tanda centang ($\checkmark$) atau indikator persentase keterisian pada setiap tab asesmen untuk menandai bagian yang sudah selesai diisi terapis.
- [x] **Tampilan Grid Matrix untuk GMFM-88 & Denver II**
    - Ubah tampilan _radio button_ tunggal pada instrumen **GMFM-88** dan **Skala Denver II** menjadi format **Tabel Matrix** (opsi skor 0, 1, 2, 3, dan NT dalam kolom) untuk memangkas _scroll_ halaman.
- [x] **Kalkulasi Skor Otomatis (_Auto-Calculation_)**
    - Buat _logic_ perhitungan skor persentase otomatis per dimensi (A–E) dan total skor untuk modul GMFM-88.
- [x] **Interactive Canvas Body Chart**
    - Sediakan modul gambar antarmuka tubuh manusia (depan/belakang) yang dapat diklik/ditandai oleh terapis untuk mencatat titik nyeri, kaku, atau bengkak.
- [x] **Fitur Preset & Auto-Save Draft**
    - Tambahkan tombol akselerator **"Set All Normal"** pada pemeriksaan fisik tertentu (ROM/MMT, Gait, Neurologis).
    - Implementasikan fitur _Auto-Save Draft_ secara berkala agar input data klinis tidak hilang saat terkendala jaringan.
### 3. Penyesuaian Form Pendaftaran & Penerima Manfaat
- [x] **Support Multi-Terapis & Pendamping**
    - Tambahkan opsi pemulihan multi-pilihan (_multiselect_) atau field opsional **"Terapis Pendamping"** pada Form Tambah Rekam Medis Baru untuk kasus penanganan gabungan.
- [x] **Field Multiselect Disabilitas & Alat Bantu**
    - Ubah kontrol input pada **Jenis Disabilitas** dan **Alat Bantu Mobilitas** menjadi _Multiselect Dropdown_ (bisa memilih lebih dari satu kondisi/alat bantu).
- [x] **Pemberlakuan Kriteria Desil (1–5 DTSEN)**
    - Berikan _visual badge_ atau indikator _eligibility_ otomatis saat memilih Desil 1–5 sesuai syarat layanan Dinsos.
### 4. Sinkronisasi Business Flow & Multi-Lokasi UPT
- [x] **Global UPT / Location Filter Header**
    - Sediakan _dropdown selector_ UPT/Lokasi di bagian _topbar_ (UPT PPSAB Sidoarjo, Balai RS PMKS Sidoarjo, UPT RSBN Malang) untuk memfilter data pasien dan jadwal per lokasi.
- [x] **Manajemen Penjadwalan Sesi Khusus (Hari Rabu)**
    - Atur pembatas jadwal pendaftaran sesi terapi khusus pada hari **Rabu**, rentang jam **08.00–13.00 WIB**, dengan durasi per kuota **30–45 menit**.