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
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@rekammedis.local'],
            [
                'name' => 'Administrator',
                'nip' => '199001012026011001',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 1,
                'status' => 1,
            ]
        );

        // 2. Petugas Registrasi
        User::updateOrCreate(
            ['email' => 'registrasi@rekammedis.local'],
            [
                'name' => 'Petugas Registrasi',
                'nip' => '199101012026011002',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role' => 2,
                'status' => 1,
            ]
        );

        // 3. Dokter (User + Profile Dokter)
        $dokterUser = User::updateOrCreate(
            ['email' => 'dokter@rekammedis.local'],
            [
                'name' => 'Dokter',
                'nip' => '199201012026011003',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
            ]
        );

        // Otomatis menautkan profil Dokter dengan user_id milik akun Dokter di atas (TANPA kolom nip)
        Dokter::updateOrCreate(
            ['user_id' => $dokterUser->id],
            [
                'nama' => 'dr. Omah Terapiku',
                'no_hp' => '081234567892',
                'alamat' => 'Surabaya',
                'poli' => 'Poli Umum',
                'status' => 1,
            ]
        );
    }
}