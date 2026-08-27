<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
// use Image;
use App\Models\Rekam;
use App\Models\RekamGigi;

class PasienController extends Controller
{
    public function json(Request $request)
    {
        // return DataTables::of(Icd::query())->toJson();
        if ($request->ajax()) {
            return DataTables::of(Pasien::query())
                    ->editColumn('cara_bayar', function () {
                        return 'Gratis, tidak dipungut biaya';
                    })
                    ->addColumn('action',function($data){
                        $button = '<a href="javascript:void(0)" 
                            data-id="'.$data->id.'"
                            data-nama="'.$data->nama.'"
                            data-no="'.$data->no_rm.'"
                            data-metode="'.$data->cara_bayar.'"
                            class="btn btn-primary shadow btn-xs pilihPasien">
                            Pilih</a>';
                        return $button;
                    })->rawColumns(['action'])
                    ->toJson();
        }
        return DataTables::of(Pasien::query())
        ->editColumn('cara_bayar', function () {
            return 'Gratis, tidak dipungut biaya';
        })
        ->addColumn('action',function($data){
            $button = '<a href="javascript:void(0)" 
                data-id="'.$data->id.'"
                data-nama="'.$data->nama.'"
                data-no="'.$data->no_rm.'"
                data-metode="'.$data->cara_bayar.'"
                class="btn btn-primary shadow btn-xs pilihPasien">
                Pilih</a>';
            return $button;
        })->rawColumns(['action'])->toJson();
    }

    public function index(Request $request)
    {
        $datas = Pasien::whereNull('deleted_at')
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where('no_rm', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('nama', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('nik', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('desil', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('no_bpjs', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('no_hp', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('alamat_lengkap', 'LIKE', "%{$request->keyword}%");
                })->paginate(10);
        return view('pasien.index', compact('datas'));
    }

    public function exportCsv(Request $request)
    {
        $datas = Pasien::whereNull('deleted_at')
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where('no_rm', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('nama', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('nik', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('desil', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('no_bpjs', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('no_hp', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('alamat_lengkap', 'LIKE', "%{$request->keyword}%");
                })
                ->orderBy('id', 'asc')
                ->get();

        $filename = 'data-penerima-manfaat-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'No',
            'No. RM',
            'NIK',
            'Nama Penerima Manfaat',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat Lengkap',
            'Kelurahan',
            'Kecamatan',
            'Kabupaten',
            'Kode Pos',
            'Agama',
            'Status Menikah',
            'Pendidikan',
            'Pekerjaan',
            'Desil',
            'Kewarganegaraan',
            'No. HP',
            'Status Layanan',
            'No. BPJS/KTP',
            'Alergi',
            'Status Pemeriksaan',
            'Tanggal Terdaftar',
        ];

        $callback = function () use ($datas, $columns) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, $columns);

            $index = 1;
            foreach ($datas as $row) {
                fputcsv($file, [
                    $index++,
                    $row->no_rm ?? '-',
                    $row->nik ? "'" . $row->nik : '-',
                    $row->nama ?? '-',
                    $row->tmp_lahir ?? '-',
                    $row->tgl_lahir ? Carbon::parse($row->tgl_lahir)->format('d/m/Y') : '-',
                    $row->jk ?? '-',
                    $row->alamat_lengkap ?? '-',
                    $row->kelurahan ?? '-',
                    $row->kecamatan ?? '-',
                    $row->kabupaten ?? '-',
                    $row->kodepos ?? '-',
                    $row->agama ?? '-',
                    $row->status_menikah ?? '-',
                    $row->pendidikan ?? '-',
                    $row->pekerjaan ?? '-',
                    $row->desil ?? '-',
                    $row->kewarganegaraan ?? 'WNI',
                    $row->no_hp ? "'" . $row->no_hp : '-',
                    'Gratis, tidak dipungut biaya',
                    $row->no_bpjs ? "'" . $row->no_bpjs : '-',
                    $row->alergi ?? '-',
                    $row->status_pasien_text,
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    function add(Request $request){
        return view('pasien.add');
    }

    function edit(Request $request,$id){
        $data = Pasien::find($id);
        return view('pasien.edit',compact('data'));
    }

    function file(Request $request,$id){
        $data = Pasien::find($id);
        return view('pasien.file',compact('data'));
    }

    function store(Request $request){
        $this->validate($request,[
            'nama' => 'required',
            'no_hp' => 'required',
            'jk' => 'required',
            'no_rm' => 'required|unique:pasien',
            'no_bpjs' => 'nullable|unique:pasien',
            'nik' => 'nullable|unique:pasien,nik',
            'desil' => 'nullable|string|max:50',
            'file_kk' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240'
        ]);

        $request->merge(['cara_bayar' => 'Gratis']);
        $pasien = Pasien::create($request->all());

        if ($request->hasFile('file_kk')) {
            $extension = $request->file('file_kk')->getClientOriginalExtension();
            $fileNameKk = $pasien->no_rm.'_kk.'.$extension;
            $request->file('file_kk')->move(public_path('images/pasien/'), $fileNameKk);
            $pasien->file_kk = $fileNameKk;
        }

        if ($request->hasFile('file_resume')) {
            $extension = $request->file('file_resume')->getClientOriginalExtension();
            $fileNameResume = $pasien->no_rm.'_resume.'.$extension;
            $request->file('file_resume')->move(public_path('images/pasien/'), $fileNameResume);
            $pasien->file_resume = $fileNameResume;
        }

        $pasien->save();

        return redirect()->route('penerima-manfaat')->with('sukses','Data berhasil ditambahkan');
    }

    function update(Request $request,$id){
        $this->validate($request,[
            'nama' => 'required',
            'no_hp' => 'required',
            'jk' => 'required',
            'nik' => 'nullable|unique:pasien,nik,'.$id,
            'desil' => 'nullable|string|max:50',
            'file_kk' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240'
        ]);
        $data = Pasien::find($id);
        $request->merge(['cara_bayar' => 'Gratis']);
        $data->update($request->all());

        if ($request->hasFile('file_kk')) {
            $extension = $request->file('file_kk')->getClientOriginalExtension();
            $fileNameKk = $data->no_rm.'_kk.'.$extension;
            $request->file('file_kk')->move(public_path('images/pasien/'), $fileNameKk);
            $data->file_kk = $fileNameKk;
        }

        if ($request->hasFile('file_resume')) {
            $extension = $request->file('file_resume')->getClientOriginalExtension();
            $fileNameResume = $data->no_rm.'_resume.'.$extension;
            $request->file('file_resume')->move(public_path('images/pasien/'), $fileNameResume);
            $data->file_resume = $fileNameResume;
        }

        $data->save();

        return redirect()->route('penerima-manfaat')->with('sukses','Data berhasil diperbaharui');
    }

    function delete(Request $request,$id)
    {
        // Pasien::find($id)->update(['deleted_at'=>Carbon::now()]);
       $suk = Pasien::find($id)->delete();
       if($suk){
            Rekam::where('pasien_id',$id)->delete();
            RekamGigi::where('pasien_id',$id)->delete();
       }
        return redirect()->route('penerima-manfaat')->with('sukses','Data berhasil dihapus');
    } 

    function getLastRM(Request $request)
    {
        if ($code = $request->get('code')){
            $data = Pasien::orderBy('no_rm','desc')
                        ->where('no_rm','LIKE',"%{$code}%")
                        ->first();
            if ($data) {
                $last_no = substr($data->no_rm,2,3);
                $noLast = (int)$last_no;
                $newNo = $noLast+1;
                $nomorBaru = $newNo;
                if($newNo < 10){
                    $nomorBaru = "00".$newNo;
                }else if($newNo < 100){
                    $nomorBaru = "0".$newNo;
                }
                $no_rm_baru = $code.$nomorBaru;
                return response()->json([
                    'success' => true,
                    'data' => $no_rm_baru
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                ],400);
            }
        }
            
        return response()->json([ 'success' => false],400);
    }
}