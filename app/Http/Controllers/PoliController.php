<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index(Request $request)
    {
        $datas = Poli::all();
        return view('poli.index',compact('datas'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required|unique:poli',
            'alamat' => 'nullable|string',
        ]);
        Poli::create($request->all());
        return redirect()->route('omahterapiku')->with('sukses','Data berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'nama' => 'required',
            'alamat' => 'nullable|string',
        ]);
        $data = Poli::find($id);
        $data->update($request->all());
        return redirect()->route('omahterapiku')->with('sukses','Data berhasil diperbaharui');
    }

    public function delete(Request $request,$id)
    {
        Poli::find($id)->delete();
        return redirect()->route('omahterapiku')->with('sukses','Data berhasil dihapus');
    }    
}
