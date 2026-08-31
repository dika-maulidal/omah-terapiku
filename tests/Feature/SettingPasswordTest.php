<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingPasswordTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Tamu / Unauthenticated user harus diarahkan ke halaman login.
     */
    public function test_guest_cannot_access_setting_page()
    {
        $response = $this->get('/setting');
        $response->assertRedirect('/');
    }

    /**
     * User yang login dapat mengakses halaman setting.
     */
    public function test_authenticated_user_can_access_setting_page()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'nip' => 'TEST001',
                'phone' => '081299998888',
                'password' => Hash::make('password123'),
                'role' => 1,
                'status' => 1
            ]);
        }

        $response = $this->actingAs($user)->get('/setting');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Akun');
        $response->assertSee('Ganti Password');
    }

    /**
     * Ganti password gagal jika password saat ini salah.
     */
    public function test_update_password_fails_if_current_password_is_incorrect()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'nip' => 'TEST001',
                'phone' => '081299998888',
                'password' => Hash::make('password123'),
                'role' => 1,
                'status' => 1
            ]);
        } else {
            $user->password = Hash::make('password123');
            $user->save();
        }

        $response = $this->actingAs($user)->post('/setting/password', [
            'current_password' => 'passwordsalah',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
    }

    /**
     * Ganti password gagal jika konfirmasi password tidak sama.
     */
    public function test_update_password_fails_if_confirmation_does_not_match()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'nip' => 'TEST001',
                'phone' => '081299998888',
                'password' => Hash::make('password123'),
                'role' => 1,
                'status' => 1
            ]);
        } else {
            $user->password = Hash::make('password123');
            $user->save();
        }

        $response = $this->actingAs($user)->post('/setting/password', [
            'current_password' => 'password123',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbedalagi',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
    }

    /**
     * Ganti password berhasil jika password saat ini benar dan konfirmasi sama dua kali.
     */
    public function test_update_password_succeeds_with_valid_data()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'nip' => 'TEST001',
                'phone' => '081299998888',
                'password' => Hash::make('password123'),
                'role' => 1,
                'status' => 1
            ]);
        } else {
            $user->password = Hash::make('password123');
            $user->save();
        }

        $response = $this->actingAs($user)->post('/setting/password', [
            'current_password' => 'password123',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);

        $response->assertRedirect(route('setting.index'));
        $response->assertSessionHas('sukses');
        $this->assertTrue(Hash::check('passwordbaru123', $user->fresh()->password));
    }
}
