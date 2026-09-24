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
        $perPageInput = $request->input('per_page', 10);
        if ($perPageInput === 'all') {
            $perPage = 1000;
        } else {
            $perPage = (int) $perPageInput;
            if ($perPage <= 0) {
                $perPage = 10;
            }
        }

        $query = Dokter::with('user');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('no_hp', 'like', "%{$keyword}%")
                  ->orWhere('poli', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%")
                  ->orWhere('no_str', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('nip', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%");
                  });
            });
        }

        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $datas = $query->orderBy('id', 'desc')->paginate($perPage);
        $poli = Poli::all();

        if ($request->ajax()) {
            $hasFilters = ($request->filled('keyword') || $request->filled('poli') || ($request->filled('status') && $request->status !== '') || ($request->filled('per_page') && $request->per_page != '10'));

            return response()->json([
                'html' => view('terapis.partial.table', compact('datas', 'poli'))->render(),
                'total' => $datas->total(),
                'first_item' => $datas->firstItem() ?: 0,
                'last_item' => $datas->lastItem() ?: 0,
                'has_filters' => $hasFilters,
            ]);
        }

        return view('terapis.index', compact('datas', 'poli'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'poli' => 'required',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'no_str' => 'nullable|string|max:100',
            'masa_berlaku_str' => 'nullable|string|max:100',
            'file_str' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'password' => 'required|min:4'
        ], [
            'nama.required' => 'Nama terapis wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'poli.required' => 'Omah Terapiku wajib dipilih.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
            'file_str.mimes' => 'Format file scan STR harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_str.max' => 'Ukuran file scan STR maksimal 5MB.',
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

            $fileNameStr = null;
            if ($request->hasFile('file_str')) {
                $file = $request->file('file_str');
                $ext = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $request->nama);
                $fileNameStr = 'STR_' . $cleanName . '_' . time() . '.' . $ext;
                $targetDir = public_path('images/terapis/str');
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $file->move($targetDir, $fileNameStr);
            }

            $dokterData = $request->except(['file_str']);
            $dokterData['user_id'] = $user->id;
            $dokterData['status'] = 1;
            $dokterData['file_str'] = $fileNameStr;

            Dokter::create($dokterData);

            DB::commit();
            return redirect()->route('dokter')->with('sukses', 'Data terapis berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dokter')->with('gagal', 'Data gagal ditambahkan: ' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'poli' => 'required',
            'nip' => 'nullable|unique:users,nip,' . optional(Dokter::find($id))->user_id,
            'no_str' => 'nullable|string|max:100',
            'masa_berlaku_str' => 'nullable|string|max:100',
            'file_str' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120'
        ], [
            'nama.required' => 'Nama terapis wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'poli.required' => 'Omah Terapiku wajib dipilih.',
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
            'file_str.mimes' => 'Format file scan STR harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_str.max' => 'Ukuran file scan STR maksimal 5MB.'
        ]);

        DB::beginTransaction();
        try {
            $dokter = Dokter::findOrFail($id);
            $dokterData = $request->except(['file_str']);

            if ($request->hasFile('file_str')) {
                $file = $request->file('file_str');
                $ext = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $request->nama);
                $fileNameStr = 'STR_' . $cleanName . '_' . time() . '.' . $ext;
                $targetDir = public_path('images/terapis/str');
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Hapus file lama jika ada
                if ($dokter->file_str && file_exists(public_path('images/terapis/str/' . $dokter->file_str))) {
                    @unlink(public_path('images/terapis/str/' . $dokter->file_str));
                }

                $file->move($targetDir, $fileNameStr);
                $dokterData['file_str'] = $fileNameStr;
            }

            $dokter->update($dokterData);

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
            return redirect()->route('dokter')->with('sukses', 'Data terapis berhasil diperbaharui');
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