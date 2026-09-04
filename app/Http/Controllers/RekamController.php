<?php

namespace App\Http\Controllers;

use App\Events\StatusRekamUpdate;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Rekam;
use App\Models\RekamAssessment;
use App\Models\Tindakan;
use App\Notifications\RekamUpdateNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as Notification;

class RekamController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $role = $user->role_display();
        $rekams = Rekam::latest('rekam.created_at')
                    ->select('rekam.*')
                    ->leftJoin('pasien', function($join) {
                        $join->on('rekam.pasien_id', '=', 'pasien.id');
                    })
                    ->when(session('selected_upt'), function ($query) {
                        $upt = session('selected_upt');
                        $query->where(function ($q) use ($upt) {
                            $q->where('rekam.poli', 'LIKE', "%{$upt}%")
                              ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
                        });
                    })
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where(function ($q) use ($request) {
                            $q->where('rekam.tgl_rekam', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.no_rekam', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.poli', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.layanan_terapi', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.nama', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.no_bpjs', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.no_rm', 'LIKE', "%{$request->keyword}%");
                        });
                    })
                    ->when($role == "Dokter", function ($query) use ($user) {
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where(function($q) use ($dokter) {
                                $q->where('rekam.dokter_id', '=', $dokter->id)
                                  ->orWhere('rekam.terapis_pendamping_id', '=', $dokter->id);
                            });
                        }
                    })
                    ->when($request->filled('status') || $request->filled('tab'), function ($query) use ($request, $role) {
                        $status = $request->status ?? $request->tab;
                        if ($status === 'all') {
                            return;
                        }
                        if ($status == '5') {
                            if ($role == "Dokter") {
                                $query->whereIn('rekam.status', [3, 4, 5]);
                            } else {
                                $query->whereIn('rekam.status', [4, 5]);
                            }
                        } else {
                            $query->where('rekam.status', '=', $status);
                        }
                    })
                    ->when($request->filled('layanan'), function ($query) use ($request) {
                        $query->where('rekam.layanan_terapi', 'LIKE', "%{$request->layanan}%");
                    })
                    ->with(['pasien', 'dokter', 'terapisPendamping']);

        $perPageInput = $request->input('per_page', 10);
        if ($perPageInput === 'all') {
            $perPage = 1000;
        } else {
            $perPage = (int) $perPageInput;
            if ($perPage <= 0) {
                $perPage = 10;
            }
        }

        $rekams = $rekams->paginate($perPage);
        return view('rekam.index', compact('rekams'));
    }

    public function exportCsv(Request $request)
    {
        $user = auth()->user();
        $role = $user->role_display();

        $rekams = Rekam::latest('rekam.created_at')
                    ->select('rekam.*')
                    ->leftJoin('pasien', function($join) {
                        $join->on('rekam.pasien_id', '=', 'pasien.id');
                    })
                    ->when(session('selected_upt'), function ($query) {
                        $upt = session('selected_upt');
                        $query->where(function ($q) use ($upt) {
                            $q->where('rekam.poli', 'LIKE', "%{$upt}%")
                              ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
                        });
                    })
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where(function ($q) use ($request) {
                            $q->where('rekam.tgl_rekam', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.no_rekam', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.poli', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('rekam.layanan_terapi', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.nama', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.no_bpjs', 'LIKE', "%{$request->keyword}%")
                                ->orWhere('pasien.no_rm', 'LIKE', "%{$request->keyword}%");
                        });
                    })
                    ->when($role == "Dokter", function ($query) use ($user) {
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where(function($q) use ($dokter) {
                                $q->where('rekam.dokter_id', '=', $dokter->id)
                                  ->orWhere('rekam.terapis_pendamping_id', '=', $dokter->id);
                            });
                        }
                    })
                    ->when($request->filled('status') || $request->filled('tab'), function ($query) use ($request, $role) {
                        $status = $request->status ?? $request->tab;
                        if ($status === 'all') {
                            return;
                        }
                        if ($status == '5') {
                            if ($role == "Dokter") {
                                $query->whereIn('rekam.status', [3, 4, 5]);
                            } else {
                                $query->whereIn('rekam.status', [4, 5]);
                            }
                        } else {
                            $query->where('rekam.status', '=', $status);
                        }
                    })
                    ->when($request->filled('layanan'), function ($query) use ($request) {
                        $query->where('rekam.layanan_terapi', 'LIKE', "%{$request->layanan}%");
                    })
                    ->with(['pasien', 'dokter', 'terapisPendamping'])
                    ->get();

        $filename = 'data-rekam-medis-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'No',
            'No. Rekam Medis',
            'Tanggal Rekam',
            'No. RM',
            'Nama Penerima Manfaat',
            'NIK',
            'No. HP',
            'Alamat',
            'Omah Terapiku',
            'Jenis Layanan Terapi',
            'Terapis / Dokter',
            'Keluhan',
            'Pemeriksaan',
            'Tindakan',
            'Diagnosa (ICD)',
            'Status Pemeriksaan',
            'Waktu Pendaftaran',
        ];

        $callback = function () use ($rekams, $columns) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, $columns);

            $index = 1;
            foreach ($rekams as $row) {
                // Status text
                $statusText = 'Antrian';
                if ($row->status == 2) {
                    $statusText = 'Pemeriksaan';
                } elseif ($row->status == 3) {
                    $statusText = 'Menunggu';
                } elseif ($row->status == 4 || $row->status == 5) {
                    $statusText = 'Selesai';
                }

                // Assessment / Diagnosa text
                $diagnosaText = $row->diagnosa ?: '';
                if (!$diagnosaText && $row->diagnosa() && count($row->diagnosa()) > 0) {
                    $diagnosaList = [];
                    foreach ($row->diagnosa() as $diag) {
                        $diagnosaList[] = ($diag->diagnosa ?? '');
                    }
                    $diagnosaText = implode('; ', $diagnosaList);
                }
                $diagnosaText = $diagnosaText ?: '-';

                fputcsv($file, [
                    $index++,
                    $row->no_rekam ?? '-',
                    $row->tgl_rekam ? Carbon::parse($row->tgl_rekam)->format('d/m/Y') : '-',
                    $row->pasien->no_rm ?? '-',
                    $row->pasien->nama ?? '-',
                    $row->pasien && $row->pasien->nik ? "'" . $row->pasien->nik : '-',
                    $row->pasien && $row->pasien->no_hp ? "'" . $row->pasien->no_hp : '-',
                    $row->pasien->alamat_lengkap ?? '-',
                    $row->poli ?? '-',
                    $row->layanan_terapi ?? '-',
                    $row->dokter->nama ?? '-',
                    $row->keluhan ?? '-',
                    $row->pemeriksaan ?? '-',
                    $row->tindakan ?? '-',
                    $diagnosaText,
                    $statusText,
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function add(Request $request)
    {
        $poli = Poli::where('status', 1)->get();
        $dokters = Dokter::where('status', 1)->get();
        return view('rekam.add', compact('poli', 'dokters'));
    }

    public function edit(Request $request, $id)
    {
        $poli = Poli::where('status', 1)->get();
        $dokters = Dokter::where('status', 1)->get();
        $data = Rekam::with(['terapisPendamping'])->findOrFail($id);
        return view('rekam.edit', compact('data', 'poli', 'dokters'));
    }

    public function detail(Request $request, $pasien_id)
    {
        $pasien = Pasien::findOrFail($pasien_id);
        
        $rekamLatest = Rekam::latest()
                            ->where('status', '!=', 5)
                            ->where('pasien_id', $pasien_id)
                            ->with(['dokter', 'terapisPendamping', 'assessment'])
                            ->first();

        $rekams = Rekam::latest()
                    ->where('pasien_id', $pasien_id)
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where('tgl_rekam', 'LIKE', "%{$request->keyword}%");
                    })
                    ->when($request->poli, function ($query) use ($request) {
                        $query->where('poli', 'LIKE', "%{$request->poli}%");
                    })
                    ->with(['dokter', 'terapisPendamping', 'assessment'])
                    ->paginate(10);
                    
        if ($rekamLatest) {
            auth()->user()->notifications->where('data.no_rekam', $rekamLatest->no_rekam)->markAsRead();
        }
        $poli = Poli::where('status', 1)->get();

        // Riwayat Asesmen Lengkap Penerima Manfaat
        $riwayatAssessment = RekamAssessment::where('pasien_id', $pasien_id)
            ->orderBy('tgl_assessment', 'desc')
            ->orderBy('id', 'desc')
            ->with(['dokter', 'rekam'])
            ->get();

        $latestAssessment = $riwayatAssessment->first();
        $masterTindakan = Tindakan::orderBy('kode', 'asc')->get();

        return view('rekam.detail-rekam', compact('pasien', 'rekams', 'rekamLatest', 'poli', 'riwayatAssessment', 'latestAssessment', 'masterTindakan'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'tgl_rekam' => 'required',
            'pasien_id' => 'required',
            'pasien_nama' => 'required',
            'layanan_terapi' => 'required|string',
            'keluhan' => 'required',
            'poli' => 'required',
            'dokter_id' => 'required'
        ], [
            'layanan_terapi.required' => 'Jenis Layanan Terapi yang Dituju wajib dipilih.',
            'pasien_nama.required' => 'Nama Penerima Manfaat wajib dipilih.'
        ]);

        $pasien = Pasien::where('id', $request->pasien_id)->first();
        if (!$pasien) {
            return redirect()->back()->withInput($request->input())
                                    ->withErrors(['pasien_id' => 'Data Pasien Tidak Ditemukan']);
        }

        $rekam_ada = Rekam::where('pasien_id', $request->pasien_id)
                            ->whereIn('status', [1, 2, 3, 4])
                            ->first();
        if ($rekam_ada) {
            return redirect()->back()->withInput($request->input())
                                    ->withErrors(['pasien_id' => 'Pasien ini masih belum selesai periksa, harap selesaikan pemeriksaan sebelumnya']);
        }

        $upt = $request->upt_lokasi ?: ($request->poli ?: (session('selected_upt') ?: null));

        $request->merge([
            'no_rekam' => "REG#" . date('Ymd') . $request->pasien_id,
            'petugas_id' => auth()->user()->id,
            'status' => 1,
            'cara_bayar' => 'Gratis',
            'biaya_pemeriksaan' => 0,
            'biaya_tindakan' => 0,
            'biaya_obat' => 0,
            'total_biaya' => 0,
            'upt_lokasi' => $upt,
            'sesi_waktu' => $request->sesi_waktu,
            'terapis_pendamping_id' => $request->terapis_pendamping_id ?: null,
        ]);

        Rekam::create($request->all());

        return redirect()->route('rekam.detail', $request->pasien_id)
                        ->with('sukses', 'Sesi Terapi Berhasil Didaftarkan. Silakan lakukan pemeriksaan dan proses terapi.');
    }

    function update(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_rekam' => 'required',
            'pasien_id' => 'required',
            'pasien_nama' => 'required',
            'layanan_terapi' => 'required|string',
            'keluhan' => 'required',
            'poli' => 'required',
            'dokter_id' => 'required'
        ], [
            'layanan_terapi.required' => 'Jenis Layanan Terapi yang Dituju wajib dipilih.'
        ]);

        $pasien = Pasien::where('id', $request->pasien_id)->first();
        if (!$pasien) {
            return redirect()->back()->withInput($request->input())
                                    ->withErrors(['pasien_id' => 'Data Pasien Tidak Ditemukan']);
        }
        
        $rekam = Rekam::findOrFail($id);
        $upt = $request->upt_lokasi ?: ($request->poli ?: (session('selected_upt') ?: null));

        $request->merge([
            'cara_bayar' => 'Gratis',
            'biaya_pemeriksaan' => 0,
            'biaya_tindakan' => 0,
            'biaya_obat' => 0,
            'total_biaya' => 0,
            'upt_lokasi' => $upt,
            'sesi_waktu' => $request->sesi_waktu,
            'terapis_pendamping_id' => $request->terapis_pendamping_id ?: null,
        ]);
        $rekam->update($request->all());

        return redirect()->route('rekam.detail', $request->pasien_id)
                        ->with('sukses', 'Data Sesi Terapi Berhasil Diperbaharui.');
    }

    public function rekam_status(Request $request, $id, $status)
    {
        $rekam = Rekam::find($id);
        $role = auth()->user()->role_display();

        if ($status == 2 && !in_array($role, ['Admin', 'Pendaftaran'])) {
            abort(403);
        }

        if (in_array($status, [3, 5]) && !in_array($role, ['Admin', 'Dokter'])) {
            abort(403);
        }

        if ($status == 3 && $rekam->poli != "Poli Gigi") {
            if ($rekam->pemeriksaan == null) {
                return redirect()->route('rekam.detail', $rekam->pasien_id)
                                ->with('gagal', 'Pemeriksaan Isi lebih dulu');
            }
        }
        if ($status == 3) {
            if ($rekam->tindakan == null) {
                return redirect()->route('rekam.detail', $rekam->pasien_id)
                                ->with('gagal', 'Tindakan dan Diagnosa Belum diisi');
            }
        }

        $rekam->update([
            'status' => $status
        ]);

        $waktu = Carbon::parse($rekam->created_at)->format('d/m/Y H:i:s');
        if ($status == 2) {
            $dokter = Dokter::find($rekam->dokter_id);
            $user = User::find($dokter->user_id);
            $message = "Pasien " . $rekam->pasien->nama . ", silahkan diproses";
            Notification::send($user, new RekamUpdateNotification($rekam, $message));
            $link = Route('rekam.detail', $rekam->pasien_id);
            event(new StatusRekamUpdate($user->id, $rekam->no_rekam, $message, $link, $waktu));

        } else if ($status == 4) {
            $user = User::where('role', 2)->get();
            $message = "Rekam medis pasien " . $rekam->pasien->nama . " siap diproses";
            Notification::send($user, new RekamUpdateNotification($rekam, $message));
            foreach ($user as $key => $item) {
                $link = Route('rekam.detail', $rekam->pasien_id);
                event(new StatusRekamUpdate($item->id, $rekam->no_rekam, $message, $link, $waktu));
            }
        }

        return redirect()->route('rekam.detail', $rekam->pasien_id)
                        ->with('sukses', 'Status Rekam medis selesai diperbaharui');
    }

    public function delete(Request $request, $id)
    {
        Rekam::find($id)->delete();
        return redirect()->route('rekam')->with('sukses', 'Data berhasil dihapus');
    } 
}