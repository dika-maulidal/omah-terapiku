# UI/UX Design System & Style Guide — Omah Terapi-KU

Dokumen ini berisi standar visual, skema warna, tipografi, dan acuan komponen UI untuk memastikan antarmuka aplikasi Omah Terapi-KU terlihat profesional, konsisten, ramah pengguna (aksesibel untuk disabilitas/inklusi), dan terhindar dari tampilan generik (AI slop).

---

## 1. Palette Warna (Extracted from Logo & Reference)

Warna utama diambil dari logo resmi **Omah Terapi-KU** (Dinsos Jatim) dan dikombinasikan dengan nuansa *Clean Medical Dashboard*.

### A. Primary Brand Colors (Logo Based)
- **Ocean Navy (Primary/Brand Text):** `#2D4B7A`
  - *Penggunaan:* Text logo, Topbar, Header Card, Active Sidebar Item, Utama Tombol Primar.
- **Sky Blue (Accent/Secondary):** `#38A5DB`
  - *Penggunaan:* Icon highlight, Active Tabs, Progress Bar, Status "Sedang Terapi".
- **Warm Gold / Mustard (Warning/Accent):** `#F3B329`
  - *Penggunaan:* Badge status "Menunggu", Highlight Peringatan, Accent Card.
- **Heart Red (Danger/Critical):** `#D9383A`
  - *Penggunaan:* Status "Batal", Badge Urgent, Alert Nyeri Tinggi.
- **Teal / Emerald Green (Success):** `#2EB88A`
  - *Penggunaan:* Status "Selesai/Pass", Tombol Simpan/Konfirmasi, Badge Desil DTSEN.

### B. UI Surface & Background (Referensi Dashboard Modern)
- **Sidebar Navy (Dark Mode Sidebar Optional/Contrast):** `#2B2F57` atau **Clean Soft White:** `#F8FAFC`
- **Main App Background:** `#F1F5F9` (Gunakan off-white bersuhu netral, hindari putih murni yang silau di mata).
- **Card Surface Background:** `#FFFFFF` dengan shadow lembut (`box-shadow: 0 1px 3px rgba(0,0,0,0.05)`).
- **Border & Divider:** `#E2E8F0` (Garis tipis tegas 1px).

---

## 2. Tipografi (Typography)

Gunakan font sans-serif modern yang sangat mudah dibaca (*high legibility*) untuk dokumen medis dan aksesibilitas anak/lansia.

- **Primary Font Family:** `Plus Jakarta Sans` atau `Inter`, `sans-serif`.
- **Heading Scale:**
  - `H1` (Page Title): **24px / Bold (700)** — `#2D4B7A`
  - `H2` (Section Title / Card Title): **18px / SemiBold (600)** — `#1E293B`
  - `H3` (Sub-section / Tab Label): **14px / Medium (500)** — `#334155`
- **Body Text Scale:**
  - `Body Regular`: **14px / Regular (400)** — `#475569`
  - `Body Small / Captions`: **12px / Regular (400)** — `#64748B`

---

## 3. Iconography (FontAwesome 6 Pro / Free)

Gunakan set ikon **FontAwesome 6** yang konsisten (*Solid* untuk state aktif, *Regular/Light* untuk state netral). Jangan mencampur gaya ikon dari pustaka yang berbeda-beda.

### A. Navigation & System Icons
- **Dashboard:** `fa-solid fa-chart-pie`
- **Penerima Manfaat / Pasien:** `fa-solid fa-wheelchair` / `fa-solid fa-hospital-user`
- **Rekam Medis / SOAP:** `fa-solid fa-notes-medical`
- **Form Asesmen:** `fa-solid fa-clipboard-check`
- **Master Data:** `fa-solid fa-database`
- **Pengaturan:** `fa-solid fa-sliders`

### B. Clinical & Therapy Icons
- **Fisioterapi:** `fa-solid fa-child-reaching` / `fa-solid fa-person-walking`
- **Terapi Okupasi:** `fa-solid fa-hands-holding-child` / `fa-solid fa-puzzle-piece`
- **Terapi Wicara:** `fa-solid fa-comment-dots` / `fa-solid fa-hands-asl-interpreting`
- **Status Penglihatan (Netra):** `fa-solid fa-eye-low-vision`
- **Body Chart / Nyeri:** `fa-solid fa-child` / `fa-solid fa-stethoscope`

---

## 4. Component Design Rules (Anti "AI Slop")

Agar aplikasi tidak terlihat seperti template buatan AI yang berantakan, patuhi aturan berikut:

### A. Sidebar Navigation
- **Default Style:** Gunakan latar **Clean Navy Dark (`#2B2F57`)** atau **Pure Soft Gray (`#F8FAFC`)**.
- **Active State:** Tanda aktif menggunakan warna dasar Ocean Navy (`#2D4B7A`) dengan aksen garis vertical dibagian kiri (*Border-left 4px* warna `#38A5DB`) dan efek membulat (*rounded-r-lg*).
- **Group Label:** Kategori menu (MENU UTAMA, PELAYANAN, MASTER DATA) menggunakan font `11px / Bold / Uppercase` warna `#94A3B8`.

### B. Summary Stat Cards (Top Dashboard)
- Terinspirasi dari *reference image*: Gunakan gradasi warna lembut atau *flat solid color* dengan aksen visual yang jelas (bukan gambar hiasan AI yang tidak relevan).
- **Card 1 (Total Pasien):** Background `#2D4B7A` (Text Putih).
- **Card 2 (Sesi Hari Ini):** Background `#38A5DB` (Text Putih).
- **Card 3 (Pasien Selesai):** Background `#2EB88A` (Text Putih).
- **Card 4 (Re-evaluasi Perlu Diselesai):** Background `#F3B329` (Text Gelap).

### C. Tables & Data Display
- **Header Tabel:** Gunakan background `#F8FAFC`, font `12px / Bold / Uppercase` warna `#475569`.
- **Row Hover:** Berikan efek hover lembut `#F1F5F9`.
- **Badge Status:** Gunakan pill badge dengan transparansi background:
  - *Selesai:* Background `rgba(46, 184, 138, 0.1)`, Text `#2EB88A`.
  - *Proses:* Background `rgba(56, 165, 219, 0.1)`, Text `#38A5DB`.
  - *Batal:* Background `rgba(217, 56, 58, 0.1)`, Text `#D9383A`.

### D. Forms & Asesmen Inputs
- **Input Fields:** Border `1px solid #CBD5E1`, border-radius `8px`, dengan *focus state* ring warna `#38A5DB`.
- **Matrix Tables (GMFM/Denver):** Gunakan selang-seling warna baris (*zebra striping*) `#FFFFFF` dan `#F8FAFC` agar terapis tidak salah mengklik baris indikator.

---

## 5. Micro-Interactions & Responsiveness
- **Hover Effects:** Transisi halus (`transition: all 0.2s ease-in-out`).
- **Target Touch Size:** Karena kemungkinan digunakan di tablet touchscreen oleh terapis, pastikan ukuran tombol minimal **44px x 44px**.
- **Contrast Ratio:** Seluruh kombinasi warna teks dan background wajib lolos **WCAG 2.1 AA Standard** agar mudah dibaca oleh penyandang disabilitas low vision.