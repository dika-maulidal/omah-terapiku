<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
// use Image;
use App\Models\Rekam;

class PasienController extends Controller
{
    public function json(Request $request)
    {
        return DataTables::of(Pasien::query()->whereNull('deleted_at'))
            ->editColumn('cara_bayar', function () {
                return 'Gratis, tidak dipungut biaya';
            })
            ->editColumn('no_rm', function($data) {
                return '<span class="badge font-w700" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;"><i class="fa-solid fa-id-card mr-1 text-primary"></i>'.$data->no_rm.'</span>';
            })
            ->editColumn('nama', function($data) {
                $disabilitas = $data->jenis_disabilitas && $data->jenis_disabilitas != 'Tidak Ada' ? $data->jenis_disabilitas : 'Non-Disabilitas';
                return '<div><strong class="text-dark font-w700" style="font-size: 13px;">'.htmlspecialchars($data->nama, ENT_QUOTES).'</strong><small class="text-muted d-block font-w500 mt-0.5" style="font-size: 11px;"><i class="fa-solid fa-venus-mars text-primary mr-1"></i>'.($data->jk ?: '-').' &bull; <i class="fa-solid fa-wheelchair text-primary mr-1"></i>'.$disabilitas.'</small></div>';
            })
            ->editColumn('tgl_lahir', function($data) {
                if (!$data->tgl_lahir) return '<span class="text-muted">-</span>';
                $usia = \Carbon\Carbon::parse($data->tgl_lahir)->age;
                return '<span style="font-size: 12px; font-weight: 600; color: #334155;">'.$data->tgl_lahir.'</span><small class="text-muted d-block" style="font-size: 11px;">('.$usia.' Thn &bull; '.$data->kategori_usia.')</small>';
            })
            ->editColumn('no_hp', function($data) {
                $hp = $data->no_hp ?: '-';
                $wali = $data->nama_wali ? '<small class="text-muted d-block" style="font-size: 11px;">Wali: '.htmlspecialchars($data->nama_wali, ENT_QUOTES).'</small>' : '';
                return '<span class="text-dark font-w600" style="font-size: 12px;">'.$hp.'</span>'.$wali;
            })
            ->editColumn('no_bpjs', function($data) {
                $nik = $data->nik ? '<small class="text-muted d-block" style="font-size: 11px;">NIK: '.$data->nik.'</small>' : '';
                return '<span class="text-dark font-w600" style="font-size: 12px;">'.($data->no_bpjs ?: '-').'</span>'.$nik;
            })
            ->addColumn('action', function($data) {
                $kategori = $data->kategori_usia;
                $button = '<button type="button" 
                    data-id="'.$data->id.'"
                    data-nama="'.htmlspecialchars($data->nama, ENT_QUOTES).'"
                    data-no="'.$data->no_rm.'"
                    data-metode="'.$data->cara_bayar.'"
                    data-nohp="'.($data->no_hp ?? '').'"
                    data-tgllahir="'.($data->tgl_lahir ?? '').'"
                    data-kategori="'.$kategori.'"
                    data-namawali="'.htmlspecialchars($data->nama_wali ?? '', ENT_QUOTES).'"
                    data-hubunganwali="'.htmlspecialchars($data->hubungan_wali ?? '', ENT_QUOTES).'"
                    data-disabilitas="'.htmlspecialchars($data->jenis_disabilitas ?? '', ENT_QUOTES).'"
                    data-alatbantu="'.htmlspecialchars($data->alat_bantu ?? '', ENT_QUOTES).'"
                    data-desil="'.htmlspecialchars($data->desil ?? '', ENT_QUOTES).'"
                    class="btn btn-primary btn-xs font-w700 shadow-sm pilihPasien"
                    style="padding: 5px 12px; font-size: 11.5px; border-radius: 6px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; white-space: nowrap;">
                    <i class="fa-solid fa-check mr-1"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action', 'no_rm', 'nama', 'tgl_lahir', 'no_hp', 'no_bpjs'])
            ->toJson();
    }

    public function index(Request $request)
    {
        $datas = Pasien::whereNull('deleted_at')
                ->when(session('selected_upt'), function ($query) {
                    $upt = session('selected_upt');
                    $query->where(function ($q) use ($upt) {
                        $q->where('upt_lokasi', 'LIKE', "%{$upt}%")
                          ->orWhereNull('upt_lokasi');
                    });
                })
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
                ->when($request->desil, function ($query) use ($request) {
                    $desil = $request->desil;
                    if ($desil === 'prioritas') {
                        $query->whereIn('desil', ['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4', 'Desil 5']);
                    } elseif ($desil === 'desil_6_10') {
                        $query->whereIn('desil', ['Desil 6', 'Desil 7', 'Desil 8', 'Desil 9', 'Desil 10']);
                    } elseif ($desil === 'non_desil') {
                        $query->where(function ($q) {
                            $q->where('desil', 'Non-Desil')
                              ->orWhere('desil', 'Non-DTSEN')
                              ->orWhere('desil', 'Tidak Terdaftar')
                              ->orWhereNull('desil')
                              ->orWhere('desil', '');
                        });
                    } else {
                        $query->where('desil', $desil);
                    }
                })
                ->when($request->jk, function ($query) use ($request) {
                    $query->where('jk', $request->jk);
                })
                ->when($request->disabilitas, function ($query) use ($request) {
                    $query->where('jenis_disabilitas', 'LIKE', "%{$request->disabilitas}%");
                });

        $perPageInput = $request->input('per_page', 10);
        if ($perPageInput === 'all') {
            $perPage = 1000;
        } else {
            $perPage = (int) $perPageInput;
            if ($perPage <= 0) {
                $perPage = 10;
            }
        }

        $datas = $datas->orderBy('id', 'desc')->paginate($perPage);

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
                ->when($request->desil, function ($query) use ($request) {
                    $desil = $request->desil;
                    if ($desil === 'prioritas') {
                        $query->whereIn('desil', ['Desil 1', 'Desil 2', 'Desil 3', 'Desil 4', 'Desil 5']);
                    } elseif ($desil === 'desil_6_10') {
                        $query->whereIn('desil', ['Desil 6', 'Desil 7', 'Desil 8', 'Desil 9', 'Desil 10']);
                    } elseif ($desil === 'non_desil') {
                        $query->where(function ($q) {
                            $q->where('desil', 'Non-Desil')
                              ->orWhere('desil', 'Non-DTSEN')
                              ->orWhere('desil', 'Tidak Terdaftar')
                              ->orWhereNull('desil')
                              ->orWhere('desil', '');
                        });
                    } else {
                        $query->where('desil', $desil);
                    }
                })
                ->when($request->jk, function ($query) use ($request) {
                    $query->where('jk', $request->jk);
                })
                ->when($request->disabilitas, function ($query) use ($request) {
                    $query->where('jenis_disabilitas', 'LIKE', "%{$request->disabilitas}%");
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
        $polis = Poli::where('status', 1)->get();
        return view('pasien.add', compact('autoNoRm', 'polis'));
    }

    function edit(Request $request,$id){
        $data = Pasien::findOrFail($id);
        $polis = Poli::where('status', 1)->get();
        return view('pasien.edit',compact('data', 'polis'));
    }

    function file(Request $request,$id){
        $data = Pasien::findOrFail($id);
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
            'file_kk' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240'
        ]);

        $no_rm = $request->no_rm ?: Pasien::generateNoRM();

        // Convert multiselect arrays to comma-separated strings if needed
        $disabilitas = $request->jenis_disabilitas;
        if (is_array($disabilitas)) {
            $disabilitas = array_map(function($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->jenis_disabilitas_lainnya)) {
                    return 'Lainnya (' . trim($request->jenis_disabilitas_lainnya) . ')';
                }
                return $item;
            }, $disabilitas);
            $disabilitas = implode(', ', array_filter($disabilitas));
        }
        $alat = $request->alat_bantu;
        if (is_array($alat)) {
            $alat = array_map(function($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->alat_bantu_lainnya)) {
                    return 'Lainnya (' . trim($request->alat_bantu_lainnya) . ')';
                }
                return $item;
            }, $alat);
            $alat = implode(', ', array_filter($alat));
        }

        $upt = $request->upt_lokasi ?: (session('selected_upt') ?: null);

        $request->merge([
            'no_rm' => $no_rm,
            'cara_bayar' => 'Gratis',
            'kewarganegaraan' => $request->kewarganegaraan ?? 'WNI',
            'jenis_disabilitas' => $disabilitas,
            'alat_bantu' => $alat,
            'upt_lokasi' => $upt
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

        return redirect()->route('penerima-manfaat')->with('sukses','Data Penerima Manfaat berhasil ditambahkan');
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
            'file_kk' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240'
        ]);

        $data = Pasien::findOrFail($id);

        // Convert multiselect arrays to comma-separated strings if needed
        $disabilitas = $request->jenis_disabilitas;
        if (is_array($disabilitas)) {
            $disabilitas = array_map(function($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->jenis_disabilitas_lainnya)) {
                    return 'Lainnya (' . trim($request->jenis_disabilitas_lainnya) . ')';
                }
                return $item;
            }, $disabilitas);
            $disabilitas = implode(', ', array_filter($disabilitas));
        }
        $alat = $request->alat_bantu;
        if (is_array($alat)) {
            $alat = array_map(function($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->alat_bantu_lainnya)) {
                    return 'Lainnya (' . trim($request->alat_bantu_lainnya) . ')';
                }
                return $item;
            }, $alat);
            $alat = implode(', ', array_filter($alat));
        }

        $upt = $request->upt_lokasi ?: ($data->upt_lokasi ?: (session('selected_upt') ?: null));

        $request->merge([
            'cara_bayar' => 'Gratis',
            'jenis_disabilitas' => $disabilitas,
            'alat_bantu' => $alat,
            'upt_lokasi' => $upt
        ]);
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

        return redirect()->route('penerima-manfaat')->with('sukses','Data Penerima Manfaat berhasil diperbaharui');
    }

    function delete(Request $request,$id)
    {
        // Pasien::find($id)->update(['deleted_at'=>Carbon::now()]);
       $suk = Pasien::find($id)->delete();
       if($suk){
            Rekam::where('pasien_id',$id)->delete();
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