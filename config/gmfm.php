<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gross Motor Function Measure (GMFM-88)
    |--------------------------------------------------------------------------
    |
    | Konfigurasi instrumen penilaian fungsi motorik kasar GMFM-88 untuk
    | evaluasi perkembangan motorik pada anak Cerebral Palsy dan kondisi
    | neurologis/pediatrik lainnya di Omah Terapiku.
    |
    */

    'name' => 'Gross Motor Function Measure (GMFM-88)',
    'total_items' => 88,
    'max_total_score' => 264, // (88 item x 3 skor maks)

    /*
    |--------------------------------------------------------------------------
    | Skala Penilaian (Scoring Scale)
    |--------------------------------------------------------------------------
    */
    'scoring_scale' => [
        0 => [
            'score' => 0,
            'label' => 'Tidak Memulai',
            'description' => 'Tidak da
            pat memulai atau melakukan gerakan sama sekali (0%).',
        ],
        1 => [
            'score' => 1,
            'label' => 'Memulai',
            'description' => 'Memulai gerakan tetapi menyelesaikan kurang dari 10% aktivitas (< 10%).',
        ],
        2 => [
            'score' => 2,
            'label' => 'Sebagian',
            'description' => 'Menyelesaikan sebagian aktivitas antara 10% hingga kurang dari 100% (10% - <100%).',
        ],
        3 => [
            'score' => 3,
            'label' => 'Selesai Sempurna',
            'description' => 'Menyelesaikan seluruh aktivitas secara mandiri dan sempurna (100%).',
        ],
        'NT' => [
            'score' => null,
            'label' => 'Tidak Diuji (Not Tested)',
            'description' => 'Item tidak diuji karena keterbatasan pasien atau alasan medis.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dimensi GMFM-88
    |--------------------------------------------------------------------------
    */
    'dimensions' => [
        'A' => [
            'key' => 'A',
            'title' => 'Dimensi A: Berbaring & Berguling',
            'name' => 'Berbaring & Berguling',
            'total_items' => 17,
            'max_score' => 51,
            'items' => [
                1 => [
                    'no' => 1,
                    'position' => 'Telentang, kepala di garis tengah',
                    'action' => 'Menoleh dengan ekstremitas simetris.',
                    'text' => 'Telentang, kepala di garis tengah: Menoleh dengan ekstremitas simetris.',
                ],
                2 => [
                    'no' => 2,
                    'position' => 'Telentang',
                    'action' => 'Membawa kedua tangan ke garis tengah, jari-jari bersentuhan.',
                    'text' => 'Telentang: Membawa kedua tangan ke garis tengah, jari-jari bersentuhan.',
                ],
                3 => [
                    'no' => 3,
                    'position' => 'Telentang',
                    'action' => 'Mengangkat kepala 45°.',
                    'text' => 'Telentang: Mengangkat kepala 45°.',
                ],
                4 => [
                    'no' => 4,
                    'position' => 'Telentang',
                    'action' => 'Memfleksikan panggul dan lutut kanan secara penuh.',
                    'text' => 'Telentang: Memfleksikan panggul dan lutut kanan secara penuh.',
                ],
                5 => [
                    'no' => 5,
                    'position' => 'Telentang',
                    'action' => 'Memfleksikan panggul dan lutut kiri secara penuh.',
                    'text' => 'Telentang: Memfleksikan panggul dan lutut kiri secara penuh.',
                ],
                6 => [
                    'no' => 6,
                    'position' => 'Telentang',
                    'action' => 'Menjangkau dengan tangan kanan, tangan menyeberangi garis tengah menuju mainan.',
                    'text' => 'Telentang: Menjangkau dengan tangan kanan, tangan menyeberangi garis tengah menuju mainan.',
                ],
                7 => [
                    'no' => 7,
                    'position' => 'Telentang',
                    'action' => 'Menjangkau dengan tangan kiri, tangan menyeberangi garis tengah menuju mainan.',
                    'text' => 'Telentang: Menjangkau dengan tangan kiri, tangan menyeberangi garis tengah menuju mainan.',
                ],
                8 => [
                    'no' => 8,
                    'position' => 'Telentang',
                    'action' => 'Berguling ke posisi tengkurap melalui sisi kanan.',
                    'text' => 'Telentang: Berguling ke posisi tengkurap melalui sisi kanan.',
                ],
                9 => [
                    'no' => 9,
                    'position' => 'Telentang',
                    'action' => 'Berguling ke posisi tengkurap melalui sisi kiri.',
                    'text' => 'Telentang: Berguling ke posisi tengkurap melalui sisi kiri.',
                ],
                10 => [
                    'no' => 10,
                    'position' => 'Tengkurap',
                    'action' => 'Mengangkat kepala tegak.',
                    'text' => 'Tengkurap: Mengangkat kepala tegak.',
                ],
                11 => [
                    'no' => 11,
                    'position' => 'Tengkurap di atas lengan bawah',
                    'action' => 'Mengangkat kepala tegak, siku ekstensi, dada terangkat.',
                    'text' => 'Tengkurap di atas lengan bawah: Mengangkat kepala tegak, siku ekstensi, dada terangkat.',
                ],
                12 => [
                    'no' => 12,
                    'position' => 'Tengkurap di atas lengan bawah',
                    'action' => 'Menumpu beban pada lengan bawah kanan, meluruskan lengan kiri ke depan.',
                    'text' => 'Tengkurap di atas lengan bawah: Menumpu beban pada lengan bawah kanan, meluruskan lengan kiri ke depan.',
                ],
                13 => [
                    'no' => 13,
                    'position' => 'Tengkurap di atas lengan bawah',
                    'action' => 'Menumpu beban pada lengan bawah kiri, meluruskan lengan kanan ke depan.',
                    'text' => 'Tengkurap di atas lengan bawah: Menumpu beban pada lengan bawah kiri, meluruskan lengan kanan ke depan.',
                ],
                14 => [
                    'no' => 14,
                    'position' => 'Tengkurap',
                    'action' => 'Berguling ke posisi telentang melalui sisi kanan.',
                    'text' => 'Tengkurap: Berguling ke posisi telentang melalui sisi kanan.',
                ],
                15 => [
                    'no' => 15,
                    'position' => 'Tengkurap',
                    'action' => 'Berguling ke posisi telentang melalui sisi kiri.',
                    'text' => 'Tengkurap: Berguling ke posisi telentang melalui sisi kiri.',
                ],
                16 => [
                    'no' => 16,
                    'position' => 'Tengkurap',
                    'action' => 'Berputar (pivot) ke kanan 90° menggunakan anggota gerak.',
                    'text' => 'Tengkurap: Berputar (pivot) ke kanan 90° menggunakan anggota gerak.',
                ],
                17 => [
                    'no' => 17,
                    'position' => 'Tengkurap',
                    'action' => 'Berputar (pivot) ke kiri 90° menggunakan anggota gerak.',
                    'text' => 'Tengkurap: Berputar (pivot) ke kiri 90° menggunakan anggota gerak.',
                ],
            ],
        ],

        'B' => [
            'key' => 'B',
            'title' => 'Dimensi B: Duduk',
            'name' => 'Duduk',
            'total_items' => 20,
            'max_score' => 60,
            'items' => [
                18 => [
                    'no' => 18,
                    'position' => 'Telentang, tangan dipegang pemeriksa',
                    'action' => 'Menarik diri ke posisi duduk dengan kontrol kepala.',
                    'text' => 'Telentang, tangan dipegang pemeriksa: Menarik diri ke posisi duduk dengan kontrol kepala.',
                ],
                19 => [
                    'no' => 19,
                    'position' => 'Telentang',
                    'action' => 'Berguling ke sisi kanan, mencapai posisi duduk.',
                    'text' => 'Telentang: Berguling ke sisi kanan, mencapai posisi duduk.',
                ],
                20 => [
                    'no' => 20,
                    'position' => 'Telentang',
                    'action' => 'Berguling ke sisi kiri, mencapai posisi duduk.',
                    'text' => 'Telentang: Berguling ke sisi kiri, mencapai posisi duduk.',
                ],
                21 => [
                    'no' => 21,
                    'position' => 'Duduk di matras, disangga di dada oleh terapis',
                    'action' => 'Mengangkat kepala tegak, bertahan 3 detik.',
                    'text' => 'Duduk di matras, disangga di dada oleh terapis: Mengangkat kepala tegak, bertahan 3 detik.',
                ],
                22 => [
                    'no' => 22,
                    'position' => 'Duduk di matras, disangga di dada oleh terapis',
                    'action' => 'Mengangkat kepala di garis tengah, bertahan 10 detik.',
                    'text' => 'Duduk di matras, disangga di dada oleh terapis: Mengangkat kepala di garis tengah, bertahan 10 detik.',
                ],
                23 => [
                    'no' => 23,
                    'position' => 'Duduk di matras, bertumpu pada lengan',
                    'action' => 'Bertahan 5 detik.',
                    'text' => 'Duduk di matras, bertumpu pada lengan: Bertahan 5 detik.',
                ],
                24 => [
                    'no' => 24,
                    'position' => 'Duduk di matras',
                    'action' => 'Bertahan, lengan bebas, 3 detik.',
                    'text' => 'Duduk di matras: Bertahan, lengan bebas, 3 detik.',
                ],
                25 => [
                    'no' => 25,
                    'position' => 'Duduk di matras dengan mainan kecil di depan',
                    'action' => 'Membongkok ke depan, menyentuh mainan, kembali tegak tanpa tumpuan lengan.',
                    'text' => 'Duduk di matras dengan mainan kecil di depan: Membongkok ke depan, menyentuh mainan, kembali tegak tanpa tumpuan lengan.',
                ],
                26 => [
                    'no' => 26,
                    'position' => 'Duduk di matras',
                    'action' => 'Menyentuh mainan 45° di belakang sisi kanan, kembali ke posisi awal.',
                    'text' => 'Duduk di matras: Menyentuh mainan 45° di belakang sisi kanan, kembali ke posisi awal.',
                ],
                27 => [
                    'no' => 27,
                    'position' => 'Duduk di matras',
                    'action' => 'Menyentuh mainan 45° di belakang sisi kiri, kembali ke posisi awal.',
                    'text' => 'Duduk di matras: Menyentuh mainan 45° di belakang sisi kiri, kembali ke posisi awal.',
                ],
                28 => [
                    'no' => 28,
                    'position' => 'Duduk miring ke kanan (Right side sit)',
                    'action' => 'Bertahan, lengan bebas, 5 detik.',
                    'text' => 'Duduk miring ke kanan (Right side sit): Bertahan, lengan bebas, 5 detik.',
                ],
                29 => [
                    'no' => 29,
                    'position' => 'Duduk miring ke kiri (Left side sit)',
                    'action' => 'Bertahan, lengan bebas, 5 detik.',
                    'text' => 'Duduk miring ke kiri (Left side sit): Bertahan, lengan bebas, 5 detik.',
                ],
                30 => [
                    'no' => 30,
                    'position' => 'Duduk di matras',
                    'action' => 'Menurunkan badan ke posisi tengkurap dengan terkontrol.',
                    'text' => 'Duduk di matras: Menurunkan badan ke posisi tengkurap dengan terkontrol.',
                ],
                31 => [
                    'no' => 31,
                    'position' => 'Duduk di matras dengan kaki di depan',
                    'action' => 'Mencapai posisi merangkak (4 poin) melalui sisi kanan.',
                    'text' => 'Duduk di matras dengan kaki di depan: Mencapai posisi merangkak (4 poin) melalui sisi kanan.',
                ],
                32 => [
                    'no' => 32,
                    'position' => 'Duduk di matras dengan kaki di depan',
                    'action' => 'Mencapai posisi merangkak (4 poin) melalui sisi kiri.',
                    'text' => 'Duduk di matras dengan kaki di depan: Mencapai posisi merangkak (4 poin) melalui sisi kiri.',
                ],
                33 => [
                    'no' => 33,
                    'position' => 'Duduk di matras',
                    'action' => 'Berputar 90° tanpa bantuan lengan.',
                    'text' => 'Duduk di matras: Berputar 90° tanpa bantuan lengan.',
                ],
                34 => [
                    'no' => 34,
                    'position' => 'Duduk di bangku',
                    'action' => 'Bertahan, lengan dan kaki bebas, 10 detik.',
                    'text' => 'Duduk di bangku: Bertahan, lengan dan kaki bebas, 10 detik.',
                ],
                35 => [
                    'no' => 35,
                    'position' => 'Berdiri',
                    'action' => 'Mencapai posisi duduk di bangku kecil.',
                    'text' => 'Berdiri: Mencapai posisi duduk di bangku kecil.',
                ],
                36 => [
                    'no' => 36,
                    'position' => 'Di lantai',
                    'action' => 'Mencapai posisi duduk di bangku kecil.',
                    'text' => 'Di lantai: Mencapai posisi duduk di bangku kecil.',
                ],
                37 => [
                    'no' => 37,
                    'position' => 'Di lantai',
                    'action' => 'Mencapai posisi duduk di bangku besar.',
                    'text' => 'Di lantai: Mencapai posisi duduk di bangku besar.',
                ],
            ],
        ],

        'C' => [
            'key' => 'C',
            'title' => 'Dimensi C: Merangkak & Berlutut',
            'name' => 'Merangkak & Berlutut',
            'total_items' => 14,
            'max_score' => 42,
            'items' => [
                38 => [
                    'no' => 38,
                    'position' => 'Tengkurap',
                    'action' => 'Merayap ke depan sejauh 1,8 meter.',
                    'text' => 'Tengkurap: Merayap ke depan sejauh 1,8 meter.',
                ],
                39 => [
                    'no' => 39,
                    'position' => 'Posisi 4 poin (merangkak)',
                    'action' => 'Bertahan, tumpuan pada tangan dan lutut, 10 detik.',
                    'text' => 'Posisi 4 poin (merangkak): Bertahan, tumpuan pada tangan dan lutut, 10 detik.',
                ],
                40 => [
                    'no' => 40,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Mencapai posisi duduk, lengan bebas.',
                    'text' => 'Posisi 4 poin: Mencapai posisi duduk, lengan bebas.',
                ],
                41 => [
                    'no' => 41,
                    'position' => 'Tengkurap',
                    'action' => 'Mencapai posisi 4 poin, tumpuan pada tangan dan lutut.',
                    'text' => 'Tengkurap: Mencapai posisi 4 poin, tumpuan pada tangan dan lutut.',
                ],
                42 => [
                    'no' => 42,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Menjangkau ke depan dengan lengan kanan, tangan di atas level bahu.',
                    'text' => 'Posisi 4 poin: Menjangkau ke depan dengan lengan kanan, tangan di atas level bahu.',
                ],
                43 => [
                    'no' => 43,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Menjangkau ke depan dengan lengan kiri, tangan di atas level bahu.',
                    'text' => 'Posisi 4 poin: Menjangkau ke depan dengan lengan kiri, tangan di atas level bahu.',
                ],
                44 => [
                    'no' => 44,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Merangkak maju 1,8 meter.',
                    'text' => 'Posisi 4 poin: Merangkak maju 1,8 meter.',
                ],
                45 => [
                    'no' => 45,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Merangkak timbal-balik (reciprocal) maju 1,8 meter.',
                    'text' => 'Posisi 4 poin: Merangkak timbal-balik (reciprocal) maju 1,8 meter.',
                ],
                46 => [
                    'no' => 46,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Merangkak naik 4 anak tangga dengan tangan dan lutut/kaki.',
                    'text' => 'Posisi 4 poin: Merangkak naik 4 anak tangga dengan tangan dan lutut/kaki.',
                ],
                47 => [
                    'no' => 47,
                    'position' => 'Posisi 4 poin',
                    'action' => 'Merangkak mundur turun 4 anak tangga dengan tangan dan lutut/kaki.',
                    'text' => 'Posisi 4 poin: Merangkak mundur turun 4 anak tangga dengan tangan dan lutut/kaki.',
                ],
                48 => [
                    'no' => 48,
                    'position' => 'Duduk di matras',
                    'action' => 'Mencapai posisi berlutut tinggi menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                    'text' => 'Duduk di matras: Mencapai posisi berlutut tinggi menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                ],
                49 => [
                    'no' => 49,
                    'position' => 'Berlutut tinggi',
                    'action' => 'Mencapai posisi setengah berlutut (half-kneel) pada lutut kanan menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                    'text' => 'Berlutut tinggi: Mencapai posisi setengah berlutut (half-kneel) pada lutut kanan menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                ],
                50 => [
                    'no' => 50,
                    'position' => 'Berlutut tinggi',
                    'action' => 'Mencapai posisi setengah berlutut (half-kneel) pada lutut kiri menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                    'text' => 'Berlutut tinggi: Mencapai posisi setengah berlutut (half-kneel) pada lutut kiri menggunakan lengan, bertahan (lengan bebas) 10 detik.',
                ],
                51 => [
                    'no' => 51,
                    'position' => 'Berlutut tinggi',
                    'action' => 'Berjalan dengan lutut maju 10 langkah, lengan bebas.',
                    'text' => 'Berlutut tinggi: Berjalan dengan lutut maju 10 langkah, lengan bebas.',
                ],
            ],
        ],

        'D' => [
            'key' => 'D',
            'title' => 'Dimensi D: Berdiri',
            'name' => 'Berdiri',
            'total_items' => 13,
            'max_score' => 39,
            'items' => [
                52 => [
                    'no' => 52,
                    'position' => 'Di lantai',
                    'action' => 'Menarik diri ke posisi berdiri di bangku besar.',
                    'text' => 'Di lantai: Menarik diri ke posisi berdiri di bangku besar.',
                ],
                53 => [
                    'no' => 53,
                    'position' => 'Berdiri',
                    'action' => 'Bertahan, lengan bebas, 3 detik.',
                    'text' => 'Berdiri: Bertahan, lengan bebas, 3 detik.',
                ],
                54 => [
                    'no' => 54,
                    'position' => 'Berdiri',
                    'action' => 'Berpegangan pada bangku besar dengan satu tangan, mengangkat kaki kanan, 3 detik.',
                    'text' => 'Berdiri: Berpegangan pada bangku besar dengan satu tangan, mengangkat kaki kanan, 3 detik.',
                ],
                55 => [
                    'no' => 55,
                    'position' => 'Berdiri',
                    'action' => 'Berpegangan pada bangku besar dengan satu tangan, mengangkat kaki kiri, 3 detik.',
                    'text' => 'Berdiri: Berpegangan pada bangku besar dengan satu tangan, mengangkat kaki kiri, 3 detik.',
                ],
                56 => [
                    'no' => 56,
                    'position' => 'Berdiri',
                    'action' => 'Bertahan, lengan bebas, 20 detik.',
                    'text' => 'Berdiri: Bertahan, lengan bebas, 20 detik.',
                ],
                57 => [
                    'no' => 57,
                    'position' => 'Berdiri',
                    'action' => 'Mengangkat kaki kiri, lengan bebas, 10 detik.',
                    'text' => 'Berdiri: Mengangkat kaki kiri, lengan bebas, 10 detik.',
                ],
                58 => [
                    'no' => 58,
                    'position' => 'Berdiri',
                    'action' => 'Mengangkat kaki kanan, lengan bebas, 10 detik.',
                    'text' => 'Berdiri: Mengangkat kaki kanan, lengan bebas, 10 detik.',
                ],
                59 => [
                    'no' => 59,
                    'position' => 'Duduk di bangku kecil',
                    'action' => 'Berdiri tanpa menggunakan lengan.',
                    'text' => 'Duduk di bangku kecil: Berdiri tanpa menggunakan lengan.',
                ],
                60 => [
                    'no' => 60,
                    'position' => 'Berlutut tinggi',
                    'action' => 'Berdiri melalui posisi setengah berlutut pada lutut kanan, tanpa menggunakan lengan.',
                    'text' => 'Berlutut tinggi: Berdiri melalui posisi setengah berlutut pada lutut kanan, tanpa menggunakan lengan.',
                ],
                61 => [
                    'no' => 61,
                    'position' => 'Berlutut tinggi',
                    'action' => 'Berdiri melalui posisi setengah berlutut pada lutut kiri, tanpa menggunakan lengan.',
                    'text' => 'Berlutut tinggi: Berdiri melalui posisi setengah berlutut pada lutut kiri, tanpa menggunakan lengan.',
                ],
                62 => [
                    'no' => 62,
                    'position' => 'Berdiri',
                    'action' => 'Menurunkan badan ke posisi duduk di lantai dengan terkontrol, lengan bebas.',
                    'text' => 'Berdiri: Menurunkan badan ke posisi duduk di lantai dengan terkontrol, lengan bebas.',
                ],
                63 => [
                    'no' => 63,
                    'position' => 'Berdiri',
                    'action' => 'Melakukan posisi jongkok, lengan bebas.',
                    'text' => 'Berdiri: Melakukan posisi jongkok, lengan bebas.',
                ],
                64 => [
                    'no' => 64,
                    'position' => 'Berdiri',
                    'action' => 'Mengambil benda dari lantai, lengan bebas, kembali berdiri.',
                    'text' => 'Berdiri: Mengambil benda dari lantai, lengan bebas, kembali berdiri.',
                ],
            ],
        ],

        'E' => [
            'key' => 'E',
            'title' => 'Dimensi E: Berjalan, Berlari & Melompat',
            'name' => 'Berjalan, Berlari & Melompat',
            'total_items' => 24,
            'max_score' => 72,
            'items' => [
                65 => [
                    'no' => 65,
                    'position' => 'Berdiri, 2 tangan di bangku besar',
                    'action' => 'Berjalan menyamping (cruise) 5 langkah ke kanan.',
                    'text' => 'Berdiri, 2 tangan di bangku besar: Berjalan menyamping (cruise) 5 langkah ke kanan.',
                ],
                66 => [
                    'no' => 66,
                    'position' => 'Berdiri, 2 tangan di bangku besar',
                    'action' => 'Berjalan menyamping (cruise) 5 langkah ke kiri.',
                    'text' => 'Berdiri, 2 tangan di bangku besar: Berjalan menyamping (cruise) 5 langkah ke kiri.',
                ],
                67 => [
                    'no' => 67,
                    'position' => 'Berdiri, 2 tangan dipegang',
                    'action' => 'Berjalan maju 10 langkah.',
                    'text' => 'Berdiri, 2 tangan dipegang: Berjalan maju 10 langkah.',
                ],
                68 => [
                    'no' => 68,
                    'position' => 'Berdiri, 1 tangan dipegang',
                    'action' => 'Berjalan maju 10 langkah.',
                    'text' => 'Berdiri, 1 tangan dipegang: Berjalan maju 10 langkah.',
                ],
                69 => [
                    'no' => 69,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan maju 10 langkah.',
                    'text' => 'Berdiri: Berjalan maju 10 langkah.',
                ],
                70 => [
                    'no' => 70,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan maju 10 langkah, berhenti, berputar 180°, kembali.',
                    'text' => 'Berdiri: Berjalan maju 10 langkah, berhenti, berputar 180°, kembali.',
                ],
                71 => [
                    'no' => 71,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan mundur 10 langkah.',
                    'text' => 'Berdiri: Berjalan mundur 10 langkah.',
                ],
                72 => [
                    'no' => 72,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan maju 10 langkah sambil membawa benda besar dengan 2 tangan.',
                    'text' => 'Berdiri: Berjalan maju 10 langkah sambil membawa benda besar dengan 2 tangan.',
                ],
                73 => [
                    'no' => 73,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan maju 10 langkah berturut-turut di antara dua garis sejajar berjarak 20 cm.',
                    'text' => 'Berdiri: Berjalan maju 10 langkah berturut-turut di antara dua garis sejajar berjarak 20 cm.',
                ],
                74 => [
                    'no' => 74,
                    'position' => 'Berdiri',
                    'action' => 'Berjalan maju 10 langkah berturut-turut di atas garis lurus selebar 2 cm.',
                    'text' => 'Berdiri: Berjalan maju 10 langkah berturut-turut di atas garis lurus selebar 2 cm.',
                ],
                75 => [
                    'no' => 75,
                    'position' => 'Berdiri',
                    'action' => 'Melangkahi tongkat setinggi lutut, kaki kanan memimpin.',
                    'text' => 'Berdiri: Melangkahi tongkat setinggi lutut, kaki kanan memimpin.',
                ],
                76 => [
                    'no' => 76,
                    'position' => 'Berdiri',
                    'action' => 'Melangkahi tongkat setinggi lutut, kaki kiri memimpin.',
                    'text' => 'Berdiri: Melangkahi tongkat setinggi lutut, kaki kiri memimpin.',
                ],
                77 => [
                    'no' => 77,
                    'position' => 'Berdiri',
                    'action' => 'Berlari 4,5 meter, berhenti & kembali.',
                    'text' => 'Berdiri: Berlari 4,5 meter, berhenti & kembali.',
                ],
                78 => [
                    'no' => 78,
                    'position' => 'Berdiri',
                    'action' => 'Menendang bola dengan kaki kanan.',
                    'text' => 'Berdiri: Menendang bola dengan kaki kanan.',
                ],
                79 => [
                    'no' => 79,
                    'position' => 'Berdiri',
                    'action' => 'Menendang bola dengan kaki kiri.',
                    'text' => 'Berdiri: Menendang bola dengan kaki kiri.',
                ],
                80 => [
                    'no' => 80,
                    'position' => 'Berdiri',
                    'action' => 'Melompat setinggi 30 cm, kedua kaki bersamaan.',
                    'text' => 'Berdiri: Melompat setinggi 30 cm, kedua kaki bersamaan.',
                ],
                81 => [
                    'no' => 81,
                    'position' => 'Berdiri',
                    'action' => 'Melompat ke depan sejauh 30 cm, kedua kaki bersamaan.',
                    'text' => 'Berdiri: Melompat ke depan sejauh 30 cm, kedua kaki bersamaan.',
                ],
                82 => [
                    'no' => 82,
                    'position' => 'Berdiri di kaki kanan',
                    'action' => 'Melompat dengan kaki kanan (hop) 10 kali di dalam lingkaran berdiameter 60 cm.',
                    'text' => 'Berdiri di kaki kanan: Melompat dengan kaki kanan (hop) 10 kali di dalam lingkaran berdiameter 60 cm.',
                ],
                83 => [
                    'no' => 83,
                    'position' => 'Berdiri di kaki kiri',
                    'action' => 'Melompat dengan kaki kiri (hop) 10 kali di dalam lingkaran berdiameter 60 cm.',
                    'text' => 'Berdiri di kaki kiri: Melompat dengan kaki kiri (hop) 10 kali di dalam lingkaran berdiameter 60 cm.',
                ],
                84 => [
                    'no' => 84,
                    'position' => 'Berdiri, memegang 1 pegangan tangga',
                    'action' => 'Naik 4 anak tangga dengan kaki bergantian.',
                    'text' => 'Berdiri, memegang 1 pegangan tangga: Naik 4 anak tangga dengan kaki bergantian.',
                ],
                85 => [
                    'no' => 85,
                    'position' => 'Berdiri, memegang 1 pegangan tangga',
                    'action' => 'Turun 4 anak tangga dengan kaki bergantian.',
                    'text' => 'Berdiri, memegang 1 pegangan tangga: Turun 4 anak tangga dengan kaki bergantian.',
                ],
                86 => [
                    'no' => 86,
                    'position' => 'Berdiri',
                    'action' => 'Naik 4 anak tangga dengan kaki bergantian (tanpa pegangan).',
                    'text' => 'Berdiri: Naik 4 anak tangga dengan kaki bergantian (tanpa pegangan).',
                ],
                87 => [
                    'no' => 87,
                    'position' => 'Berdiri',
                    'action' => 'Turun 4 anak tangga dengan kaki bergantian (tanpa pegangan).',
                    'text' => 'Berdiri: Turun 4 anak tangga dengan kaki bergantian (tanpa pegangan).',
                ],
                88 => [
                    'no' => 88,
                    'position' => 'Berdiri di atas anak tangga 15 cm',
                    'action' => 'Melompat turun, kedua kaki bersamaan.',
                    'text' => 'Berdiri di atas anak tangga 15 cm: Melompat turun, kedua kaki bersamaan.',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Formula & Petunjuk Perhitungan Skor Akhir
    |--------------------------------------------------------------------------
    */
    'scoring_guide' => [
        'formula_dimension' => 'Total Skor Dimensi ÷ Skor Maksimal Dimensi × 100%',
        'formula_total' => '(%A + %B + %C + %D + %E) ÷ 5',
        'notes' => [
            'Pengujian dengan Alat Bantu / Ortosis: Terdapat bagian khusus untuk mencatat pengujian yang menggunakan walker, tongkat, AFO, atau alat bantu lainnya.',
            'Jika ada item yang Tidak Diuji (NT), skor maksimal dimensi disesuaikan dengan mengurangi jumlah item yang tidak diuji dikalikan 3.',
        ],
    ],
];
