<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tindakan;

class TindakanSeeder extends Seeder
{
    public function run(): void
    {
        $tindakans = [
            // 1. Fisioterapi (FIS-01 s/d FIS-10)
            ['kode' => 'FIS-01', 'nama' => 'Hot Pack (Thermotherapy)', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-02', 'nama' => 'Infrared Radiation (IRR)', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-03', 'nama' => 'TENS (Transcutaneous Electrical Nerve Stimulation)', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-04', 'nama' => 'Stretching & Muscle Lengthening', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-05', 'nama' => 'Passive & Active ROM Exercise', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-06', 'nama' => 'Strengthening Exercise (Penguatan Otot)', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-07', 'nama' => 'Latihan Jalan (Gait Training) & Ambulasi', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-08', 'nama' => 'Balance & Coordination Training (Latihan Keseimbangan)', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-09', 'nama' => 'Chest Physiotherapy & Postural Drainage', 'poli' => 'Fisioterapi', 'harga' => 0],
            ['kode' => 'FIS-10', 'nama' => 'Mobilisasi Sendi & Manual Therapy', 'poli' => 'Fisioterapi', 'harga' => 0],

            // 2. Terapi Okupasi / Sensorik Integrasi (OKU-01 s/d OKU-08)
            ['kode' => 'OKU-01', 'nama' => 'Latihan Fine Motor (Motorik Halus)', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-02', 'nama' => 'Sensory Integration Therapy', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-03', 'nama' => 'Edukasi & Latihan ADL (Makan / Mandi / Berpakaian)', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-04', 'nama' => 'Hand Function & Grasping Exercise', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-05', 'nama' => 'Visual-Spatial & Perceptual Training', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-06', 'nama' => 'Snoezelen & Relaksasi Multisensori', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-07', 'nama' => 'Modifikasi Perilaku & Stimulasi Konsentrasi', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],
            ['kode' => 'OKU-08', 'nama' => 'Splinting & Orthotic Positioning', 'poli' => 'Terapi Okupasi / Sensorik Integrasi', 'harga' => 0],

            // 3. Terapi Wicara (WIC-01 s/d WIC-07)
            ['kode' => 'WIC-01', 'nama' => 'Oral Motor Exercise (Senam Otot Mulut/Lidah)', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-02', 'nama' => 'Latihan Artikulasi & Kejelasan Fonasi', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-03', 'nama' => 'Stimulasi Bahasa Ekspresif & Reseptif', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-04', 'nama' => 'Terapi Menelan (Dysphagia Training)', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-05', 'nama' => 'Latihan Pernapasan & Kontrol Vokal', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-06', 'nama' => 'Augmentative & Alternative Communication (AAC)', 'poli' => 'Terapi Wicara', 'harga' => 0],
            ['kode' => 'WIC-07', 'nama' => 'Melodic Intonation Therapy', 'poli' => 'Terapi Wicara', 'harga' => 0],

            // 4. Terapi Netra (Orientasi & Mobilitas) (NET-01 s/d NET-05)
            ['kode' => 'NET-01', 'nama' => 'Latihan Penggunaan Tongkat Putih (White Cane)', 'poli' => 'Terapi Netra (Orientasi & Mobilitas)', 'harga' => 0],
            ['kode' => 'NET-02', 'nama' => 'Pengenalan Landmark & Orientasi Lingkungan', 'poli' => 'Terapi Netra (Orientasi & Mobilitas)', 'harga' => 0],
            ['kode' => 'NET-03', 'nama' => 'Pengembangan Sensasi Taktil & Pendengaran', 'poli' => 'Terapi Netra (Orientasi & Mobilitas)', 'harga' => 0],
            ['kode' => 'NET-04', 'nama' => 'Latihan Kemandirian ADL Non-Visual', 'poli' => 'Terapi Netra (Orientasi & Mobilitas)', 'harga' => 0],
            ['kode' => 'NET-05', 'nama' => 'Pengenalan Huruf Braille & Reglet Dasar', 'poli' => 'Terapi Netra (Orientasi & Mobilitas)', 'harga' => 0],
        ];

        foreach ($tindakans as $t) {
            Tindakan::updateOrCreate(
                ['kode' => $t['kode']],
                $t
            );
        }
    }
}
