<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Super Admin
        User::updateOrCreate(
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

        // 2. Akun Petugas Registrasi / Pendaftaran
        User::updateOrCreate(
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

        // 3. Terapis 1 - UPT PPSAB Sidoarjo (Fisioterapi ABK)
        $terapis1User = User::updateOrCreate(
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
        Dokter::updateOrCreate(
            ['user_id' => $terapis1User->id],
            [
                'nama' => 'Budi Hartanto, S.Tr.Kes',
                'no_hp' => '085123456781',
                'alamat' => 'Sidoarjo',
                'poli' => 'UPT PPSAB Sidoarjo',
                'status' => 1,
            ]
        );

        // 4. Terapis 2 - Balai PRS PMKS Sidoarjo (Terapi Okupasi)
        $terapis2User = User::updateOrCreate(
            ['email' => 'terapis.pmks@rekammedis.local'],
            [
                'name' => 'Siti Rahmawati, A.Md.OT',
                'nip' => '199301012026011004',
                'phone' => '085123456782',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        Dokter::updateOrCreate(
            ['user_id' => $terapis2User->id],
            [
                'nama' => 'Siti Rahmawati, A.Md.OT',
                'no_hp' => '085123456782',
                'alamat' => 'Sidoarjo',
                'poli' => 'Balai PRS PMKS Sidoarjo',
                'status' => 1,
            ]
        );

        // 5. Terapis 3 - UPT RSBN Malang (Terapi Netra / O&M)
        $terapis3User = User::updateOrCreate(
            ['email' => 'terapis.rsbn@rekammedis.local'],
            [
                'name' => 'Dadar Putra, S.Pd',
                'nip' => '199401012026011005',
                'phone' => '085123456783',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );
        Dokter::updateOrCreate(
            ['user_id' => $terapis3User->id],
            [
                'nama' => 'Dadar Putra, S.Pd',
                'no_hp' => '085123456783',
                'alamat' => 'Malang',
                'poli' => 'UPT RSBN Malang',
                'status' => 1,
            ]
        );
    }
}