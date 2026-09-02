<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Dokter;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index(Request $request)
    {
        $datas = Poli::with('terapis')
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where('nama', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alamat', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('fokus_layanan', 'LIKE', "%{$request->keyword}%");
                })
                ->paginate(10);

        $allTerapis = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();

        return view('omahterapiku.index', compact('datas', 'allTerapis'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama',
            'alamat' => 'nullable|string',
            'fokus_layanan' => 'nullable|string',
            'status' => 'nullable|integer',
        ]);
        
        $poli = Poli::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'fokus_layanan' => $request->fokus_layanan,
            'status' => $request->status ?? 1,
        ]);

        if ($request->has('terapis_ids') && is_array($request->terapis_ids)) {
            Dokter::whereIn('id', $request->terapis_ids)->update(['poli' => $poli->nama]);
        }

        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku (UPT) berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama,' . $id,
            'alamat' => 'nullable|string',
            'fokus_layanan' => 'nullable|string',
            'status' => 'nullable|integer',
        ]);
        
        $poli = Poli::findOrFail($id);
        $oldNama = $poli->nama;
        $newNama = $request->nama;

        $poli->update([
            'nama' => $newNama,
            'alamat' => $request->alamat,
            'fokus_layanan' => $request->fokus_layanan,
            'status' => $request->status ?? 1,
        ]);

        // Jika nama UPT berubah, sinkronkan nama poli di tabel terapis yang lama
        if ($oldNama !== $newNama) {
            Dokter::where('poli', $oldNama)->update(['poli' => $newNama]);
        }

        // Kelola penugasan terapis yang dipilih
        $selectedTerapis = $request->terapis_ids ?: [];
        if (is_array($selectedTerapis)) {
            // Assign terapis terpilih ke UPT ini
            if (count($selectedTerapis) > 0) {
                Dokter::whereIn('id', $selectedTerapis)->update(['poli' => $newNama]);
            }
            // Lepaskan penugasan terapis yang uncheck di UPT ini
            Dokter::where('poli', $newNama)->whereNotIn('id', $selectedTerapis)->update(['poli' => null]);
        }

        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku (UPT) berhasil diperbaharui');
    }

    public function delete(Request $request, $id)
    {
        $poli = Poli::findOrFail($id);
        Dokter::where('poli', $poli->nama)->update(['poli' => null]);
        $poli->delete();
        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku (UPT) berhasil dihapus');
    }    
}
