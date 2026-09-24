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
        $terapis = ($user->role == 3 || $user->role_display() == 'Dokter') 
            ? ($user->terapis ?: \App\Models\Dokter::where('user_id', $user->id)->first()) 
            : null;
            
        return view('setting.index', compact('user', 'terapis'));
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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:25|unique:users,phone,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'phone.unique' => 'Nomor telepon sudah digunakan oleh akun lain.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
        ];

        if ($user->role == 3 || $user->role_display() == 'Dokter') {
            $rules['no_str'] = 'nullable|string|max:100';
            $rules['masa_berlaku_str'] = 'nullable|string|max:100';
            $rules['file_str'] = 'nullable|mimes:pdf,jpg,jpeg,png|max:5120';

            $messages['file_str.mimes'] = 'Format file scan STR harus berupa PDF, JPG, JPEG, atau PNG.';
            $messages['file_str.max'] = 'Ukuran file scan STR maksimal 5MB.';
        }

        $request->validate($rules, $messages);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('nip')) {
            $user->nip = $request->nip;
        }
        $user->save();

        // Jika user adalah Terapis, update data profil terapis & STR terkait
        $terapis = \App\Models\Dokter::where('user_id', $user->id)->first();
        if ($terapis) {
            $terapis->nama = $user->name;
            if ($user->phone) {
                $terapis->no_hp = $user->phone;
            }
            if ($request->has('no_str')) {
                $terapis->no_str = $request->no_str;
            }
            if ($request->has('masa_berlaku_str')) {
                $terapis->masa_berlaku_str = $request->masa_berlaku_str;
            }

            if ($request->hasFile('file_str')) {
                $file = $request->file('file_str');
                $ext = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $user->name);
                $fileNameStr = 'STR_' . $cleanName . '_' . time() . '.' . $ext;
                $targetDir = public_path('images/terapis/str');
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Hapus file lama jika ada
                if ($terapis->file_str && file_exists(public_path('images/terapis/str/' . $terapis->file_str))) {
                    @unlink(public_path('images/terapis/str/' . $terapis->file_str));
                }

                $file->move($targetDir, $fileNameStr);
                $terapis->file_str = $fileNameStr;
            }

            $terapis->save();
        }

        return redirect()->route('setting.index')->with('sukses', 'Informasi profil berhasil diperbarui!');
    }
}

