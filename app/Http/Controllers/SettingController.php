<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman Pengaturan Akun & Ubah Password
     */
    public function index()
    {
        $user = Auth::user();
        return view('setting.index', compact('user'));
    }

    /**
     * Memperbarui Password Pengguna
     * Memeriksa password saat ini dan konfirmasi password baru (dimasukkan dua kali)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Verifikasi kesesuaian password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.'])
                ->with('gagal', 'Password saat ini salah!');
        }

        // Cek agar password baru tidak sama persis dengan password lama
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password baru tidak boleh sama dengan password saat ini.'])
                ->with('gagal', 'Password baru tidak boleh sama dengan password saat ini!');
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('setting.index')->with('sukses', 'Selamat, password Anda berhasil diperbarui!');
    }

    /**
     * Memperbarui Informasi Profil Pengguna
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:25|unique:users,phone,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'phone.unique' => 'Nomor telepon sudah digunakan oleh akun lain.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('nip')) {
            $user->nip = $request->nip;
        }
        $user->save();

        return redirect()->route('setting.index')->with('sukses', 'Informasi profil berhasil diperbarui!');
    }
}
