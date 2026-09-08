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

        if ($request->has('upt')) {
            $selectedUpt = $request->upt;
            session(['selected_upt' => $request->upt]);
        } else {
            $selectedUpt = session('selected_upt', 'all');
        }

        $activeUpts = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        $rekams = Rekam::latest('rekam.created_at')
                    ->select('rekam.*')
                    ->leftJoin('pasien', function($join) {
                        $join->on('rekam.pasien_id', '=', 'pasien.id');
                    })
                    ->when($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '', function ($query) use ($selectedUpt) {
                        $query->where(function ($q) use ($selectedUpt) {
                            $q->where('rekam.poli', 'LIKE', "%{$selectedUpt}%")
                              ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$selectedUpt}%")
                              ->orWhere('pasien.upt_lokasi', 'LIKE', "%{$selectedUpt}%");
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
        return view('rekam.index', compact('rekams', 'activeUpts', 'selectedUpt'));
    }

    public function exportCsv(Request $request)
    {
        $user = auth()->user();
        $role = $user->role_display();

        $selectedUpt = $request->filled('upt') ? $request->upt : session('selected_upt', 'all');

        $rekams = Rekam::latest('rekam.created_at')
                    ->select('rekam.*')
                    ->leftJoin('pasien', function($join) {
                        $join->on('rekam.pasien_id', '=', 'pasien.id');
                    })
                    ->when($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '', function ($query) use ($selectedUpt) {
                        $query->where(function ($q) use ($selectedUpt) {
                            $q->where('rekam.poli', 'LIKE', "%{$selectedUpt}%")
                              ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$selectedUpt}%")
                              ->orWhere('pasien.upt_lokasi', 'LIKE', "%{$selectedUpt}%");
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
        $selectedPasien = null;
        if ($request->filled('pasien_id')) {
            $selectedPasien = Pasien::find($request->pasien_id);
        }
        return view('rekam.add', compact('poli', 'dokters', 'selectedPasien'));
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
                    
        if (auth()->check()) {
            foreach (auth()->user()->unreadNotifications as $notif) {
                if (isset($notif->data['id_pasien']) && $notif->data['id_pasien'] == $pasien_id) {
                    $notif->markAsRead();
                } elseif (isset($notif->data['no_rekam']) && $rekamLatest && $notif->data['no_rekam'] == $rekamLatest->no_rekam) {
                    $notif->markAsRead();
                }
            }
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

    private function notifyTerapisPasien($rekam, $message, $tipe = 'penugasan')
    {
        try {
            $waktu = Carbon::parse($rekam->created_at ?? now())->format('d/m/Y H:i:s');
            $link = route('rekam.detail', $rekam->pasien_id);

            // 1. Terapis Utama
            if ($rekam->dokter_id) {
                $dokter = Dokter::find($rekam->dokter_id);
                if ($dokter && $dokter->user_id) {
                    $user = User::find($dokter->user_id);
                    if ($user) {
                        Notification::send($user, new RekamUpdateNotification($rekam, $message, $tipe));
                        try {
                            event(new StatusRekamUpdate($user->id, $rekam->no_rekam, $message, $link, $waktu));
                        } catch (\Throwable $e) {
                            // ignore broadcast error
                        }
                    }
                }
            }

            // 2. Terapis Pendamping (jika ada)
            if ($rekam->terapis_pendamping_id && $rekam->terapis_pendamping_id != $rekam->dokter_id) {
                $pendamping = Dokter::find($rekam->terapis_pendamping_id);
                if ($pendamping && $pendamping->user_id) {
                    $userPendamping = User::find($pendamping->user_id);
                    if ($userPendamping) {
                        $msgPendamping = "Anda ditugaskan sebagai Terapis Pendamping untuk pasien " . optional($rekam->pasien)->nama . " (" . ($rekam->layanan_terapi ?? 'Terapi') . ")";
                        Notification::send($userPendamping, new RekamUpdateNotification($rekam, $msgPendamping, 'pendamping'));
                        try {
                            event(new StatusRekamUpdate($userPendamping->id, $rekam->no_rekam, $msgPendamping, $link, $waktu));
                        } catch (\Throwable $e) {
                            // ignore broadcast error
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            \Log::error('Notification dispatch error: ' . $th->getMessage());
        }
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

        $rekam = Rekam::create($request->all());

        // Kirim Notifikasi Penugasan Pasien Baru ke Terapis Terpilih
        $namaPasien = $pasien ? $pasien->nama : 'Penerima Manfaat';
        $layanan = $request->layanan_terapi ?: 'Layanan Terapi';
        $sesi = $request->sesi_waktu ? " - " . $request->sesi_waktu : "";
        $pesanNotif = "Pasien baru " . $namaPasien . " ditugaskan ke Anda untuk " . $layanan . $sesi;
        $this->notifyTerapisPasien($rekam, $pesanNotif, 'penugasan_baru');

        return redirect()->route('rekam.detail', $request->pasien_id)
                        ->with('sukses', 'Sesi Terapi Berhasil Didaftarkan. Notifikasi penugasan telah dikirimkan ke terapis.');
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
        $oldDokterId = $rekam->dokter_id;
        $oldPendampingId = $rekam->terapis_pendamping_id;
        
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

        // Jika terjadi perubahan terapis atau sesi, kirimkan notifikasi pembaruan
        if ($oldDokterId != $request->dokter_id || $oldPendampingId != ($request->terapis_pendamping_id ?: null)) {
            $namaPasien = $pasien ? $pasien->nama : 'Penerima Manfaat';
            $pesanNotif = "Pembaruan penugasan sesi terapi pasien " . $namaPasien . " (" . ($rekam->layanan_terapi ?? 'Terapi') . ")";
            $this->notifyTerapisPasien($rekam, $pesanNotif, 'update_penugasan');
        }

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

        $waktu = Carbon::parse($rekam->created_at ?? now())->format('d/m/Y H:i:s');
        if ($status == 2) {
            $namaPasien = optional($rekam->pasien)->nama ?? 'Pasien';
            $message = "Pasien " . $namaPasien . ", silahkan diproses untuk pemeriksaan/terapi";
            $this->notifyTerapisPasien($rekam, $message, 'panggilan_periksa');

        } else if ($status == 4 || $status == 5) {
            $users = User::whereIn('role', [1, 2])->where('status', 1)->get();
            $namaPasien = optional($rekam->pasien)->nama ?? 'Pasien';
            $message = "Sesi rekam medis pasien " . $namaPasien . " telah selesai diproses";
            if ($users->isNotEmpty()) {
                Notification::send($users, new RekamUpdateNotification($rekam, $message, 'selesai'));
                foreach ($users as $item) {
                    try {
                        $link = route('rekam.detail', $rekam->pasien_id);
                        event(new StatusRekamUpdate($item->id, $rekam->no_rekam, $message, $link, $waktu));
                    } catch (\Throwable $e) {
                        // ignore broadcast error
                    }
                }
            }
        }

        return redirect()->route('rekam.detail', $rekam->pasien_id)
                        ->with('sukses', 'Status Rekam medis selesai diperbaharui');
    }

    public function delete(Request $request, $id)
    {
        if (auth()->user()->role_display() !== 'Admin') {
            abort(403, 'Akses tidak diizinkan. Hanya Admin yang dapat menghapus data rekam medis.');
        }
        Rekam::findOrFail($id)->delete();
        return redirect()->route('rekam')->with('sukses', 'Data rekam medis berhasil dihapus');
    }

    public function printSoap($id)
    {
        $rekam = Rekam::with(['pasien', 'dokter', 'terapisPendamping', 'assessment'])->findOrFail($id);
        $pasien = $rekam->pasien;
        $upt = Poli::where('nama', $rekam->upt_lokasi)->orWhere('nama', $rekam->poli)->first();
        return view('rekam.print-soap', compact('rekam', 'pasien', 'upt'));
    }

    public function printHomeProgram($id)
    {
        $rekam = Rekam::with(['pasien', 'dokter', 'terapisPendamping', 'assessment'])->findOrFail($id);
        $pasien = $rekam->pasien;
        $upt = Poli::where('nama', $rekam->upt_lokasi)->orWhere('nama', $rekam->poli)->first();
        return view('rekam.print-home-program', compact('rekam', 'pasien', 'upt'));
    }

    public function readNotification($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            $pasienId = $notification->data['id_pasien'] ?? null;
            if ($pasienId) {
                return redirect()->route('rekam.detail', $pasienId);
            }
        }
        return redirect()->route('rekam');
    }

    public function markAllNotificationsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai telah dibaca']);
        }
        return redirect()->back()->with('sukses', 'Semua notifikasi telah ditandai dibaca');
    }

    public function getUnreadNotificationsJson()
    {
        $user = auth()->user();
        $unread = $user->unreadNotifications;
        $items = $unread->take(15)->map(function ($notif) {
            $createdAt = isset($notif->data['created_at']) 
                ? (is_string($notif->data['created_at']) ? Carbon::parse($notif->data['created_at'])->format('d/m/Y H:i') : $notif->data['created_at'])
                : $notif->created_at->format('d/m/Y H:i');

            return [
                'id' => $notif->id,
                'no_rekam' => $notif->data['no_rekam'] ?? '-',
                'nama_pasien' => $notif->data['nama_pasien'] ?? 'Pasien',
                'no_rm' => $notif->data['no_rm'] ?? '-',
                'layanan_terapi' => $notif->data['layanan_terapi'] ?? 'Terapi',
                'sesi_waktu' => $notif->data['sesi_waktu'] ?? '-',
                'message' => $notif->data['message'] ?? 'Ada penugasan pasien baru.',
                'tipe' => $notif->data['tipe'] ?? 'info',
                'created_at' => $createdAt,
                'read_url' => route('notifications.read', $notif->id),
                'detail_url' => isset($notif->data['id_pasien']) ? route('rekam.detail', $notif->data['id_pasien']) : route('rekam'),
            ];
        });

        return response()->json([
            'success' => true,
            'unread_count' => $unread->count(),
            'notifications' => $items
        ]);
    }
}