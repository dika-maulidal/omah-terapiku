# Context & Business Rules — Omah Terapi-KU (Dinsos Prov. Jatim)

## 1. Project Overview
Omah Terapi-KU adalah aplikasi Sistem Informasi Rekam Medis & Manajemen Pelayanan Terapi Inklusif (Fisioterapi, Terapi Okupasi, Terapi Wicara, dan Sensorik Integrasi) milik Dinas Sosial Provinsi Jawa Timur. Aplikasi ini ditujukan untuk penyandang disabilitas, anak berkebutuhan khusus (ABK), ODGJ, dan lansia secara gratis.

## 2. Core Business Rules & Operational Constraints
- **Hari Operasional Sesi:** Khusus hari **Rabu** pukul **08.00 - 13.00 WIB**.
- **Durasi per Sesi:** 30 s.d. 45 menit per penerima manfaat.
- **Kriteria Penerima Manfaat:** Wajib terverifikasi masuk dalam **Desil 1 s.d. 5 DTSEN / DTKS**.
- **Multi-Lokasi / UPT (Scope Filtering):**
  1. **UPT PPSAB Sidoarjo** (Fokus: Anak Berkebutuhan Khusus / ABK)
  2. **Balai RS PMKS Sidoarjo** (Fokus: Dewasa, Lansia, ODGJ, Pasca-Stroke)
  3. **UPT RSBN Malang** (Fokus: Fisioterapi Olahragawan Disabilitas & Disabilitas Netra)

## 3. Workflow Pelayanan (5 Tahap)
1. **Daftar Online:** Pendaftaran jadwal via WhatsApp / Portal Publik UPT.
2. **Penerimaan & Registrasi:** Verifikasi dokumen fisik (KK/KTP/Hasil Medis) dan pendataan Penerima Manfaat Baru (Auto-generate No. RM: `OTK-26-XXXXX`).
3. **Skrining & Asesmen Baseline:** Pengisian Form Asesmen Terapi Komprehensif (15 Bagian Klinis).
4. **Sesi Terapi:** Intervensi klinis rutin (30-45 menit).
5. **Evaluasi & Sesi Selesai:** Pencatatan Log Sesi Harian (SOAP), saran latihan di rumah (Home Exercise Program), dan pendaftaran sesi Rabu berikutnya.

## 4. UI/UX & Data Structure Guidelines

### A. Detail Penerima Manfaat (Pemisahan Data)
Jangan menumpuk Form Asesmen ke dalam tabel SOAP harian! Pisahkan halaman Detail Penerima Manfaat menjadi 2 Tab Utama:
- **Tab 1: Asesmen Baseline & Re-Evaluasi:** Menampung form asesmen 15 bagian klinis.
- **Tab 2: Log Sesi Terapi (SOAP Harian):** Ringkas, khusus mencatat *Subjective, Objective, Assessment, Plan* per kunjungan. Kolom aksi di tabel SOAP hanya berupa 1 tombol utilitas (`Lihat Detail` / `Cetak`), tanpa tagging tombol S-O-A-P yang menumpuk.

### B. Form Asesmen Terapi (15 Bagian Klinis)
Form asesmen terdiri dari 15 modul:
1. Kemampuan Motorik
2. GMFM-88 (Gross Motor Function Measure)
3. Aktivitas Sehari-hari (ADL)
4. Kemampuan Wicara
5. Status Penglihatan (Low Vision/Netra)
6. Intensitas Nyeri & Body Chart
7. ROM & MMT (Kekuatan Otot)
8. Pemeriksaan Neurologis
9. Postur & Keseimbangan
10. Gait (Gaya Berjalan)
11. Sensoris & Vestibular
12. Faktor Psikososial
13. Perencanaan Terapi
14. Evaluasi & Target
15. Skala Denver II (DDST II)

**Aturan UI Asesmen:**
- Grouping 15 tab ke dalam 4 Kategori Utama (Motorik & ADL, Sensorik & Khusus, Pemeriksaan Fisik, Perkembangan & Rencana) untuk mencegah *horizontal overflow*.
- Gunakan format **Tabel Matrix Grid** untuk GMFM-88 dan Skala Denver II (skor 0, 1, 2, 3, NT).
- Implementasikan **Auto-Calculation** persentase skor total GMFM.
- Sediakan tombol **"Set All Normal"** pada pemeriksaan fisik dan fitur **Auto-Save Draft**.
- Gunakan **Interactive Body Chart** (Canvas) untuk penandaan titik nyeri.

### C. Form Registration & Input
- Field `Jenis Disabilitas` dan `Alat Bantu Mobilitas` wajib berformat **Multiselect Dropdown**.
- Form Input Rekam Medis Baru wajib mendukung penunjukan **Multi-Terapis / Terapis Pendamping**.
- Sediakan **Global UPT Selector** di bagian Topbar Header aplikasi.

---
*Gunakan dokumen context ini sebagai acuan utama saat membangkitkan code, komponen UI, database schema, maupun logika validasi.*