<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Dokter;
use Illuminate\Http\Request;

class PoliController extends Controller
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

        $datas = Poli::with('terapis')
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->filled('fokus'), function ($query) use ($request) {
                    $query->where('fokus_layanan', 'LIKE', "%{$request->fokus}%");
                })
                ->when($request->filled('keyword'), function ($query) use ($request) {
                    $keyword = $request->keyword;
                    $query->where(function($q) use ($keyword) {
                        $q->where('nama', 'LIKE', "%{$keyword}%")
                          ->orWhere('alamat', 'LIKE', "%{$keyword}%")
                          ->orWhere('no_telp', 'LIKE', "%{$keyword}%")
                          ->orWhere('fokus_layanan', 'LIKE', "%{$keyword}%");
                    });
                })
                ->paginate($perPage);

        $allTerapis = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();

        if ($request->ajax()) {
            $hasFilters = ($request->filled('keyword') || $request->filled('status') || $request->filled('fokus') || ($request->filled('per_page') && $request->per_page != '10'));

            return response()->json([
                'html' => view('omahterapiku.partial.table', compact('datas', 'allTerapis'))->render(),
                'total' => $datas->total(),
                'first_item' => $datas->firstItem() ?: 0,
                'last_item' => $datas->lastItem() ?: 0,
                'has_filters' => $hasFilters,
            ]);
        }

        return view('omahterapiku.index', compact('datas', 'allTerapis'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:50',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'fokus_layanan' => 'nullable|string',
            'status' => 'nullable|integer',
        ]);
        
        $poli = Poli::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'latitude' => $request->latitude ? trim($request->latitude) : null,
            'longitude' => $request->longitude ? trim($request->longitude) : null,
            'fokus_layanan' => $request->fokus_layanan,
            'status' => $request->status ?? 1,
        ]);

        if ($request->has('terapis_ids') && is_array($request->terapis_ids)) {
            // Hanya assign terapis yang belum bertugas di UPT manapun
            Dokter::whereIn('id', $request->terapis_ids)
                ->where(function ($q) {
                    $q->whereNull('poli')->orWhere('poli', '');
                })
                ->update(['poli' => $poli->nama]);
        }

        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku (UPT) berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama,' . $id,
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:50',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'fokus_layanan' => 'nullable|string',
            'status' => 'nullable|integer',
        ]);
        
        $poli = Poli::findOrFail($id);
        $oldNama = $poli->nama;
        $newNama = $request->nama;

        $poli->update([
            'nama' => $newNama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'latitude' => $request->latitude ? trim($request->latitude) : null,
            'longitude' => $request->longitude ? trim($request->longitude) : null,
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
            // Assign terapis terpilih yang masih kosong atau memang sudah berada di UPT ini
            if (count($selectedTerapis) > 0) {
                Dokter::whereIn('id', $selectedTerapis)
                    ->where(function ($q) use ($oldNama, $newNama) {
                        $q->whereNull('poli')
                          ->orWhere('poli', '')
                          ->orWhere('poli', $oldNama)
                          ->orWhere('poli', $newNama);
                    })
                    ->update(['poli' => $newNama]);
            }
            // Lepaskan penugasan terapis yang di-uncheck dari UPT ini
            Dokter::where(function ($q) use ($oldNama, $newNama) {
                $q->where('poli', $newNama)->orWhere('poli', $oldNama);
            })->whereNotIn('id', $selectedTerapis)->update(['poli' => null]);
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
