# Flowchart Alur Pelayanan & Penggunaan Aplikasi
**Omah Terapi-KU — Dinas Sosial Provinsi Jawa Timur**

Dokumen ini menjelaskan alur operasional dan proses kerja (*business flow*) aplikasi **Omah Terapi-KU** dari perspektif pengguna (Petugas Pendaftaran, Terapis/Dokter, dan Admin).

---

## 1. Alur Utama Pelayanan Klinis (End-to-End 5 Tahapan)

Berikut adalah gambaran besar alur pelayanan penerima manfaat mulai dari pendaftaran awal hingga terapi selesai:

```mermaid
flowchart TD
    START(["Mulai"]) --> T1["Tahap 1: Pendaftaran & Verifikasi"]
    
    subgraph TAHAP_1["1. Registrasi & Skrining Administrasi"]
        T1 --> DOKUMEN["Cek Dokumen (KTP/KK, Hasil Medis) & Desil DTKS 1-5"]
        DOKUMEN --> STATUS_PASIEN{"Penerima Manfaat Baru atau Lama?"}
        STATUS_PASIEN --"Baru"--> DAFTAR_BARU["Input Data Pasien & Buat No. Rekam Medis (No. RM)"]
        STATUS_PASIEN --"Lama"--> CARI_LAMA["Cari Pasien (via Nama / NIK / No. RM)"]
    end

    DAFTAR_BARU --> T2["Tahap 2: Penjadwalan & Pendaftaran Sesi"]
    CARI_LAMA --> T2

    subgraph TAHAP_2["2. Penjadwalan Sesi Terapi"]
        T2 --> PILIH_JADWAL["Pilih Tanggal Sesi (Hari Rabu) & Slot Waktu (30-45 Menit)"]
        PILIH_JADWAL --> PILIH_LAYANAN["Pilih Layanan (Fisioterapi / Okupasi / Wicara / Sensorik)"]
        PILIH_LAYANAN --> TENTUKAN_TERAPIS["Pilih Terapis Utama & Terapis Pendamping"]
        TENTUKAN_TERAPIS --> MASUK_ANTRIAN["Terbit Nomor Pendaftaran (Status: Antrian)"]
    end

    MASUK_ANTRIAN --> T3["Tahap 3: Pemanggilan Pasien"]

    subgraph TAHAP_3["3. Pemanggilan & Masuk Ruangan"]
        T3 --> PANGGIL["Petugas Memanggil Pasien Sesuai Urutan Sesi"]
        PANGGIL --> STATUS_PERIKSA["Status Berubah Menjadi: Pemeriksaan"]
        STATUS_PERIKSA --> NOTIF_DOKTER["Terapis Menerima Notifikasi Pasien Masuk"]
    end

    NOTIF_DOKTER --> T4["Tahap 4: Pelaksanaan Terapi & Asesmen"]

    subgraph TAHAP_4["4. Tindakan Klinis & Pencatatan"]
        T4 --> CEK_KUNJUNGAN{"Jenis Kunjungan?"}
        CEK_KUNJUNGAN --"Kunjungan Awal / Evaluasi Berkala"--> ASESMEN_LENGKAP["Isi Form Asesmen Klinis Lengkap (15 Bagian)"]
        CEK_KUNJUNGAN --"Sesi Rutin Lanjutan"--> SOAP_HARIAN["Catat Log SOAP Harian (S, O, A, P)"]
        ASESMEN_LENGKAP --> TINDAKAN["Lakukan Intervensi / Latihan Terapi"]
        SOAP_HARIAN --> TINDAKAN
        TINDAKAN --> CATAT_DIAGNOSA["Pilih Diagnosa & Rencana Terapi"]
    end

    CATAT_DIAGNOSA --> T5["Tahap 5: Evaluasi & Sesi Selesai"]

    subgraph TAHAP_5["5. Edukasi & Tindak Lanjut"]
        T5 --> EDUKASI["Berikan Saran Latihan di Rumah (Home Program) ke Wali"]
        EDUKASI --> UBAH_SELESAI["Terapis Mengubah Status Menjadi: Selesai"]
        UBAH_SELESAI --> SESI_LANJUT{"Perlu Jadwal Sesi Rabu Berikutnya?"}
        SESI_LANJUT --"Ya"--> PILIH_JADWAL
        SESI_LANJUT --"Tidak / Program Selesai"--> CETAK_RESUME["Cetak Hasil Asesmen / Resume (Opsional)"]
    end

    CETAK_RESUME --> SELESAI(["Selesai Pelayanan"])
```

---

## 2. Alur Pengguna Berdasarkan Peran (*User Journey by Role*)

### A. Alur Petugas Pendaftaran / Registrasi
Petugas pendaftaran bertugas mengelola penerimaan pasien, pendaftaran jadwal antrian, dan verifikasi administrasi.

```mermaid
flowchart TD
    A_LOGIN(["Login Petugas Pendaftaran"]) --> A_DASH["Buka Dashboard Registrasi"]
    A_DASH --> A_MENU{"Pilih Aktivitas"}

    A_MENU --"Penerima Manfaat Baru"--> A_REG["Buka Menu Penerima Manfaat"]
    A_REG --> A_FORM_PM["Isi Biodata, Disabilitas, Alat Bantu, Desil DTKS"]
    A_FORM_PM --> A_GEN_RM["Sistem Otomatis Membuat Nomor Rekam Medis (No. RM)"]
    A_GEN_RM --> A_JADWAL

    A_MENU --"Daftarkan Sesi Terapi"--> A_JADWAL["Buka Jadwal / Antrian Terapi"]
    A_JADWAL --> A_BOOKING["Pilih Pasien, Slot Jam (Sesi 1-7), Layanan, & Terapis"]
    A_BOOKING --> A_ANTRIAN["Pasien Masuk Daftar Antrian (Status: Antrian)"]

    A_ANTRIAN --> A_PANGGIL["Saat Giliran Sesi Tiba: Klik 'Panggil Pasien'"]
    A_PANGGIL --> A_UPDATE_STATUS["Status Berubah: 'Pemeriksaan' (Terapis Mulai Bekerja)"]

    A_UPDATE_STATUS --> A_MONITOR["Pantau Antrian Sampai Terapis Menyelesaikan Sesi"]
    A_MONITOR --> A_NOTIF_SELESAI["Menerima Notifikasi: Sesi Terapi Pasien Selesai"]
```

---

### B. Alur Dokter / Terapis
Terapis bertanggung jawab melakukan asesmen, tindakan fisioterapi/okupasi/wicara/sensorik, serta pencatatan rekam medis.

```mermaid
flowchart TD
    B_LOGIN(["Login Terapis / Dokter"]) --> B_DASH["Buka Dashboard Terapis"]
    B_DASH --> B_LIHAT_ANTRIAN["Lihat Daftar Pasien Sesi Hari Ini"]
    
    B_LIHAT_ANTRIAN --> B_NOTIF["Menerima Notifikasi Pasien Dipanggil ke Ruangan"]
    B_NOTIF --> B_BUKA_REKAM["Buka Halaman Detail Rekam Medis Pasien"]

    B_BUKA_REKAM --> B_PILIH_INPUT{"Pilih Form yang Diisi"}

    B_PILIH_INPUT --"Asesmen Klinis Lengkap"--> B_ASESMEN["Buka Tab Form Asesmen (15 Modul)"]
    B_ASESMEN --> B_INPUT_ASESMEN["Isi Penilaian: Motorik, GMFM, ADL, ROM/MMT, Denver II, dll."]
    B_INPUT_ASESMEN --> B_SIMPAN_ASESMEN["Simpan Data Asesmen & Cetak Lembar Asesmen"]

    B_PILIH_INPUT --"Log Sesi Harian (SOAP)"--> B_SOAP["Buka Tab Log Sesi Terapi"]
    B_SOAP --> B_INPUT_S["Catat Keluhan Pasien (Subjective)"]
    B_INPUT_S --> B_INPUT_O["Catat Observasi & Unggah Foto Kondisi Fisik (Objective)"]
    B_INPUT_O --> B_INPUT_A["Pilih Diagnosa ICD-10 & Evaluasi (Assessment)"]
    B_INPUT_A --> B_INPUT_P["Pilih Tindakan Terapi & Unggah Bukti Tindakan (Plan)"]

    B_SIMPAN_ASESMEN --> B_SELESAIKAN["Klik 'Selesaikan Pemeriksaan' (Status: Selesai)"]
    B_INPUT_P --> B_SELESAIKAN
    B_SELESAIKAN --> B_HOME_PROG["Berikan Catatan Home Program ke Keluarga Pasien"]
```

---

### C. Alur Administrator
Administrator mengawasi operasional, mengelola master data, dan mencetak laporan analitik.

```mermaid
flowchart TD
    C_LOGIN(["Login Administrator"]) --> C_DASH["Buka Dashboard Utama Admin"]
    C_DASH --> C_PILIH{"Pilih Kebutuhan"}

    C_PILIH --"Monitoring Layanan"--> C_FILTER_UPT["Pilih Filter UPT (PPSAB Sidoarjo / RS PMKS / RSBN Malang)"]
    C_FILTER_UPT --> C_GRAFIK["Lihat Tren Kunjungan, Kasus Diagnosa Terbanyak, & Tindakan"]

    C_PILIH --"Kelola Pengguna & Master"--> C_MASTER["Menu Master Data"]
    C_MASTER --> C_CRUD["Kelola Data: Terapis, Petugas, Poli/UPT, Tindakan, ICD-10"]

    C_PILIH --"Unduh Laporan"--> C_EXPORT["Menu Penerima Manfaat / Rekam Medis"]
    C_EXPORT --> C_DOWNLOAD["Klik 'Export CSV' untuk Laporan Excel"]
```

---

## 3. Detail Alur Proses Kunci

### A. Alur Pendaftaran Penerima Manfaat
```mermaid
flowchart TD
    PM_START(["Pasien / Wali Datang"]) --> PM_BERKAS["Serahkan Berkas (KTP/KK, Resume Medis Asal)"]
    PM_BERKAS --> PM_CEK_DTKS{"Verifikasi Desil DTKS (Desil 1 s.d. 5)"}
    
    PM_CEK_DTKS --"Tidak Masuk Desil 1-5"--> PM_TOLAK["Edukasi Alur Bantuan & Rujuk ke Layanan Terkait"]
    PM_CEK_DTKS --"Terverifikasi Desil 1-5"--> PM_INPUT["Petugas Mengisi Form Pendaftaran"]

    PM_INPUT --> PM_FIELDS["Isi: Biodata, Disabilitas (Multiselect), Alat Bantu, & Data Wali"]
    PM_FIELDS --> PM_UPLOAD["Unggah Berkas KK & Resume Medis"]
    PM_UPLOAD --> PM_GEN["Sistem Membuat No. Rekam Medis Otomatis (OTK-26-XXXXX)"]
    PM_GEN --> PM_FINISH(["Penerima Manfaat Terdaftar"])
```

---

### B. Alur Penjadwalan & Pembagian Slot Sesi
Sesi terapi dipusatkan pada hari **Rabu** pukul **08.00 - 13.00 WIB** dengan durasi 30-45 menit per penerima manfaat:

```mermaid
flowchart LR
    J_SLOT["Pilih Slot Waktu Sesi:
    • Sesi 1 (08.00 - 08.45 WIB)
    • Sesi 2 (08.45 - 09.30 WIB)
    • Sesi 3 (09.30 - 10.15 WIB)
    • Sesi 4 (10.15 - 11.00 WIB)
    • Sesi 5 (11.00 - 11.45 WIB)
    • Sesi 6 (11.45 - 12.30 WIB)
    • Sesi 7 (12.30 - 13.00 WIB)"] --> J_LAYANAN["Pilih Layanan Terapi:
    • Fisioterapi
    • Terapi Okupasi
    • Terapi Wicara
    • Sensorik Integrasi"]
    
    J_LAYANAN --> J_TERAPIS["Tentukan Terapis:
    • Terapis Utama
    • Terapis Pendamping"]

    J_TERAPIS --> J_SIMPAN["Jadwal Terdaftar di Kalender Terapi"]
```

---

### C. Alur Transisi Status Pelayanan
```mermaid
stateDiagram-v2
    [*] --> Antrian: 1. Pasien didaftarkan pada sesi hari ini
    Antrian --> Pemeriksaan: 2. Petugas memanggil pasien ke ruangan terapi
    Pemeriksaan --> Menunggu: 3. Terapis mengisi SOAP / Asesmen & selesai tindakan
    Menunggu --> Selesai: 4. Verifikasi akhir & pasien siap pulang / reservasi sesi berikutnya
    Selesai --> [*]
```

---

### D. Alur Form Asesmen Klinis 15 Modul (Terapis)
Form asesmen klinis dikelompokkan ke dalam 4 kategori praktis:

```mermaid
flowchart TD
    A_START(["Mulai Asesmen"]) --> A_TABS{"4 Kategori Form Asesmen"}

    A_TABS --> K1["1. Motorik & ADL
    • Kemampuan Motorik Kasar/Halus
    • GMFM-88 (Matrix Skor 0-3)
    • Aktivitas Sehari-hari (ADL)
    • Kemampuan Wicara & Menelan
    • Status Penglihatan (Low Vision/Netra)"]

    A_TABS --> K2["2. Sensorik & Khusus
    • Intensitas Nyeri (Skala VAS 0-10)
    • Interactive Body Chart (Penanda Titik Nyeri)
    • Pemeriksaan Sensoris & Propriosepsi
    • Skrining Vestibular Dasar (HIT / Dix-Hallpike)"]

    A_TABS --> K3["3. Pemeriksaan Fisik
    • Lingkup Gerak Sendi (ROM) & MMT (0-5)
    • Pemeriksaan Neurologis (Refleks & Tonus)
    • Postur & Tes Keseimbangan (BBS / TUG)
    • Analisis Gaya Berjalan / Gait (10MWT)
    (Tersedia Tombol: 'Set All Normal')"]

    A_TABS --> K4["4. Perkembangan & Rencana
    • Faktor Psikososial & Lingkungan
    • Skala Denver II (DDST II Matrix Perkembangan)
    • Perencanaan Modalitas & Dosis Program
    • Target & Kesimpulan Klinis"]

    K1 --> A_SAVE["Simpan Asesmen / Simpan & Cetak Lembar Klinis"]
    K2 --> A_SAVE
    K3 --> A_SAVE
    K4 --> A_SAVE
    A_SAVE --> A_DONE(["Asesmen Tersimpan di Rekam Medis"])
```

---

> **Catatan Operasional:** Seluruh pelayanan di Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur diberikan **secara gratis** tanpa pungutan biaya kepada penerima manfaat yang memenuhi kriteria.
