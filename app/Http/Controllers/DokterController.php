<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Rekam;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::with('user');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('no_hp', 'like', "%{$keyword}%")
                  ->orWhere('poli', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('nip', 'like', "%{$keyword}%");
                  });
            });
        }

        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $datas = $query->orderBy('id', 'desc')->paginate(10);
        $poli = Poli::all();
        return view('terapis.index', compact('datas', 'poli'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'poli' => 'required',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'password' => 'required|min:4'
        ], [
            'nama.required' => 'Nama terapis wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'poli.required' => 'Omah Terapiku wajib dipilih.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karakter.'
        ]);

        DB::beginTransaction();
        try {
            // Generate email dummy / username jika tabel users mewajibkannya
            $email = $request->filled('email') 
                ? $request->email 
                : ($request->filled('nip') 
                    ? $request->nip . '@klinik.com' 
                    : ($request->filled('no_hp') 
                        ? $request->no_hp . '@klinik.com' 
                        : 'terapis_' . time() . '_' . rand(100, 999) . '@klinik.com'));

            if ($email && User::where('email', $email)->exists()) {
                $email = 'terapis_' . time() . '_' . rand(100, 999) . '@klinik.com';
            }

            $user = User::create([
                'name' => $request->nama,
                'nip' => $request->nip ?: null,
                'email' => $email,
                'phone' => $request->no_hp,
                'password' => bcrypt($request->password),
                'role' => 3,
                'status' => 1
            ]);

            $request->merge([
                'user_id' => $user->id,
                'status' => 1
            ]);

            Dokter::create($request->all());

            DB::commit();
            return redirect()->route('dokter')->with('sukses', 'Data terapis berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            // Menampilkan pesan error asli agar mudah dilacak jika masih gagal
            return redirect()->route('dokter')->with('gagal', 'Data gagal ditambahkan: ' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'poli' => 'required',
            'nip' => 'nullable|unique:users,nip,' . optional(Dokter::find($id))->user_id
        ]);

        DB::beginTransaction();
        try {
            $dokter = Dokter::findOrFail($id);
            $dokter->update($request->all());

            $user = User::findOrFail($dokter->user_id);
            $userData = [
                'name' => $request->nama,
                'phone' => $request->no_hp,
                'nip' => $request->nip
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }

            $user->update($userData);

            DB::commit();
            return redirect()->route('dokter')->with('sukses', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokter')->with('gagal', 'Data gagal diperbaharui: ' . $th->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        $rekam = Rekam::where('dokter_id', $id)->count();
        if ($rekam >= 1) {
            $dokter = Dokter::find($id);
            $dokter->update([
                'status' => 0
            ]);
            User::find($dokter->user_id)->update([
                'status' => 0
            ]);   
            return redirect()->route('dokter')->with('sukses', 'Data dokter di non aktifkan');
        } else {
            $dokter = Dokter::find($id);
            $dokter->delete();
            User::find($dokter->user_id)->delete();    
        }
        return redirect()->route('dokter')->with('sukses', 'Data berhasil dihapus');
    }    

    public function getDokter(Request $request)
    {
        $data = Dokter::select('id', 'nama')->where('status', 1)->get();
        if ($poli = $request->get('poli')) {
            $data = Dokter::select('id', 'nama')
                        ->where('status', 1)
                        ->where('poli', $poli)
                        ->get();
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function updatepassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'password_konfirm' => 'required_with:password|same:password|min:6'
        ]);
      
        $password = bcrypt($request->password);
        User::where('id', $id)->update([
            'password' => $password,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        return redirect()->route('dokter')->with('sukses', 'Selamat, password anda sudah diperbaharui');
    }
}