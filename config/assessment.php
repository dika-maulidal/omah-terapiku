<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modul Asesmen Klinis Omah Terapi-KU
    |--------------------------------------------------------------------------
    |
    | Master data konfigurasi opsi dan instrumen klinis baku untuk:
    | - Lingkup Gerak Sendi (ROM) & Kekuatan Otot (MMT)
    | - Perencanaan Terapi (Modalitas Fisik, Manual, Latihan, Edukasi)
    |
    */

    /*
    |--------------------------------------------------------------------------
    | 1. ROM & MMT (Lingkup Gerak Sendi & Manual Muscle Testing)
    |--------------------------------------------------------------------------
    */
    'rom_mmt' => [
        'rows' => [
            'kanan'    => 'Kanan (Aktif/Pasif)',
            'kiri'     => 'Kiri (Aktif/Pasif)',
            'cervical' => 'Cervical (Leher)',
            'thoracal' => 'Thoracal (Punggung)',
            'lumbal'   => 'Lumbal (Pinggang)',
            'custom'   => 'Sendi Lainnya',
        ],
        'scale_mmt' => [
            0 => 'Nilai 0 - Lumpuh Total (No Contraction)',
            1 => 'Nilai 1 - Kontraksi Teraba (Flicker/Trace)',
            2 => 'Nilai 2 - Gerak Aktif Tanpa Melawan Gravitasi (Poor)',
            3 => 'Nilai 3 - Gerak Aktif Melawan Gravitasi Penuh (Fair)',
            4 => 'Nilai 4 - Gerak Aktif Melawan Gravitasi + Tahanan Sedang (Good)',
            5 => 'Nilai 5 - Kekuatan Normal Penuh (Normal)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 2. Perencanaan Terapi & Intervensi Klinis
    |--------------------------------------------------------------------------
    */
    'rencana' => [
        'modalitas_fisik' => [
            'TENS / EStim',
            'Ultrasound',
            'SWD / MWD',
            'Hot Pack',
            'Cold Pack',
            'LASER',
            'Paraffin Bath',
            'Traksi mekanik',
            'Hidroterapi',
            'Lainnya',
        ],
        'manual_terapi' => [
            'Joint mobilization',
            'Soft tissue mobilization',
            'Myofascial release',
            'PNF',
            'Dry needling',
            'Kinesio taping',
            'Neural mobilization',
            'Manipulasi',
            'Lainnya',
        ],
        'latihan_terapi' => [
            'Stretching / flexibility',
            'Strengthening',
            'Stabilisasi core',
            'Propriosepsi / keseimbangan',
            'Aerobik / kardio',
            'Latihan fungsional',
            'Home exercise program',
            'Lainnya',
        ],
        'edukasi_konseling' => [
            'Postur & ergonomi',
            'Manajemen nyeri mandiri',
            'Modifikasi aktivitas',
            'Pencegahan cedera ulang',
            'Nutrisi & gaya hidup',
            'Penggunaan alat bantu',
            'Lainnya',
        ],
    ],
];
