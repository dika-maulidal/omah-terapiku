# UI/UX Design System & Style Guide — Omah Terapi-KU

Dokumen ini merupakan acuan standar visual, skema warna (*palette*), tipografi, komponen UI, dan pedoman interaktivitas untuk memastikan antarmuka **Omah Terapi-KU** tampil modern, elegan, konsisten dengan nuansa khas **Royal Blue & Ocean Navy**, serta ramah pengguna (aksesibel dan inklusif).

---

## 1. Skema Warna (*Color Palette*)

Sistem warna aplikasi dibangun di atas nuansa **Clean Medical Royal Blue** yang memberikan kesan klinis yang terpercaya, segar, dan profesional.

### A. Palet Warna Utama (*Primary Brand Palette*)

| Nama Token | Hex Code | Visual Preview / Keterangan | Penggunaan Utama |
|---|---|---|---|
| **Royal Blue** | `#2563eb` | Biru Utama Terang | Tombol utama (*Primary Button*), ikon fokus, tab aktif, filter aktif, progress bar utama, link hover |
| **Ocean Navy** | `#1e40af` / `#2D4B7A` | Biru Navy Gelap | Judul halaman (*H1*), judul kartu (*Card Title*), header sidebar, ranking `#1`, brand header banner |
| **Sky Blue** | `#38bdf8` / `#38A5DB` | Biru Langit / Cyan | Aksen tren penerima baru, grafik komparasi, badge sekunder, highlight metrik |
| **Deep Navy** | `#1e293b` / `#0f172a` | Navy Pekat / Text Dark | Teks utama body, judul modal, tooltip chart background |
| **Soft Blue Light** | `#eff6ff` / `#e0f2fe` | Biru Pastel Sangat Lembut | Latar avatar inisial, badge aktif ringan, kontainer status |

### B. Palet Pendukung Status Klinis (*Semantic Status Colors*)

| Status | Warna Utama | Warna Latar Ringan (*Badge Light*) | Penggunaan |
|---|---|---|---|
| **Antrian / Menunggu** | `#f59e0b` (Amber Gold) | `#fef3c7` / `#fffbeb` | Status antrian, peringatan batas re-evaluasi |
| **Pemeriksaan / Proses** | `#2563eb` (Royal Blue) | `#eff6ff` / `#dbeafe` | Pasien sedang diperiksa terapis, sesi berlangsung |
| **Selesai / Terverifikasi** | `#10b981` (Emerald Teal) | `#ecfdf5` / `#d1fae5` | Selesai pelayanan, asesmen tersimpan |
| **Batal / Nyeri / Kritis** | `#ef4444` (Coral Red) | `#fef2f2` / `#fee2e2` | Status batal, asesmen skala nyeri tinggi |

### C. Permukaan & Latar Belakang (*Surface & Neutral Background*)

- **Main App Background:** `#F1F5F9` (Abu-abu kebiruan netral dengan *radial ambient glow* halus).
- **Card Surface:** `#FFFFFF` murni dengan garis batas `1px solid #E2E8F0` dan bayangan lembut `box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05)`.
- **Border & Separator:** `#E2E8F0` (Garis pemisah kartu, header, dan divider form).

---

## 2. Tipografi (*Typography*)

Menggunakan font modern sans-serif yang tajam dengan tingkat keterbacaan (*legibility*) tinggi untuk kemudahan pembacaan data klinis.

- **Font Family Utama:** `'Plus Jakarta Sans', 'Inter', sans-serif`
- **Skala Ukuran & Bobot:**
  - **H1 (Page Title):** `22px – 24px` | Bobot: `700 (Bold)` | Warna: `#1e40af` / `#2D4B7A`
  - **H2 / Card Header:** `15px – 16px` | Bobot: `700 (Bold)` | Warna: `#1e40af` / `#1e293b`
  - **Sub-header / Periode:** `12px – 12.5px` | Bobot: `600 (SemiBold)` | Warna: `#64748b`
  - **Body Text:** `13px – 14px` | Bobot: `400 (Regular)` / `500 (Medium)` | Warna: `#334155`
  - **Caption & Micro-Text:** `11px – 12px` | Bobot: `500 / 600` | Warna: `#64748b`

---

## 3. Komponen Dashboard Terstandarisasi

### A. Dropdown Filter Seragam (*Universal Header Filter*)
Seluruh kartu analitik dan ranking di dashboard wajib menggunakan format dropdown filter seragam:

- **Posisi:** Kanan atas pada *Card Header*.
- **Ikon:** `<i class="fa fa-filter"></i>` berwarna `#2563eb` di sisi kiri dalam dropdown.
- **Styling:**
  - Tinggi: `36px`, Sudut: `border-radius: 8px`, Border: `1px solid #cbd5e1`.
  - Warna Teks: `#2563eb` dengan `font-weight: 700`.
  - Panah Dropdown: Menggunakan SVG custom panah biru yang tajam.
- **Komponen Pengguna:**
  1. *Grafik Tren Pelayanan* (`#filterRentangTren`)
  2. *Grafik Total Penerima Manfaat per Bulan* (`#filterTahunPenerima`)
  3. *Top 5 Rencana Tindakan & Intervensi* (`#filterPeriodeTindakan`)
  4. *Top Diagnosa Kasus Terbanyak* (`#filterPeriodeDiagnosa`)

### B. Format Kartu Top Ranking (Tindakan & Diagnosa)
- **Sub-Header:** Label periode dinamis (kiri) dan badge total frekuensi (kanan).
- **Struktur Baris Item:**
  - **Ranking Pill:** `#1` sampai `#10` dengan palet bergradasi biru (`#1e40af`, `#2563eb`, `#3b82f6`, `#60a5fa`, `#38bdf8`).
  - **Badge Kode (Khusus Diagnosa):** Badge kode ICD-10 berlatar `#e0f2fe` dan teks `#0284c7`.
  - **Nama / Label:** Teks tebal `#1e293b` dengan *text-overflow ellipsis* dan tooltip judul lengkap.
  - **Badge Total:** Pill abu-abu `#f1f5f9` dengan teks biru bold `#2563eb` (contoh: `25 Kali`, `14 Kasus`).
  - **Progres Bar:** Tinggi `6px`, latar `#f1f5f9`, terisi proporsional sesuai nilai tertinggi (*bar_persen*).

### C. Visualisasi Grafik (*Charts Visual Standard*)
- **Grafik Tren Garis (Line Chart):**
  - Menggunakan area gradient lembut (*fading to transparent*).
  - Garis primer `#1e40af` (Pelayanan Rekam Medis) dan garis sekunder `#38bdf8` (Penerima Manfaat Baru).
- **Grafik Batang (Bar Chart):**
  - Bar rounded-top (`borderRadius: 6`), warna biru solid `#2563eb`.
- **Grafik Donat / Pie:**
  - Rasio *cutoutPercentage*: `65% – 68%`.
  - Border putih `2px` antar irisan untuk kontras maksimal.

### D. Tombol & Tombol Aksi (*Buttons*)
- **Tombol Utama (*Primary Button*):**
  - Gradien: `linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)`.
  - Efek: *Box-shadow* biru lembut `rgba(37, 99, 235, 0.25)`, sudut `border-radius: 8px`.
- **Tombol Aksi Baris / Tabel:**
  - Tombol ikon ringkas `28x28px`, warna latar solid `#2563eb`, ikon putih di tengah.

### E. Footer Copyright Ramping (*Compact Footer*)
- Jarak vertikal terhadap konten dipersempit (`padding-top: 10px`, `padding-bottom: 12px`).
- Latar transparan dengan garis pemisah tipis `1px solid rgba(226, 232, 240, 0.6)`.
- Link nama brand beraksen biru `#2563eb` dengan transisi hover ke `#1d4ed8`.

---

## 4. Pedoman Micro-Interactions & Aksesibilitas

1. **Responsivitas Realtime:**
   - Pergantian filter periode (Bulan Ini / Tahun Ini / Semua Waktu) harus ditangani via JavaScript secara langsung tanpa jeda reload halaman penuh.
2. **Penanganan Kondisi Kosong (*Empty State*):**
   - Jika suatu periode tidak memiliki data, tampilkan ikon representatif berukuran `24px` dengan opasitas `0.5` dan pesan penjelasan yang ramah.
3. **Standar Kontras & Inklusivitas:**
   - Semua perpaduan warna teks dan background memenuhi standar **WCAG 2.1 Level AA** agar nyaman dibaca oleh terapis, petugas, maupun pengguna dengan kebutuhan visual khusus.