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
                        $kategori = $data->kategori_usia;
                        $button = '<a href="javascript:void(0)" 
                            data-id="'.$data->id.'"
                            data-nama="'.$data->nama.'"
                            data-no="'.$data->no_rm.'"
                            data-metode="'.$data->cara_bayar.'"
                            data-nohp="'.($data->no_hp ?? '').'"
                            data-tgllahir="'.($data->tgl_lahir ?? '').'"
                            data-kategori="'.$kategori.'"
                            data-namawali="'.($data->nama_wali ?? '').'"
                            data-hubunganwali="'.($data->hubungan_wali ?? '').'"
                            data-disabilitas="'.($data->jenis_disabilitas ?? '').'"
                            data-alatbantu="'.($data->alat_bantu ?? '').'"
                            data-desil="'.($data->desil ?? '').'"
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
            $kategori = $data->kategori_usia;
            $button = '<a href="javascript:void(0)" 
                data-id="'.$data->id.'"
                data-nama="'.$data->nama.'"
                data-no="'.$data->no_rm.'"
                data-metode="'.$data->cara_bayar.'"
                data-nohp="'.($data->no_hp ?? '').'"
                data-tgllahir="'.($data->tgl_lahir ?? '').'"
                data-kategori="'.$kategori.'"
                data-namawali="'.($data->nama_wali ?? '').'"
                data-hubunganwali="'.($data->hubungan_wali ?? '').'"
                data-disabilitas="'.($data->jenis_disabilitas ?? '').'"
                data-alatbantu="'.($data->alat_bantu ?? '').'"
                data-desil="'.($data->desil ?? '').'"
                class="btn btn-primary shadow btn-xs pilihPasien">
                Pilih</a>';
            return $button;
        })->rawColumns(['action'])->toJson();
    }

    public function index(Request $request)
    {
        $datas = Pasien::whereNull('deleted_at')
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('no_rm', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nama', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nik', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('desil', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nama_wali', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('jenis_disabilitas', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alat_bantu', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('no_bpjs', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('no_hp', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alamat_lengkap', 'LIKE', "%{$request->keyword}%");
                    });
                })
                ->when($request->status, function ($query) use ($request) {
                    $status = $request->status;
                    $lastData = Carbon::createFromFormat('Y-m-d H:i:s', '2023-05-22 18:00:00');
                    if ($status === 'sudah_periksa') {
                        $query->whereHas('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        });
                    } elseif ($status === 'pasien_baru') {
                        $query->whereDoesntHave('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        })->where('created_at', '>', $lastData);
                    } elseif ($status === 'pasien_lama') {
                        $query->whereDoesntHave('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        })->where('created_at', '<=', $lastData);
                    }
                })
                ->orderBy('id', 'desc')
                ->paginate(10);

        return view('pasien.index', compact('datas'));
    }

    public function exportCsv(Request $request)
    {
        $datas = Pasien::whereNull('deleted_at')
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('no_rm', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nama', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nik', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('desil', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('nama_wali', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('jenis_disabilitas', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alat_bantu', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('no_bpjs', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('no_hp', 'LIKE', "%{$request->keyword}%")
                          ->orWhere('alamat_lengkap', 'LIKE', "%{$request->keyword}%");
                    });
                })
                ->when($request->status, function ($query) use ($request) {
                    $status = $request->status;
                    $lastData = Carbon::createFromFormat('Y-m-d H:i:s', '2023-05-22 18:00:00');
                    if ($status === 'sudah_periksa') {
                        $query->whereHas('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        });
                    } elseif ($status === 'pasien_baru') {
                        $query->whereDoesntHave('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        })->where('created_at', '>', $lastData);
                    } elseif ($status === 'pasien_lama') {
                        $query->whereDoesntHave('rekams', function ($q) {
                            $q->whereIn('status', [4, 5]);
                        })->where('created_at', '<=', $lastData);
                    }
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
            'Nama Wali / Orang Tua',
            'Hubungan dengan Pasien',
            'Jenis Disabilitas',
            'Alat Bantu Mobilitas',
            'Kewarganegaraan',
            'No. HP',
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
                    $row->nama_wali ?? '-',
                    $row->hubungan_wali ?? '-',
                    $row->jenis_disabilitas ?? '-',
                    $row->alat_bantu ?? '-',
                    $row->kewarganegaraan ?? 'WNI',
                    $row->no_hp ? "'" . $row->no_hp : '-',
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
        $autoNoRm = Pasien::generateNoRM();
        return view('pasien.add', compact('autoNoRm'));
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
            'no_bpjs' => 'nullable|unique:pasien',
            'nik' => 'nullable|unique:pasien,nik',
            'desil' => 'nullable|string|max:50',
            'nama_wali' => 'nullable|string|max:191',
            'hubungan_wali' => 'nullable|string|max:100',
            'jenis_disabilitas' => 'nullable|string|max:100',
            'alat_bantu' => 'nullable|string|max:100',
            'file_kk' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240'
        ]);

        $no_rm = $request->no_rm ?: Pasien::generateNoRM();

        $request->merge([
            'no_rm' => $no_rm,
            'cara_bayar' => 'Gratis',
            'kewarganegaraan' => $request->kewarganegaraan ?? 'WNI'
        ]);
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
            'nama_wali' => 'nullable|string|max:191',
            'hubungan_wali' => 'nullable|string|max:100',
            'jenis_disabilitas' => 'nullable|string|max:100',
            'alat_bantu' => 'nullable|string|max:100',
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
        $no_rm_baru = Pasien::generateNoRM();
        return response()->json([
            'success' => true,
            'data' => $no_rm_baru
        ], 200);
    }
}