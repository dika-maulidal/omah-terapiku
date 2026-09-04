<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Rekam;
use App\Models\RekamDiagnosa;
use App\Models\RekamAssessment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // 1. AKUN USER & PETUGAS
        // =========================================================================
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@rekammedis.local'],
            [
                'name' => 'Administrator Omah Terapi-KU',
                'nip' => '199001012026011001',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 1,
                'status' => 1,
            ]
        );

        $regisUser = User::updateOrCreate(
            ['email' => 'registrasi@rekammedis.local'],
            [
                'name' => 'Petugas Registrasi & Asesmen',
                'nip' => '199101012026011002',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role' => 2,
                'status' => 1,
            ]
        );

        // =========================================================================
        // 2. AKUN & PROFIL TERAPIS (DOKTER) SESUAI UPT OMAH TERAPI-KU
        // =========================================================================
        
        // Terapis 1: Fisioterapi ABK - UPT PPSAB Sidoarjo
        $userTerapis1 = User::updateOrCreate(
            ['email' => 'terapis.ppsab@rekammedis.local'],
            [
                'name' => 'Budi Hartanto, S.Tr.Kes',
                'nip' => '199201012026011003',
                'phone' => '085123456781',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        $terapis1 = Dokter::updateOrCreate(
            ['user_id' => $userTerapis1->id],
            [
                'nama' => 'Budi Hartanto, S.Tr.Kes',
                'no_hp' => '085123456781',
                'alamat' => 'Sidoarjo',
                'poli' => 'UPT PPSAB Sidoarjo',
                'status' => 1,
            ]
        );

        // Terapis 2: Fisioterapi & Stimulasi Motorik - UPT PPSAB Sidoarjo
        $userTerapis2 = User::updateOrCreate(
            ['email' => 'fauzi.fisioterapi@rekammedis.local'],
            [
                'name' => 'Ahmad Fauzi, S.Tr.FT',
                'nip' => '199305102026011004',
                'phone' => '085123456782',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        $terapis2 = Dokter::updateOrCreate(
            ['user_id' => $userTerapis2->id],
            [
                'nama' => 'Ahmad Fauzi, S.Tr.FT',
                'no_hp' => '085123456782',
                'alamat' => 'Sidoarjo',
                'poli' => 'UPT PPSAB Sidoarjo',
                'status' => 1,
            ]
        );

        // Terapis 3: Terapi Wicara & Oral Motor - UPT PPSAB Sidoarjo
        $userTerapis3 = User::updateOrCreate(
            ['email' => 'dewi.wicara@rekammedis.local'],
            [
                'name' => 'Dewi Lestari, A.Md.TW',
                'nip' => '199508202026012001',
                'phone' => '085123456783',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        $terapis3 = Dokter::updateOrCreate(
            ['user_id' => $userTerapis3->id],
            [
                'nama' => 'Dewi Lestari, A.Md.TW',
                'no_hp' => '085123456783',
                'alamat' => 'Sidoarjo',
                'poli' => 'UPT PPSAB Sidoarjo',
                'status' => 1,
            ]
        );

        // Terapis 4: Terapi Okupasi & ADL - Balai PRS PMKS Sidoarjo
        $userTerapis4 = User::updateOrCreate(
            ['email' => 'terapis.pmks@rekammedis.local'],
            [
                'name' => 'Siti Rahmawati, A.Md.OT',
                'nip' => '199301012026011005',
                'phone' => '085123456784',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        $terapis4 = Dokter::updateOrCreate(
            ['user_id' => $userTerapis4->id],
            [
                'nama' => 'Siti Rahmawati, A.Md.OT',
                'no_hp' => '085123456784',
                'alamat' => 'Sidoarjo',
                'poli' => 'Balai PRS PMKS Sidoarjo',
                'status' => 1,
            ]
        );

        // Terapis 5: Orientasi & Mobilitas Disabilitas Netra - UPT RSBN Malang
        $userTerapis5 = User::updateOrCreate(
            ['email' => 'terapis.rsbn@rekammedis.local'],
            [
                'name' => 'Dadar Putra, S.Pd',
                'nip' => '199401012026011006',
                'phone' => '085123456785',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        $terapis5 = Dokter::updateOrCreate(
            ['user_id' => $userTerapis5->id],
            [
                'nama' => 'Dadar Putra, S.Pd',
                'no_hp' => '085123456785',
                'alamat' => 'Malang',
                'poli' => 'UPT RSBN Malang',
                'status' => 1,
            ]
        );

        // =========================================================================
        // 3. 10 DATA PENERIMA MANFAAT (PASIEN) BERAGAM KASUS & UPT
        // =========================================================================
        $pasiensData = [
            // 1. Muhammad Rizky Pratama (Anak - CP Spastik Diplegia)
            [
                'no_rm' => 'OTK-26-00001',
                'nama' => 'Muhammad Rizky Pratama',
                'nik' => '3515081205180001',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '2018-05-12',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Jl. Pahlawan No. 45 RT 02 RW 03',
                'kelurahan' => 'Sidokumpul',
                'kecamatan' => 'Sidoarjo',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61212',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'SD/SDLB',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '1',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'nama_wali' => 'Bambang Pratama',
                'hubungan_wali' => 'Ayah Kandung',
                'jenis_disabilitas' => 'Fisik & Motorik (Cerebral Palsy Spastik Diplegia)',
                'alat_bantu' => 'AFO (Ankle Foot Orthosis), Walker Roda',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560001',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567801',
                'alergi' => 'Tidak Ada',
            ],
            // 2. Alya Nur Salsabila (Anak - Down Syndrome / Hipotonus)
            [
                'no_rm' => 'OTK-26-00002',
                'nama' => 'Alya Nur Salsabila',
                'nik' => '3515085409200002',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '2020-09-14',
                'jk' => 'Perempuan',
                'alamat_lengkap' => 'Dusun Krajan RT 03 RW 01',
                'kelurahan' => 'Candi',
                'kecamatan' => 'Candi',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61271',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'PAUD/TK Inklusi',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '2',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'nama_wali' => 'Endah Wahyuni',
                'hubungan_wali' => 'Ibu Kandung',
                'jenis_disabilitas' => 'Intelektual & Perkembangan (Down Syndrome / GDD)',
                'alat_bantu' => 'Tidak Ada',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560002',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567802',
                'alergi' => 'Dingin / Debu',
            ],
            // 3. Dimas Arya Nugraha (Anak - Autism & Speech Delay)
            [
                'no_rm' => 'OTK-26-00003',
                'nama' => 'Dimas Arya Nugraha',
                'nik' => '3515122502190003',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '2019-02-25',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Perum Taman Anggrek Blok B-12',
                'kelurahan' => 'Buduran',
                'kecamatan' => 'Buduran',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61252',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'TK Inklusi',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '3',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'nama_wali' => 'Hendra Nugraha',
                'hubungan_wali' => 'Ayah Kandung',
                'jenis_disabilitas' => 'Mental & Perilaku (Autism Spectrum Disorder / Speech Delay)',
                'alat_bantu' => 'Kartu Komunikasi PECS',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560003',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567803',
                'alergi' => 'Tidak Ada',
            ],
            // 4. Suryo Pranoto, SH (Dewasa/Lansia - Hemiparesis Pasca Stroke)
            [
                'no_rm' => 'OTK-26-00004',
                'nama' => 'Suryo Pranoto, SH',
                'nik' => '3515091807650004',
                'tmp_lahir' => 'Surabaya',
                'tgl_lahir' => '1965-07-18',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Jl. Gajah Mada No. 88',
                'kelurahan' => 'Magersari',
                'kecamatan' => 'Sidoarjo',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61211',
                'agama' => 'Islam',
                'status_menikah' => 'Menikah',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Pensiunan PNS',
                'desil' => '3',
                'upt_lokasi' => 'Balai PRS PMKS Sidoarjo',
                'nama_wali' => 'Sri Wahyuni',
                'hubungan_wali' => 'Istri',
                'jenis_disabilitas' => 'Fisik (Hemiparesis Dextra Pasca Stroke Iskemik)',
                'alat_bantu' => 'Tongkat Kaki Empat (Quadripod)',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560004',
                'cara_bayar' => 'BPJS Kesehatan PBI',
                'no_bpjs' => '0001234567804',
                'alergi' => 'Penisilin',
            ],
            // 5. Bayu Hendrawan (Dewasa - Disabilitas Netra Total)
            [
                'no_rm' => 'OTK-26-00005',
                'nama' => 'Bayu Hendrawan',
                'nik' => '3573011003980005',
                'tmp_lahir' => 'Malang',
                'tgl_lahir' => '1998-03-10',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Jl. Danau Toba No. 15',
                'kelurahan' => 'Sawojajar',
                'kecamatan' => 'Kedungkandang',
                'kabupaten' => 'Kota Malang',
                'kodepos' => '65139',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'SMA/SMALB',
                'pekerjaan' => 'Pengrajin / Wiraswasta',
                'desil' => '1',
                'upt_lokasi' => 'UPT RSBN Malang',
                'nama_wali' => 'Sunarto',
                'hubungan_wali' => 'Ayah Kandung',
                'jenis_disabilitas' => 'Sensorik Netra (Total Blindness / Amaurosis)',
                'alat_bantu' => 'Tongkat Putih (White Cane), Jam Tangan Suara',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560005',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567805',
                'alergi' => 'Tidak Ada',
            ],
            // 6. Cantika Putri Maharani (Anak - Low Vision Berat & Motorik)
            [
                'no_rm' => 'OTK-26-00006',
                'nama' => 'Cantika Putri Maharani',
                'nik' => '3573036211170006',
                'tmp_lahir' => 'Malang',
                'tgl_lahir' => '2017-11-22',
                'jk' => 'Perempuan',
                'alamat_lengkap' => 'Jl. Ijen No. 42',
                'kelurahan' => 'Oro-oro Dowo',
                'kecamatan' => 'Klojen',
                'kabupaten' => 'Kota Malang',
                'kodepos' => '65119',
                'agama' => 'Kristen',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'SDLB-A Malang',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '2',
                'upt_lokasi' => 'UPT RSBN Malang',
                'nama_wali' => 'Yohanes Maharani',
                'hubungan_wali' => 'Ayah Kandung',
                'jenis_disabilitas' => 'Sensorik Netra (Low Vision Berat) & Motorik',
                'alat_bantu' => 'Kacamata Prisma Khusus, Tongkat Putih',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560006',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567806',
                'alergi' => 'Tidak Ada',
            ],
            // 7. Ahmad Danu Wijaya (Anak - Delayed Walking & Hipotonus)
            [
                'no_rm' => 'OTK-26-00007',
                'nama' => 'Ahmad Danu Wijaya',
                'nik' => '3515150808210007',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '2021-08-08',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Desa Wage RT 05 RW 02',
                'kelurahan' => 'Wage',
                'kecamatan' => 'Taman',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61257',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'Belum Sekolah',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '1',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'nama_wali' => 'Fitri Handayani',
                'hubungan_wali' => 'Ibu Kandung',
                'jenis_disabilitas' => 'Fisik & Motorik (Delayed Walking / Hipotonus)',
                'alat_bantu' => 'Sepatu Ortopedi',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560007',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567807',
                'alergi' => 'Tidak Ada',
            ],
            // 8. Rina Kartika Sari (Dewasa - Paraparesis Pasca Trauma)
            [
                'no_rm' => 'OTK-26-00008',
                'nama' => 'Rina Kartika Sari',
                'nik' => '3515075510920008',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '1992-10-15',
                'jk' => 'Perempuan',
                'alamat_lengkap' => 'Jl. Raya Krian No. 102',
                'kelurahan' => 'Krian',
                'kecamatan' => 'Krian',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61262',
                'agama' => 'Islam',
                'status_menikah' => 'Menikah',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'desil' => '2',
                'upt_lokasi' => 'Balai PRS PMKS Sidoarjo',
                'nama_wali' => 'Agus Setiawan',
                'hubungan_wali' => 'Suami',
                'jenis_disabilitas' => 'Fisik (Post-Trauma Paraparesis / Cedera Tulang Belakang)',
                'alat_bantu' => 'Kursi Roda Manual',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560008',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567808',
                'alergi' => 'Tidak Ada',
            ],
            // 9. Fajar Maulana (Anak - Speech Delay & Sensori Integrasi)
            [
                'no_rm' => 'OTK-26-00009',
                'nama' => 'Fajar Maulana',
                'nik' => '3515082104200009',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '2020-04-21',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Jl. Trunojoyo No. 19',
                'kelurahan' => 'Sidoklumpuk',
                'kecamatan' => 'Sidoarjo',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61218',
                'agama' => 'Islam',
                'status_menikah' => 'Belum Menikah',
                'pendidikan' => 'PAUD',
                'pekerjaan' => 'Belum Bekerja',
                'desil' => '1',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'nama_wali' => 'Nurul Hidayati',
                'hubungan_wali' => 'Ibu Kandung',
                'jenis_disabilitas' => 'Wicara & Sensori (Speech Delay & Sensori Integrasi)',
                'alat_bantu' => 'Tidak Ada',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560009',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567809',
                'alergi' => 'Kacang',
            ],
            // 10. Mbah Supardi (Lansia - WBS Balai / Osteoarthritis & Gangguan Gait)
            [
                'no_rm' => 'OTK-26-00010',
                'nama' => 'Mbah Supardi',
                'nik' => '3515080101500010',
                'tmp_lahir' => 'Sidoarjo',
                'tgl_lahir' => '1950-01-01',
                'jk' => 'Laki-Laki',
                'alamat_lengkap' => 'Jl. Lingkar Timur No. 7',
                'kelurahan' => 'Prasung',
                'kecamatan' => 'Buduran',
                'kabupaten' => 'Kab. Sidoarjo',
                'kodepos' => '61252',
                'agama' => 'Islam',
                'status_menikah' => 'Duda',
                'pendidikan' => 'SD',
                'pekerjaan' => 'Tidak Bekerja / WBS Balai',
                'desil' => '1',
                'upt_lokasi' => 'Balai PRS PMKS Sidoarjo',
                'nama_wali' => 'Pendamping Balai PRS PMKS',
                'hubungan_wali' => 'Petugas Pendamping',
                'jenis_disabilitas' => 'Fisik & Lansia (Osteoarthritis Lutut Bilateral & Gangguan Keseimbangan)',
                'alat_bantu' => 'Tongkat Kaki Tiga (Tripod)',
                'kewarganegaraan' => 'WNI',
                'no_hp' => '081234560010',
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'no_bpjs' => '0001234567810',
                'alergi' => 'Tidak Ada',
            ],
        ];

        $createdPasiens = [];
        foreach ($pasiensData as $pData) {
            $p = Pasien::updateOrCreate(
                ['no_rm' => $pData['no_rm']],
                $pData
            );
            $createdPasiens[$pData['no_rm']] = $p;
        }

        // =========================================================================
        // 4. 5 REKAM MEDIS DENGAN DETAIL KLINIS & ASESMEN LENGKAP
        // =========================================================================

        // -------------------------------------------------------------------------
        // REKAM 1: Muhammad Rizky Pratama (Anak CP Diplegia) - UPT PPSAB Sidoarjo
        // -------------------------------------------------------------------------
        $p1 = $createdPasiens['OTK-26-00001'];
        $rekam1 = Rekam::updateOrCreate(
            ['no_rekam' => 'RM-26-00001'],
            [
                'tgl_rekam' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'pasien_id' => $p1->id,
                'dokter_id' => $terapis1->id,
                'terapis_pendamping_id' => $terapis3->id,
                'poli' => 'UPT PPSAB Sidoarjo',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'layanan_terapi' => 'Fisioterapi & Stimulasi Motorik',
                'sesi_waktu' => '08:30 - 09:30',
                'keluhan' => 'Kekakuan pada kedua tungkai kaki, sering jinjit saat berdiri, dan kesulitan melangkah mandiri tanpa pegangan.',
                'pemeriksaan' => 'Spastisitas adduktor dan gastrocnemius (Asworth Scale 2). Kontraktur ringan sendi pergelangan kaki. Pola jalan scissoring gait.',
                'diagnosa' => 'Cerebral Palsy Spastik Diplegia (G80.1)',
                'tindakan' => 'Stretching adduktor & gastrocnemius, Latihan Transfer Sit-to-Stand, Gait Training dengan AFO.',
                'biaya_pemeriksaan' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'status' => 4, // Selesai
                'petugas_id' => $regisUser->id,
            ]
        );

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam1->id, 'diagnosa' => 'G80.1'],
            ['pasien_id' => $p1->id]
        );

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekam1->id],
            [
                'pasien_id' => $p1->id,
                'dokter_id' => $terapis1->id,
                'jenis_assessment' => 'Fisioterapi & Stimulasi Motorik',
                'tgl_assessment' => Carbon::now()->subDays(2)->format('Y-m-d'),

                // Nyeri
                'nyeri_skor_total' => 2,
                'nyeri_saat_istirahat' => 0,
                'nyeri_saat_aktivitas' => 2,
                'nyeri_lokasi_keluhan' => 'Kedua betis dan pergelangan kaki',
                'nyeri_sifat' => ['Kaku', 'Pegal'],
                'nyeri_catatan' => 'Nyeri timbul saat peregangan pasif tendon Achilles (dorsifleksi maksimal).',

                // Motorik
                'motorik_mengangkat_kepala' => 'Mampu mandiri tegak > 1 menit',
                'motorik_posisi_tengkurap' => 'Mampu bertumpu pada lengan dan mengangkat dada',
                'motorik_posisi_duduk' => 'Mampu duduk mandiri di kursi dengan sandaran tegak',
                'motorik_merangkak' => 'Merangkak dengan pola reciprocal namun panggul agak tinggi',
                'motorik_berlutut' => 'Mampu high kneeling dengan bantuan pegangan 1 tangan',
                'motorik_berjalan' => 'Berjalan dengan bantuan walker dan AFO bilateral (scissoring gait ringan)',
                'motorik_catatan' => 'Keseimbangan statis cukup baik, keseimbangan dinamis saat melangkah membutuhkan koreksi postur panggul.',

                // ADL
                'adl_kontak_mata' => 'Sangat baik, mampu mempertahankan kontak mata > 15 detik',
                'adl_duduk_tenang' => 'Mampu duduk tenang selama sesi latihan 30 menit',
                'adl_gerakan_berulang' => 'Tidak ditemukan gerakan stereotipik',
                'adl_respon_nama' => 'Merespon spontan saat dipanggil namanya',
                'adl_makan' => 'Mampu makan sendiri dengan sendok berpegangan besar',
                'adl_mandi' => 'Membutuhkan bantuan minimal untuk menggosok punggung dan kaki',
                'adl_berpakaian' => 'Mampu memakai kaos mandiri, membutuhkan bantuan untuk kancing dan celana',
                'adl_bak' => 'Mandiri dengan pendampingan transfer ke toilet',
                'adl_bab' => 'Mandiri dengan pendampingan',
                'adl_catatan' => 'Kemandirian fungsional harian mencapai 75% dengan modifikasi lingkungan rumah.',

                // Wicara
                'wicara_komunikasi' => 'Verbal aktif, mampu menyusun 4-5 kata per kalimat',
                'wicara_organ' => 'Simetris, tidak ada deviasi lidah atau bibir',
                'wicara_makan_menelan' => 'Mengunyah dan menelan baik, tidak ada riwayat tersedak',
                'wicara_catatan' => 'Kemampuan komunikasi sangat kooperatif dan memahami instruksi 2 tahap.',

                // Neurologis & Refleks
                'neuro_sensasi' => 'Intak bilateral',
                'neuro_refleks_bisep_d' => '+2',
                'neuro_refleks_bisep_s' => '+2',
                'neuro_refleks_patela_d' => '+3',
                'neuro_refleks_patela_s' => '+3',
                'neuro_refleks_achilles_d' => '+3',
                'neuro_refleks_achilles_s' => '+3',
                'neuro_tonus_otot' => 'Hipertonus Spastik (Asworth Scale 2 pada Adduktor & Gastrocnemius)',
                'neuro_catatan' => 'Tanda Upper Motor Neuron (UMN) dominan pada kedua ekstremitas bawah. Klonus pergelangan kaki 2-3 ketukan.',

                // Postur & BBS
                'postur_temuan' => ['Anterior Pelvic Tilt', 'Genu Valgum Bilateral', 'Equinus Ankle'],
                'keseimbangan_bbs_skor' => 34,
                'keseimbangan_tug_detik' => '22.5',
                'keseimbangan_romberg' => 'Positif Terbuka',
                'postur_keseimbangan_catatan' => 'BBS Skor 34/56, stabil saat duduk dan berdiri bertumpu dua kaki dengan pegangan.',

                // Gait & 10MWT
                'gait_karakteristik' => ['Scissoring Gait', 'Toe-Walking (Jinjit)', 'Cadence Menurun'],
                'gait_10mwt_kecepatan_nyaman' => '0.45 m/s',
                'gait_10mwt_kecepatan_cepat' => '0.58 m/s',
                'gait_10mwt_jumlah_langkah' => '28',
                'gait_catatan' => 'Waktu tempuh 10 meter: 22.2 detik (0.45 m/s). Butuh edukasi heel strike.',

                // Sensoris & Vestibular
                'sensoris_taktil_raba_halus' => 'Intak bilateral',
                'sensoris_posisi_sendi' => 'Intak pada jari tangan dan jari kaki',
                'sensoris_vibrasi' => 'Normal',
                'vestibular_hit' => 'Negatif (Normal VOR)',
                'sensoris_catatan' => 'Fungsi propriosepsi sendi intak.',

                // Faktor Psikososial
                'psikososial_faktor_psikologis' => 'Anak ceria, motivasi tinggi untuk bisa berjalan tanpa walker.',
                'psikososial_dukungan_sosial' => 'Dukungan kedua orang tua sangat kuat dan disiplin home exercise.',
                'psikososial_harapan_pasien' => 'Ingin bisa bermain bola bersama teman-teman sekolah.',
                'psikososial_catatan' => 'Undak-undakan di pintu masuk rumah belum ada ramp.',

                // GMFM-88
                'gmfm_dimensi_a_total' => 48,
                'gmfm_dimensi_a_persen' => 94.1,
                'gmfm_dimensi_b_total' => 52,
                'gmfm_dimensi_b_persen' => 86.7,
                'gmfm_dimensi_c_total' => 38,
                'gmfm_dimensi_c_persen' => 90.5,
                'gmfm_dimensi_d_total' => 24,
                'gmfm_dimensi_d_persen' => 61.5,
                'gmfm_dimensi_e_total' => 18,
                'gmfm_dimensi_e_persen' => 25.0,
                'gmfm_total_score' => 180,
                'gmfm_total_persen' => 68.5,

                // Kesimpulan, Rencana & Dosis Terapi
                'kesimpulan' => 'Penerima manfaat dengan CP Spastik Diplegia menunjukkan potensi motorik baik (GMFM 68.5%), target peningkatan kemandirian ambulasi dengan tongkat ketiak/elbow crutch dalam 3 bulan.',
                'rencana_dosis_frekuensi' => '2x Seminggu',
                'rencana_dosis_durasi' => '60 Menit per Sesi',
                'rencana_dosis_total_sesi' => '24 Sesi',
                'rencana_dosis_reassessment' => 'Setelah 12 Sesi (6 Minggu)',
                'rencana_modalitas_fisik' => ['Infrared Radiation (IRR)', 'TENS Sedang'],
                'rencana_manual_terapi' => ['Passive Stretching Gastrocnemius', 'Mobilisasi Sendi Ankle'],
                'rencana_latihan_terapi' => ['Gait Training Heel-Toe', 'Core Stability Exercise', 'Balance Board Training'],
                'rencana_edukasi_konseling' => ['Home program stretching harian', 'Pemasangan AFO yang benar', 'Modifikasi ramp pintu masuk rumah'],
                'rencana_terapi' => 'Fisioterapi motorik terpadu, latihan penguatan inti tubuh, dan peregangan spastisitas.',
            ]
        );

        // -------------------------------------------------------------------------
        // REKAM 2: Alya Nur Salsabila (Anak Down Syndrome) - UPT PPSAB Sidoarjo
        // -------------------------------------------------------------------------
        $p2 = $createdPasiens['OTK-26-00002'];
        $rekam2 = Rekam::updateOrCreate(
            ['no_rekam' => 'RM-26-00002'],
            [
                'tgl_rekam' => Carbon::now()->subDay()->format('Y-m-d'),
                'pasien_id' => $p2->id,
                'dokter_id' => $terapis2->id,
                'terapis_pendamping_id' => $terapis4->id,
                'poli' => 'UPT PPSAB Sidoarjo',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'layanan_terapi' => 'Sensori Integrasi & Okupasi',
                'sesi_waktu' => '09:30 - 10:30',
                'keluhan' => 'Kelemahan tonus otot (hipotonia), belum mampu melompat dengan dua kaki, dan konsentrasi cepat teralih.',
                'pemeriksaan' => 'Hipotonia generalisata, hipermobilitas sendi lutut dan siku. Denver II menunjukkan delay pada sektor motorik kasar dan bahasa.',
                'diagnosa' => 'Sindrom Down (Q90.9) & Global Developmental Delay (R62.0)',
                'tindakan' => 'Sensory Integration Therapy, Core Strengthening, Latihan Keseimbangan di Trampolin & Gym Ball.',
                'biaya_pemeriksaan' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'status' => 4, // Selesai
                'petugas_id' => $regisUser->id,
            ]
        );

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam2->id, 'diagnosa' => 'Q90.9'],
            ['pasien_id' => $p2->id]
        );
        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam2->id, 'diagnosa' => 'R62.0'],
            ['pasien_id' => $p2->id]
        );

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekam2->id],
            [
                'pasien_id' => $p2->id,
                'dokter_id' => $terapis2->id,
                'jenis_assessment' => 'Sensori Integrasi & Okupasi',
                'tgl_assessment' => Carbon::now()->subDay()->format('Y-m-d'),

                'nyeri_skor_total' => 0,
                'nyeri_catatan' => 'Tidak ada keluhan nyeri fisik.',

                'motorik_mengangkat_kepala' => 'Mampu mandiri',
                'motorik_posisi_tengkurap' => 'Mampu dengan baik',
                'motorik_posisi_duduk' => 'Duduk tegak mandiri di lantai',
                'motorik_merangkak' => 'Merangkak aktif',
                'motorik_berlutut' => 'Mampu berlutut mandiri',
                'motorik_berjalan' => 'Berjalan mandiri dengan langkah lebar (wide base gait), belum bisa melompat',
                'motorik_catatan' => 'Hipotonia menyebabkan mudah lelah saat aktivitas berdiri lama.',

                'adl_kontak_mata' => 'Cukup baik (8-10 detik)',
                'adl_duduk_tenang' => 'Rentang fokus 10-15 menit sebelum membutuhkan transisi sensori',
                'adl_makan' => 'Mampu makan biskuit dan finger food mandiri',
                'adl_mandi' => 'Bantuan sedang dari orang tua',
                'adl_berpakaian' => 'Mampu melepas celana karet sendiri',
                'adl_catatan' => 'Sangat menyukai stimulasi tekstur halus dan permainan air.',

                'wicara_komunikasi' => 'Mampu mengucapkan kata tunggal (Mama, Papa, Mau, Nasi)',
                'wicara_organ' => 'Sedikit protrusi lidah karena tonus otot mulut rendah',
                'wicara_makan_menelan' => 'Baik, terkadang mengunyah agak lambat',
                'wicara_catatan' => 'Disarankan pendampingan terapis wicara untuk artikulasi.',

                'neuro_tonus_otot' => 'Hipotonus Generalisata (Ligamentous Laxity)',

                'denver_pass_count' => 18,
                'denver_fail_count' => 5,
                'denver_kesimpulan' => 'Suspect Developmental Delay pada sektor motorik kasar dan bahasa ekspresif.',
                'denver_catatan' => 'Sektor personal sosial dan motorik halus berkembang sesuai usia.',

                'kesimpulan' => 'Anak dengan Down Syndrome menunjukkan perkembangan motorik positif, stimulasi difokuskan pada penguatan tonus otot postural dan sensori proprioseptif.',
                'rencana_dosis_frekuensi' => '2x Seminggu',
                'rencana_dosis_durasi' => '45 Menit per Sesi',
                'rencana_dosis_total_sesi' => '16 Sesi',
                'rencana_dosis_reassessment' => 'Setelah 8 Sesi (4 Minggu)',
                'rencana_modalitas_fisik' => ['Stimulasi Taktil Bertekstur', 'Ayunan Vestibular'],
                'rencana_manual_terapi' => ['Joint Compression Taktil', 'Tapping Otot Ekstensor'],
                'rencana_latihan_terapi' => ['Lompat Trampolin dengan Pegangan', 'Obstacle Course Merayap & Memanjat'],
                'rencana_edukasi_konseling' => ['Sensory diet di rumah', 'Permainan fisik aktif luar ruangan'],
                'rencana_terapi' => 'Okupasi terapi dengan pendekatan Sensori Integrasi dan penguatan otot postural.',
            ]
        );

        // -------------------------------------------------------------------------
        // REKAM 3: Suryo Pranoto, SH (Dewasa - Hemiparesis Pasca Stroke) - Balai PRS PMKS
        // -------------------------------------------------------------------------
        $p4 = $createdPasiens['OTK-26-00004'];
        $rekam3 = Rekam::updateOrCreate(
            ['no_rekam' => 'RM-26-00003'],
            [
                'tgl_rekam' => Carbon::now()->format('Y-m-d'),
                'pasien_id' => $p4->id,
                'dokter_id' => $terapis4->id,
                'terapis_pendamping_id' => $terapis1->id,
                'poli' => 'Balai PRS PMKS Sidoarjo',
                'upt_lokasi' => 'Balai PRS PMKS Sidoarjo',
                'layanan_terapi' => 'Terapi Okupasi & Rehabilitasi ADL',
                'sesi_waktu' => '10:30 - 11:30',
                'keluhan' => 'Kelemahan sisi tubuh kanan pasca serangan stroke 4 bulan lalu. Tangan kanan sulit memegang sendok dan mengancingkan baju.',
                'pemeriksaan' => 'Hemiparesis dextra grade MMT 3/5 pada ekstremitas atas dan 4/5 pada ekstremitas bawah. Barthel Index ADL: 65 (Ketergantungan Sedang).',
                'diagnosa' => 'Sekuela Infark Serebral / Hemiparesis Dextra (I69.3)',
                'tindakan' => 'Latihan Fine Motor & Grasping, Constraint-Induced Movement Therapy (CIMT) sederhana, Edukasi Kemandirian Berpakaian & Makan.',
                'biaya_pemeriksaan' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'cara_bayar' => 'BPJS Kesehatan PBI',
                'status' => 4, // Selesai
                'petugas_id' => $regisUser->id,
            ]
        );

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam3->id, 'diagnosa' => 'I69.3'],
            ['pasien_id' => $p4->id]
        );

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekam3->id],
            [
                'pasien_id' => $p4->id,
                'dokter_id' => $terapis4->id,
                'jenis_assessment' => 'Terapi Okupasi & Rehabilitasi ADL',
                'tgl_assessment' => Carbon::now()->format('Y-m-d'),

                'nyeri_skor_total' => 3,
                'nyeri_saat_istirahat' => 1,
                'nyeri_saat_aktivitas' => 3,
                'nyeri_lokasi_keluhan' => 'Bahu kanan (Shoulder Subluxation Ringan)',
                'nyeri_sifat' => ['Pegal', 'Tertarik'],
                'nyeri_catatan' => 'Nyeri muncul bila lengan kanan menggantung tanpa arm sling.',

                'motorik_posisi_duduk' => 'Mandiri stabil di kursi',
                'motorik_berjalan' => 'Berjalan mandiri dengan tongkat Quadripod (Hemiplegic Gait)',
                'motorik_catatan' => 'Sinergi ekstensor pada tungkai kanan, sinergi fleksor ringan pada siku dan jari kanan.',

                'adl_makan' => 'Butuh bantuan memasukkan makanan dengan sendok adaptif',
                'adl_mandi' => 'Bantuan parsial untuk menjangkau sisi punggung',
                'adl_berpakaian' => 'Mampu memakai kemeja berkancing dengan teknik one-handed method',
                'adl_bak' => 'Mandiri ke toilet dengan pegangan grab bar',
                'adl_bab' => 'Mandiri',
                'adl_catatan' => 'Barthel Index Total: 65/100 (Ketergantungan Sedang).',

                'neuro_refleks_bisep_d' => '+3',
                'neuro_refleks_bisep_s' => '+2',
                'neuro_refleks_patela_d' => '+3',
                'neuro_refleks_patela_s' => '+2',
                'neuro_tonus_otot' => 'Spastisitas Grade 1+ pada Fleksor Lengan Kanan',

                'postur_temuan' => ['Retraksi Skapula Kanan', 'Asimetri Beban Berdiri'],
                'keseimbangan_bbs_skor' => 38,
                'keseimbangan_tug_detik' => '18.4',

                'gait_karakteristik' => ['Hemiplegic Gait', 'Circumduction Gait Kanan'],
                'gait_10mwt_kecepatan_nyaman' => '0.62 m/s',
                'gait_10mwt_kecepatan_cepat' => '0.75 m/s',
                'gait_catatan' => 'Circumduction tungkai kanan saat fase swing.',

                'kesimpulan' => 'Penerima manfaat pasca stroke iskemik mengalami perbaikan fungsi motorik tungkai, fokus rehabilitasi okupasi pada fungsi genggaman tangan kanan dan proteksi sendi bahu.',
                'rencana_dosis_frekuensi' => '3x Seminggu',
                'rencana_dosis_durasi' => '60 Menit per Sesi',
                'rencana_dosis_total_sesi' => '24 Sesi',
                'rencana_dosis_reassessment' => 'Setelah 12 Sesi (4 Minggu)',
                'rencana_modalitas_fisik' => ['TENS Bahu Kanan', 'NMES Otot Ekstensor Pergelangan Tangan'],
                'rencana_manual_terapi' => ['Scapular Mobilization', 'Passive ROM Bahu dan Jari'],
                'rencana_latihan_terapi' => ['Pegboard & Grasping Exercise', 'Task-Specific Training Makan & Menulis'],
                'rencana_edukasi_konseling' => ['Positioning lengan saat tidur', 'Pencegahan risiko jatuh di kamar mandi'],
                'rencana_terapi' => 'Terapi okupasi fungsional dan latihan kemandirian ADL.',
            ]
        );

        // -------------------------------------------------------------------------
        // REKAM 4: Bayu Hendrawan (Dewasa Disabilitas Netra Total) - UPT RSBN Malang
        // -------------------------------------------------------------------------
        $p5 = $createdPasiens['OTK-26-00005'];
        $rekam4 = Rekam::updateOrCreate(
            ['no_rekam' => 'RM-26-00004'],
            [
                'tgl_rekam' => Carbon::now()->format('Y-m-d'),
                'pasien_id' => $p5->id,
                'dokter_id' => $terapis5->id,
                'terapis_pendamping_id' => $terapis2->id,
                'poli' => 'UPT RSBN Malang',
                'upt_lokasi' => 'UPT RSBN Malang',
                'layanan_terapi' => 'Orientasi & Mobilitas (O&M)',
                'sesi_waktu' => '13:00 - 14:00',
                'keluhan' => 'Kebutaan total kedua mata, membutuhkan bimbingan teknik tongkat putih untuk mobilitas rute luar balai dan lingkungan perkotaan.',
                'pemeriksaan' => 'Visus 0/0 (No Light Perception / NLP). Refleks auditori dan sensasi taktil telapak tangan dan kaki sangat baik.',
                'diagnosa' => 'Kebutaan Kedua Mata (H54.0)',
                'tindakan' => 'Latihan Touch Technique Tongkat Putih, Pengenalan Guiding Block & Landmark Luar Ruangan, Latihan Menyeberang Jalan Mandiri.',
                'biaya_pemeriksaan' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'status' => 3, // Menunggu / Selesai Diperiksa
                'petugas_id' => $regisUser->id,
            ]
        );

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam4->id, 'diagnosa' => 'H54.0'],
            ['pasien_id' => $p5->id]
        );

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekam4->id],
            [
                'pasien_id' => $p5->id,
                'dokter_id' => $terapis5->id,
                'jenis_assessment' => 'Orientasi & Mobilitas (O&M)',
                'tgl_assessment' => Carbon::now()->format('Y-m-d'),

                'penglihatan_klasifikasi' => 'Total Blindness',
                'penglihatan_onset' => 'Kongenital / Sejak Lahir',
                'penglihatan_visus_od' => '0 / NLP (No Light Perception)',
                'penglihatan_visus_os' => '0 / NLP (No Light Perception)',
                'penglihatan_persepsi_cahaya' => 'Tidak Ada Persepsi Cahaya',
                'penglihatan_alat_bantu' => ['Tongkat Putih (White Cane)', 'Screen Reader Smartphone'],
                'penglihatan_teknik_tongkat' => 'Two-Point Touch Technique & Shorelining',
                'penglihatan_catatan' => 'Menggunakan tongkat putih lipat 4 ruas dengan roller tip.',

                'motorik_posisi_duduk' => 'Mandiri tegak sempurna',
                'motorik_berjalan' => 'Berjalan mandiri dengan teknik two-point touch tongkat putih',
                'motorik_catatan' => 'Postur tubuh tegap, tidak ada kelainan muskuloskeletal.',

                'adl_makan' => 'Mandiri penuh dengan teknik orientasi arah jam piring (clock technique)',
                'adl_mandi' => 'Mandiri penuh',
                'adl_berpakaian' => 'Mandiri mengenali warna pakaian dengan tag kancing braille',
                'adl_catatan' => 'Kemandirian ADL personal sudah sangat matang.',

                'sensoris_taktil_raba_halus' => 'Intak / Sangat Peka',
                'sensoris_posisi_sendi' => 'Intak & Akurat',
                'sensoris_catatan' => 'Sangat peka pada ujung jari (mampu membaca Braille grade 2 dengan lancar).',

                'kesimpulan' => 'Penerima manfaat siap untuk fase pelatihan orientasi dan mobilitas tingkat lanjut (rute transportasi publik dan penyeberangan jalan raya bersinyal suara).',
                'rencana_dosis_frekuensi' => '2x Seminggu',
                'rencana_dosis_durasi' => '90 Menit per Sesi',
                'rencana_dosis_total_sesi' => '12 Sesi',
                'rencana_dosis_reassessment' => 'Setelah 6 Sesi (3 Minggu)',
                'rencana_latihan_terapi' => ['Two-Point Touch Technique', 'Shorelining Technique Trotoar', 'Sound Localization di Persimpangan'],
                'rencana_edukasi_konseling' => ['Safety travel di jalan umum', 'Interaksi sosial meminta bantuan arah bila tersesat'],
                'rencana_terapi' => 'Bimbingan Orientasi dan Mobilitas Luar Ruangan (Outdoor O&M).',
            ]
        );

        // -------------------------------------------------------------------------
        // REKAM 5: Dimas Arya Nugraha (Anak Autism & Speech Delay) - UPT PPSAB Sidoarjo
        // -------------------------------------------------------------------------
        $p3 = $createdPasiens['OTK-26-00003'];
        $rekam5 = Rekam::updateOrCreate(
            ['no_rekam' => 'RM-26-00005'],
            [
                'tgl_rekam' => Carbon::now()->format('Y-m-d'),
                'pasien_id' => $p3->id,
                'dokter_id' => $terapis3->id,
                'terapis_pendamping_id' => $terapis4->id,
                'poli' => 'UPT PPSAB Sidoarjo',
                'upt_lokasi' => 'UPT PPSAB Sidoarjo',
                'layanan_terapi' => 'Terapi Wicara & Oral Motor',
                'sesi_waktu' => '14:00 - 15:00',
                'keluhan' => 'Anak usia 7 tahun belum mampu merangkai 2-3 kata, artikulasi vokal belum jelas, dan sering menolak makanan bertekstur kasar.',
                'pemeriksaan' => 'Hipersensitivitas oral, tonus otot bibir dan lidah agak lemah (oral motor delay). Respon kontak mata 60%.',
                'diagnosa' => 'Gangguan Bahasa Ekspresif / Speech Delay (F80.1) & Autisme Masa Kanak (F84.0)',
                'tindakan' => 'Oral Motor Stimulation, Pijat Orofasial, Latihan Tiup & Fonasi Huruf Vokal, Stimulasi Kosakata Gambar Flashcard.',
                'biaya_pemeriksaan' => 0,
                'biaya_tindakan' => 0,
                'biaya_obat' => 0,
                'total_biaya' => 0,
                'cara_bayar' => 'Gratis / APBD Dinsos Prov Jatim',
                'status' => 2, // Pemeriksaan / Sedang Berjalan
                'petugas_id' => $regisUser->id,
            ]
        );

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam5->id, 'diagnosa' => 'F80.1'],
            ['pasien_id' => $p3->id]
        );
        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $rekam5->id, 'diagnosa' => 'F84.0'],
            ['pasien_id' => $p3->id]
        );

        RekamAssessment::updateOrCreate(
            ['rekam_id' => $rekam5->id],
            [
                'pasien_id' => $p3->id,
                'dokter_id' => $terapis3->id,
                'jenis_assessment' => 'Terapi Wicara & Oral Motor',
                'tgl_assessment' => Carbon::now()->format('Y-m-d'),

                'motorik_posisi_duduk' => 'Mandiri di kursi terapi',
                'motorik_berjalan' => 'Berjalan dan berlari aktif tanpa hambatan',
                'motorik_catatan' => 'Fisik motorik kasar berkembang sangat baik.',

                'adl_kontak_mata' => 'Mampu bertahan 5-8 detik bila dipancing media visual',
                'adl_duduk_tenang' => 'Mampu duduk fokus 15 menit dengan reward token',
                'adl_gerakan_berulang' => 'Flapping tangan ringan bila merasa cemas atau terlalu gembira',
                'adl_respon_nama' => 'Merespon pada panggilan ke-2 atau ke-3',
                'adl_makan' => 'Picky eater terhadap makanan renyah/kasar',
                'adl_catatan' => 'Memerlukan desensitisasi oral secara bertahap.',

                'wicara_komunikasi' => 'Non-verbal menuju verbal satu kata (menggunakan gestur menunjuk dan PECS)',
                'wicara_organ' => 'Bibir agak inkompeten saat istirahat, elevasi lidah belum maksimal',
                'wicara_makan_menelan' => 'Sering mengemut makanan lunak',
                'wicara_catatan' => 'Program difokuskan pada penguatan otot orofasial dan peniruan bunyi vokal (A, I, U, E, O).',

                'kesimpulan' => 'Anak menunjukkan perkembangan reseptif cukup baik namun ekspresif verbal terhambat karena kelemahan motorik oral dan regulasi sensori.',
                'rencana_dosis_frekuensi' => '2x Seminggu',
                'rencana_dosis_durasi' => '45 Menit per Sesi',
                'rencana_dosis_total_sesi' => '20 Sesi',
                'rencana_dosis_reassessment' => 'Setelah 10 Sesi (5 Minggu)',
                'rencana_latihan_terapi' => ['Oral Motor Massage Orofasial', 'Latihan Meniup Sedotan & Peluit', 'Stimulasi Flashcard Kata Kerja & Benda'],
                'rencana_edukasi_konseling' => ['Teknik desensitisasi sikat gigi bertekstur di rumah', 'Membatasi screen time gadget'],
                'rencana_terapi' => 'Terapi wicara oral motorik dan komunikasi fungsional PECS.',
            ]
        );
    }
}