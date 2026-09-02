<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index(Request $request)
    {
        $poli = Poli::all();
        $query = Tindakan::orderBy('kode', 'asc');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('kode', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }

        $datas = $query->paginate(10);

        $layananList = [
            'Fisioterapi',
            'Terapi Okupasi / Sensorik Integrasi',
            'Terapi Wicara',
            'Terapi Netra (Orientasi & Mobilitas)',
            'Umum / Semua Layanan'
        ];

        return view('tindakan.index', compact('datas', 'poli', 'layananList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode' => 'required|string|max:50|unique:tindakan,kode',
            'nama' => 'required|string|max:255',
            'poli' => 'required',
            'harga' => 'nullable|numeric'
        ], [
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.unique' => 'Kode tindakan sudah digunakan.',
            'nama.required' => 'Nama tindakan wajib diisi.',
            'poli.required' => 'Omah Terapiku wajib dipilih.'
        ]);

        $data = $request->all();
        $data['harga'] = $request->filled('harga') ? $request->harga : 0;

        Tindakan::create($data);
        return redirect()->route('tindakan')->with('sukses', 'Data tindakan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kode' => 'required|string|max:50|unique:tindakan,kode,' . $id,
            'nama' => 'required|string|max:255',
            'poli' => 'required',
            'harga' => 'nullable|numeric'
        ], [
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.unique' => 'Kode tindakan sudah digunakan.',
            'nama.required' => 'Nama tindakan wajib diisi.',
            'poli.required' => 'Omah Terapiku wajib dipilih.'
        ]);

        $tindakan = Tindakan::findOrFail($id);
        $data = $request->all();
        $data['harga'] = $request->filled('harga') ? $request->harga : 0;

        $tindakan->update($data);
        return redirect()->route('tindakan')->with('sukses', 'Data tindakan berhasil diperbaharui');
    }

    public function delete(Request $request, $id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();
        return redirect()->route('tindakan')->with('sukses', 'Data tindakan berhasil dihapus');
    }    
}

