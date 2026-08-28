<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index(Request $request)
    {
        $datas = Poli::when($request->keyword, function ($query) use ($request) {
                    $query->where('nama', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alamat', 'LIKE', "%{$request->keyword}%");
                })
                ->paginate(10);

        return view('omahterapiku.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama',
            'alamat' => 'nullable|string',
        ]);
        
        $data = $request->all();
        if (!isset($data['status'])) {
            $data['status'] = 1;
        }
        
        Poli::create($data);
        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|unique:omahterapiku,nama,' . $id,
            'alamat' => 'nullable|string',
        ]);
        
        $data = Poli::find($id);
        $data->update($request->all());
        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku berhasil diperbaharui');
    }

    public function delete(Request $request, $id)
    {
        Poli::find($id)->delete();
        return redirect()->route('omahterapiku')->with('sukses', 'Data Omah Terapiku berhasil dihapus');
    }    
}
