<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 3);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('nip', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $datas = $query->orderBy('id', 'desc')->paginate(10);
        return view('petugas.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'phone' => 'nullable|string|max:30|unique:users,phone',
            'password' => 'required|min:4',
            'role' => 'required|in:1,2'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
            'phone.unique' => 'Nomor HP sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karakter.',
            'role.required' => 'Role akses wajib dipilih.'
        ]);

        DB::beginTransaction();
        try {
            // Generate email fallback jika tidak diisi agar aman
            $email = $request->filled('email')
                ? $request->email
                : ($request->filled('nip')
                    ? $request->nip . '@omah-terapiku.local'
                    : ($request->filled('phone')
                        ? $request->phone . '@omah-terapiku.local'
                        : 'petugas_' . time() . '_' . rand(100, 999) . '@omah-terapiku.local'));

            if ($email && User::where('email', $email)->exists()) {
                $email = 'petugas_' . time() . '_' . rand(100, 999) . '@omah-terapiku.local';
            }

            $user = User::create([
                'name' => $request->name,
                'nip' => $request->nip ?: null,
                'email' => $email,
                'phone' => $request->phone ?: null,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'status' => 1
            ]);
            
            DB::commit();
            return redirect()->route('petugas')->with('sukses', 'Data petugas (' . $user->role_display() . ') berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('petugas')->with('gagal', 'Data gagal ditambahkan: ' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $id,
            'phone' => 'nullable|string|max:30|unique:users,phone,' . $id,
            'role' => 'required|in:1,2'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
            'phone.unique' => 'Nomor HP sudah digunakan oleh akun lain.',
            'role.required' => 'Role akses wajib dipilih.'
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $updateData = [
                'name' => $request->name,
                'nip' => $request->nip ?: null,
                'phone' => $request->phone ?: null,
                'role' => $request->role,
                'status' => 1
            ];

            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);
            
            DB::commit();
            return redirect()->route('petugas')->with('sukses', 'Data petugas berhasil diperbaharui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('petugas')->with('gagal', 'Data gagal diperbaharui: ' . $th->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('petugas')->with('gagal', 'Tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('petugas')->with('sukses', 'Data petugas berhasil dihapus');
    }    
}

