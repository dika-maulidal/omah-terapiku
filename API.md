Memperkenalkan,

Wilayah.id - API Data Wilayah Administrasi Pemerintahan di Indonesia
Wilayah.id merupakan API (Antarmuka Pemrograman Aplikasi) statis yang berisikan data wilayah yang ada di Indonesia. Data yang disediakan meliputi data provinsi, kabupaten/kota, kecamatan, dan kelurahan/desa.

Pembaruan data terakhir 04 Juli 2025
Kode dan Data Wilayah Administrasi Pemerintahan dan Pulau Indonesia sesuai dengan Kepmendagri No 300.2.2-2138 Tahun 2025 [ref: github.com/cahyadsn/wilayah ↗]

# Daftar API Endpoint:
1. Provinsi
Mendapatkan data semua provinsi yang ada di Indonesia.

Endpoint
GET
https://wilayah.id/api/provinces.json
Copy
Response
Contoh response ketika mengambil data semua provinsi di Indonesia https://wilayah.id/api/provinces.json ↗

{
    "data": [
        {
          "code": "36",
          "name": "Banten"
        },
        {
          "code": "31",
          "name": "DKI Jakarta"
        },
        // ...
    ],
    "meta": {
        "administrative_area_level": 1,
        "updated_at": "2025-07-04"
    }
}
                        
2. Kabupaten / Kota
Mendapatkan data kabupaten atau kota dari provinsi.

Endpoint
GET
https://wilayah.id/api/regencies/[PROVINCE_CODE].json
Copy
Response
Contoh response ketika mengambil data kabupaten atau kota dari provinsi DKI Jakarta https://wilayah.id/api/regencies/31.json ↗

{
    "data": [
        {
            "code": "31.71",
            "name": "Kota Administrasi Jakarta Pusat"
        },
        {
            "code": "31.74",
            "name": "Kota Administrasi Jakarta Selatan"
        },
        // ...
    ],
    "meta": {
        "administrative_area_level": 2,
        "updated_at": "2025-07-04"
    }
}
                            
3. Kecamatan
Mendapatkan data kecamatan dari kabupaten atau kota.

Endpoint
GET
https://wilayah.id/api/districts/[REGENCY_CODE].json
Copy
Response
Contoh response ketika mengambil data kecamatan dari Kota Administrasi Jakarta Selatan https://wilayah.id/api/districts/31.74.json ↗

{
    "data": [
        {
            "code": "31.74.06",
            "name": "Cilandak"
        },
        {
            "code": "31.74.09",
            "name": "Jagakarsa"
        },
        // ...
    ],
    "meta": {
        "administrative_area_level": 3,
        "updated_at": "2025-07-04"
    }
}
                        
4. Kelurahan / Desa
Mendapatkan data kelurahan atau desa dari kecamatan.

Endpoint
GET
https://wilayah.id/api/villages/[DISTRICT_CODE].json
Copy
Response
Contoh response ketika mengambil data kelurahan atau desa dari kecamatan Jagakarsa https://wilayah.id/api/villages/31.74.09.json ↗

{
    "data": [
        {
            "code": "31.74.09.1002",
            "name": "Srengseng Sawah"
        },
        {
            "code": "31.74.09.1005",
            "name": "Tanjung Barat"
        }
        // ...
    ],
    "meta": {
        "administrative_area_level": 4,
        "updated_at": "2025-07-04"
    }
}
                        
Referensi
Kode dan nama provinsi, kabupaten atau kota, kecamatan, dan kelurahan yang digunakan didalam API ini diperoleh dari https://github.com/cahyadsn/wilayah ↗.
Catatan perubahan:
07 Oktober 2024
• Versi 1.1.0 endpoint baru untuk mendapatkan data kelurahan dari kecamatan tertentu
17 Augustus 2023
• Versi 1.0.0 rilis Wilayah.id
FAQ
Apakah data yang tersedia sudah terbaru?
Semua data yang ditampilkan di Wilayah.id akan selalu diupayakan agar mengikuti perkembangan administratif sesuai dengan keputusan baru dari Menteri Dalam Negeri. Pembaruan dilakukan setelah sumber data resmi tersedia secara publik.
Saya ingin donasi agar Wilayah.id semakin berkembang.
Terima kasih atas niat baik dan dukungan Anda. Kami menyarankan agar donasi disalurkan langsung kepada pemilik sumber data dengan kunjungi repositori berikut https://github.com/cahyadsn/wilayah ↗. Di sana tersedia informasi rekening donasi yang dapat Anda gunakan.
Saya mempunyai pertanyaan lebih lanjut.
Hubungi kami melalui email truth-study-saga [at] duck.com ↗ untuk informasi lebih lanjut.
Check value ›