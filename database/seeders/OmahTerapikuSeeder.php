<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class OmahTerapikuSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'nama' => 'UPT PPSAB Sidoarjo',
                'alamat' => 'Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo',
                'fokus_layanan' => 'Anak Berkebutuhan Khusus (ABK)',
                'status' => 1,
            ],
            [
                'nama' => 'Balai PRS PMKS Sidoarjo',
                'alamat' => 'Jl. Pahlawan No. 5, Sidokumpul, Sidoarjo',
                'fokus_layanan' => 'Dewasa, Lansia, ODGJ, Pasca-Stroke',
                'status' => 1,
            ],
            [
                'nama' => 'UPT RSBN Malang',
                'alamat' => 'Jl. Beringin No. 13, Bandungrejosari, Sukun, Kota Malang',
                'fokus_layanan' => 'Disabilitas Netra & Olahraga',
                'status' => 1,
            ],
        ];

        foreach ($units as $unit) {
            Poli::updateOrCreate(
                ['nama' => $unit['nama']],
                $unit
            );
        }
    }
}
