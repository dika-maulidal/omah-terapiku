<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Denver Development Screening Test II (DDST II / Skala Denver)
    |--------------------------------------------------------------------------
    |
    | Konfigurasi instrumen skrining perkembangan anak Denver II untuk
    | mendeteksi dini kecurigaan keterlambatan perkembangan pada 4 sektor utama:
    | Personal Sosial, Motorik Halus Adaptif, Bahasa, dan Motorik Kasar di Omah Terapi-KU.
    |
    */

    'name' => 'Skala Perkembangan Denver II (DDST II)',
    'total_tasks' => 19,

    /*
    |--------------------------------------------------------------------------
    | Skala Skor / Penilaian Task
    |--------------------------------------------------------------------------
    */
    'scoring_scale' => [
        'P' => [
            'code' => 'P',
            'label' => 'Pass (Lulus)',
            'badge_class' => 'success',
            'badge_color' => '#16a34a',
            'description' => 'Anak mampu melakukan task sesuai indikator kelompok usia.',
        ],
        'F' => [
            'code' => 'F',
            'label' => 'Fail (Gagal)',
            'badge_class' => 'danger',
            'badge_color' => '#dc2626',
            'description' => 'Anak tidak mampu melakukan task.',
        ],
        'R' => [
            'code' => 'R',
            'label' => 'Refusal (Menolak)',
            'badge_class' => 'warning',
            'badge_color' => '#d97706',
            'description' => 'Anak menolak untuk melakukan task saat diuji.',
        ],
        'NO' => [
            'code' => 'NO',
            'label' => 'No Opportunity (Tidak Ada Kesempatan)',
            'badge_class' => 'secondary',
            'badge_color' => '#64748b',
            'description' => 'Anak belum pernah berkesempatan mencoba aktivitas ini karena keterbatasan lingkungan/alat.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 4 Sektor & Daftar 19 Task Perkembangan
    |--------------------------------------------------------------------------
    */
    'sectors' => [
        'A' => [
            'key' => 'A',
            'title' => 'A. Personal Sosial',
            'badge_color' => '#0284c7',
            'bg_header' => '#f0f9ff',
            'tasks' => [
                'ps_1' => ['no' => 1, 'name' => 'Menatap Muka', 'age' => '0–6 Bln'],
                'ps_2' => ['no' => 2, 'name' => 'Tepuk Tangan', 'age' => '6–12 Bln'],
                'ps_3' => ['no' => 3, 'name' => 'Menggunakan Sendok/Garpu', 'age' => '12–24 Bln'],
                'ps_4' => ['no' => 4, 'name' => 'Menyebut Nama Teman', 'age' => '2–4 Thn'],
            ],
        ],
        'B' => [
            'key' => 'B',
            'title' => 'B. Motorik Halus - Adaptif',
            'badge_color' => '#7c3aed',
            'bg_header' => '#f5f3ff',
            'tasks' => [
                'mh_1' => ['no' => 1, 'name' => 'Memegang Mainan yang Bisa Digoyangkan', 'age' => '0–6 Bln'],
                'mh_2' => ['no' => 2, 'name' => 'Menjimpit (Ibu Jari & Jari)', 'age' => '6–12 Bln'],
                'mh_3' => ['no' => 3, 'name' => 'Menara 2 Kubus', 'age' => '12–24 Bln'],
                'mh_4' => ['no' => 4, 'name' => 'Meniru Garis Vertikal', 'age' => '2–4 Thn'],
                'mh_5' => ['no' => 5, 'name' => 'Menggambar Orang 6 Bagian', 'age' => '4–6 Thn'],
            ],
        ],
        'C' => [
            'key' => 'C',
            'title' => 'C. Bahasa',
            'badge_color' => '#059669',
            'bg_header' => '#ecfdf5',
            'tasks' => [
                'bh_1' => ['no' => 1, 'name' => 'Bereaksi Terhadap Bel', 'age' => '0–6 Bln'],
                'bh_2' => ['no' => 2, 'name' => 'Menyebut 1 Kata', 'age' => '6–12 Bln'],
                'bh_3' => ['no' => 3, 'name' => 'Menunjuk 2 Gambar', 'age' => '12–24 Bln'],
                'bh_4' => ['no' => 4, 'name' => 'Menyebut 1 Warna', 'age' => '2–4 Thn'],
                'bh_5' => ['no' => 5, 'name' => 'Menghitung 5 Kubus', 'age' => '4–6 Thn'],
            ],
        ],
        'D' => [
            'key' => 'D',
            'title' => 'D. Motorik Kasar',
            'badge_color' => '#ea580c',
            'bg_header' => '#fff7ed',
            'tasks' => [
                'mk_1' => ['no' => 1, 'name' => 'Mengangkat Kepala', 'age' => '0–6 Bln'],
                'mk_2' => ['no' => 2, 'name' => 'Berjalan Dengan Baik', 'age' => '6–12 Bln'],
                'mk_3' => ['no' => 3, 'name' => 'Menendang Bola ke Depan', 'age' => '12–24 Bln'],
                'mk_4' => ['no' => 4, 'name' => 'Berdiri 1 Kaki (4 Detik)', 'age' => '2–4 Thn'],
                'mk_5' => ['no' => 5, 'name' => 'Berdiri 1 Kaki (6 Detik)', 'age' => '4–6 Thn'],
            ],
        ],
    ],
];
