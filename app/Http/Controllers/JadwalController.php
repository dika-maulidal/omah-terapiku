<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Rekam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $role = $user->role_display();

        $selectedUpt = session('selected_upt');
        $tanggal = $request->get('tanggal', date('Y-m-d'));
        $uptFilter = $request->get('upt', $selectedUpt);
        $layananFilter = $request->get('layanan');
        $dokterFilter = $request->get('dokter_id');

        // Master Slots Sesi Terapi Omah Terapiku
        $masterSlots = [
            'Sesi 1 (08.00 - 08.45 WIB)' => ['jam' => '08:00 - 08:45 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-primary'],
            'Sesi 2 (08.45 - 09.30 WIB)' => ['jam' => '08:45 - 09:30 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-info'],
            'Sesi 3 (09.30 - 10.15 WIB)' => ['jam' => '09:30 - 10.15 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-success'],
            'Sesi 4 (10.15 - 11.00 WIB)' => ['jam' => '10:15 - 11:00 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-warning'],
            'Sesi 5 (11.00 - 11.45 WIB)' => ['jam' => '11:00 - 11:45 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-secondary'],
            'Sesi 6 (11.45 - 12.30 WIB)' => ['jam' => '11:45 - 12:30 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-dark'],
            'Sesi 7 (12.30 - 13.00 WIB)' => ['jam' => '12:30 - 13:00 WIB', 'icon' => 'fa-clock', 'badge' => 'badge-light text-dark'],
            'Sesi Khusus / Fleksibel'    => ['jam' => 'Fleksibel / Sesuai Kesepakatan', 'icon' => 'fa-calendar-check', 'badge' => 'badge-outline-primary'],
        ];

        // Base Query untuk Tanggal Terpilih
        $query = Rekam::whereDate('tgl_rekam', $tanggal)
            ->with(['pasien', 'dokter', 'assessment']);

        if ($uptFilter && $uptFilter !== 'all') {
            $query->where(function($q) use ($uptFilter) {
                $q->where('poli', 'LIKE', "%{$uptFilter}%")
                  ->orWhere('upt_lokasi', 'LIKE', "%{$uptFilter}%");
            });
        }

        if ($layananFilter && $layananFilter !== 'all') {
            $query->where('layanan_terapi', $layananFilter);
        }

        if ($role === 'Dokter') {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', $dokter->id);
            }
        } elseif ($dokterFilter && $dokterFilter !== 'all') {
            $query->where('dokter_id', $dokterFilter);
        }

        $jadwals = $query->orderBy('sesi_waktu', 'asc')->orderBy('created_at', 'asc')->get();

        // Hitung Statistik
        $stats = [
            'total' => $jadwals->count(),
            'antrian' => $jadwals->where('status', 1)->count(),
            'pemeriksaan' => $jadwals->where('status', 2)->count(),
            'selesai' => $jadwals->whereIn('status', [3, 4, 5])->count(),
        ];

        // Kelompokkan Jadwal per Slot Sesi
        $jadwalPerSlot = [];
        foreach ($masterSlots as $slotName => $meta) {
            $jadwalPerSlot[$slotName] = [];
        }
        $jadwalPerSlot['Lainnya'] = [];

        foreach ($jadwals as $item) {
            $slot = $item->sesi_waktu ?: 'Sesi Khusus / Fleksibel';
            if (isset($jadwalPerSlot[$slot])) {
                $jadwalPerSlot[$slot][] = $item;
            } else {
                $jadwalPerSlot['Lainnya'][] = $item;
            }
        }

        // Data Master Dropdown Filter
        $polis = Poli::where('status', 1)->get();
        $dokters = Dokter::where('status', 1)->get();

        // Daftar Hari Rabu Mendatang (Hari Layanan Rutin Omah Terapiku)
        $rabuDates = [];
        $currentRabu = Carbon::parse($tanggal)->isWednesday() 
            ? Carbon::parse($tanggal) 
            : Carbon::parse($tanggal)->next(Carbon::WEDNESDAY);

        for ($i = 0; $i < 4; $i++) {
            $rabuDates[] = $currentRabu->copy()->addWeeks($i);
        }

        return view('jadwal.index', compact(
            'jadwals', 'jadwalPerSlot', 'masterSlots', 'stats',
            'tanggal', 'uptFilter', 'layananFilter', 'dokterFilter',
            'polis', 'dokters', 'rabuDates'
        ));
    }

    public function eventsJson(Request $request)
    {
        $user = auth()->user();
        $role = $user->role_display();

        $start = $request->get('start');
        $end = $request->get('end');
        $selectedUpt = session('selected_upt');
        $uptFilter = $request->get('upt', $selectedUpt);
        $layananFilter = $request->get('layanan');
        $dokterFilter = $request->get('dokter_id');

        $query = Rekam::with(['pasien', 'dokter', 'assessment']);

        if ($start && $end) {
            $query->whereBetween('tgl_rekam', [substr($start, 0, 10), substr($end, 0, 10)]);
        }

        if ($uptFilter && $uptFilter !== 'all') {
            $query->where(function($q) use ($uptFilter) {
                $q->where('poli', 'LIKE', "%{$uptFilter}%")
                  ->orWhere('upt_lokasi', 'LIKE', "%{$uptFilter}%");
            });
        }

        if ($layananFilter && $layananFilter !== 'all') {
            $query->where('layanan_terapi', $layananFilter);
        }

        if ($role === 'Dokter') {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', $dokter->id);
            }
        } elseif ($dokterFilter && $dokterFilter !== 'all') {
            $query->where('dokter_id', $dokterFilter);
        }

        $records = $query->get();

        // Color Palette per Layanan Terapi
        $layananColors = [
            'Fisioterapi' => ['bg' => '#2D4B7A', 'border' => '#1e355b'],
            'Terapi Okupasi / Sensorik Integrasi' => ['bg' => '#059669', 'border' => '#047857'],
            'Terapi Wicara' => ['bg' => '#d97706', 'border' => '#b45309'],
            'Terapi Netra (Orientasi & Mobilitas)' => ['bg' => '#7c3aed', 'border' => '#6d28d9'],
        ];

        // Slot Time Mapping
        $slotTimes = [
            'Sesi 1 (08.00 - 08.45 WIB)' => ['start' => '08:00:00', 'end' => '08:45:00'],
            'Sesi 2 (08.45 - 09.30 WIB)' => ['start' => '08:45:00', 'end' => '09:30:00'],
            'Sesi 3 (09.30 - 10.15 WIB)' => ['start' => '09:30:00', 'end' => '10:15:00'],
            'Sesi 4 (10.15 - 11.00 WIB)' => ['start' => '10:15:00', 'end' => '11:00:00'],
            'Sesi 5 (11.00 - 11.45 WIB)' => ['start' => '11:00:00', 'end' => '11:45:00'],
            'Sesi 6 (11.45 - 12.30 WIB)' => ['start' => '11:45:00', 'end' => '12:30:00'],
            'Sesi 7 (12.30 - 13.00 WIB)' => ['start' => '12:30:00', 'end' => '13:00:00'],
            'Sesi Khusus / Fleksibel'    => ['start' => '08:00:00', 'end' => '13:00:00'],
        ];

        $events = [];

        foreach ($records as $r) {
            $pasienNama = $r->pasien ? $r->pasien->nama : 'Pasien #' . $r->pasien_id;
            $noRm = $r->pasien ? $r->pasien->no_rm : '-';
            $layanan = $r->layanan_terapi ?: 'Fisioterapi';
            $colors = $layananColors[$layanan] ?? ['bg' => '#2D4B7A', 'border' => '#1e355b'];

            $slotInfo = $slotTimes[$r->sesi_waktu] ?? ['start' => '08:00:00', 'end' => '09:00:00'];
            $startTime = $r->tgl_rekam . 'T' . $slotInfo['start'];
            $endTime = $r->tgl_rekam . 'T' . $slotInfo['end'];

            $statusLabel = 'Antrean';
            $statusBadgeClass = 'badge-warning';
            if ($r->status == 2) {
                $statusLabel = 'Pemeriksaan';
                $statusBadgeClass = 'badge-info';
            } elseif ($r->status >= 3) {
                $statusLabel = 'Selesai';
                $statusBadgeClass = 'badge-success';
            }

            $events[] = [
                'id' => $r->id,
                'title' => ($r->sesi_waktu ? substr($r->sesi_waktu, 0, 6) . ' - ' : '') . $pasienNama,
                'start' => $startTime,
                'end' => $endTime,
                'backgroundColor' => $colors['bg'],
                'borderColor' => $colors['border'],
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'no_rekam' => $r->no_rekam,
                    'pasien_nama' => $pasienNama,
                    'pasien_id' => $r->pasien_id,
                    'no_rm' => $noRm,
                    'layanan_terapi' => $layanan,
                    'upt' => $r->upt_lokasi ?: ($r->poli ?: 'Omah Terapiku'),
                    'terapis' => $r->dokter ? $r->dokter->nama : '-',
                    'sesi_waktu' => $r->sesi_waktu ?: 'Sesi Fleksibel',
                    'tgl_rekam' => Carbon::parse($r->tgl_rekam)->translatedFormat('l, d F Y'),
                    'keluhan' => $r->keluhan ?: '-',
                    'status_label' => $statusLabel,
                    'status_badge' => $statusBadgeClass,
                    'detail_url' => route('rekam.detail', $r->pasien_id),
                    'assessment_url' => $r->assessment ? route('rekam.assessment.show', $r->id) : route('rekam.assessment', $r->id),
                ],
            ];
        }

        return response()->json($events);
    }
}
