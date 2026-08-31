<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DashboardQuery 
{
    public function perikaHariini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        })
                        ->count();
    }

    public function pasienAntri(){
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        })
                        ->whereIn('status', [1, 2])
                        ->count();
    }

    public function perikaBulanini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereMonth('tgl_rekam', date('m'))
                    ->whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    })
                    ->count();
    }

    public function perikaTahunini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    })
                    ->count();
    }

    public function totalPeriksa()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::when($role == "Dokter", function ($query) use ($user){
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', '=', $dokter->id);
            }
        })->count();
    }

    public function totalPasien()
    {
        return Pasien::whereNull('deleted_at')->count();
    }

    public function totalDoktor()
    {
        return Dokter::where('status', 1)->count();
    }

    public function diagnosaBulanan(){
        $filterBulan = date('Y-m');
        $data = DB::select('
            select aa.*, ic.name_id from (
                select diagnosa, count(diagnosa) as total
                from (
                    select a.diagnosa
                    from rekam_diagnosa a 
                    LEFT JOIN rekam r ON r.id = a.rekam_id
                    where a.diagnosa is not null
                    and r.tgl_rekam LIKE "%'.$filterBulan.'%"
                ) sc
                group by diagnosa
            ) aa 
            left join icds ic on ic.code = aa.diagnosa
            order by total desc limit 10');
            
        return $data;
    }

    public function diagnosaYearly(){
        $filter = date('Y-');
        $data = DB::select('
            select aa.*, ic.name_id from (
                select diagnosa, count(diagnosa) as total
                from (
                    select a.diagnosa
                    from rekam_diagnosa a
                    LEFT JOIN rekam r ON r.id = a.rekam_id
                    where a.diagnosa is not null
                    and r.tgl_rekam LIKE "%'.$filter.'%"
                ) sc
                group by diagnosa
            ) aa 
            left join icds ic on ic.code = aa.diagnosa
            order by total desc limit 10');
            
        return $data;
    }

    function rekam_day(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::latest()
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }

    function rekam_day2(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::orderBy('id', 'asc')
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }

    function rekam_antrian(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::orderBy('id', 'desc')
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->where('status', 2)
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }

    public function getAvailableYears()
    {
        $pasienYears = Pasien::selectRaw('YEAR(created_at) as yr')->whereNotNull('created_at')->distinct()->pluck('yr')->toArray();
        $rekamYears = Rekam::selectRaw('YEAR(tgl_rekam) as yr')->whereNotNull('tgl_rekam')->distinct()->pluck('yr')->toArray();
        $currentYear = (int)date('Y');
        $years = array_unique(array_filter(array_merge($pasienYears, $rekamYears, [$currentYear, $currentYear - 1, $currentYear - 2])));
        rsort($years);
        return array_values($years);
    }

    public function getAllYearsPasienData()
    {
        $years = $this->getAvailableYears();
        $dataByYear = [];
        foreach ($years as $year) {
            $monthly = [];
            for ($m = 1; $m <= 12; $m++) {
                $count = Pasien::whereNull('deleted_at')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $m)
                    ->count();
                $monthly[] = $count;
            }
            $dataByYear[$year] = $monthly;
        }
        return $dataByYear;
    }

    public function getStatusAntrianData()
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';

        $query = Rekam::query();
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', $dokter->id);
            }
        }

        $antrian = (clone $query)->where('status', 1)->count();
        $pemeriksaan = (clone $query)->where('status', 2)->count();
        $menunggu = (clone $query)->where('status', 3)->count();
        $selesai = (clone $query)->whereIn('status', [4, 5])->count();
        $total = $antrian + $pemeriksaan + $menunggu + $selesai;

        return [
            'antrian' => $antrian,
            'pemeriksaan' => $pemeriksaan,
            'menunggu' => $menunggu,
            'selesai' => $selesai,
            'total' => $total
        ];
    }

    public function getTren7HariTerakhir()
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';
        $dokterId = null;
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            $dokterId = $dokter ? $dokter->id : null;
        }

        $labels = [];
        $shortLabels = [];
        $dates = [];
        $periksaCounts = [];
        $pasienBaruCounts = [];

        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 6; $i >= 0; $i--) {
            $time = strtotime("-{$i} days");
            $ymd = date('Y-m-d', $time);
            $w = (int)date('w', $time);
            $d = date('j', $time);
            $n = (int)date('n', $time) - 1;

            $dayName = $hariIndo[$w];
            $displayLabel = ($i === 0) ? 'Hari Ini' : $dayName;
            $fullLabel = $dayName . ', ' . $d . ' ' . $bulanIndo[$n];

            $labels[] = $displayLabel . ' (' . $d . '/' . date('m', $time) . ')';
            $shortLabels[] = $fullLabel;
            $dates[] = $ymd;

            // Hitung pelayanan rekam medis pada tanggal tersebut
            $rekamCount = Rekam::whereDate('tgl_rekam', $ymd)
                ->when($dokterId, function ($query) use ($dokterId) {
                    $query->where('dokter_id', $dokterId);
                })
                ->count();
            $periksaCounts[] = $rekamCount;

            // Hitung pendaftaran pasien baru pada tanggal tersebut
            $pasienCount = Pasien::whereNull('deleted_at')
                ->whereDate('created_at', $ymd)
                ->count();
            $pasienBaruCounts[] = $pasienCount;
        }

        $totalPeriksa7Hari = array_sum($periksaCounts);
        $totalPasien7Hari = array_sum($pasienBaruCounts);
        $avgPeriksa = round($totalPeriksa7Hari / 7, 1);

        // Cari hari tertinggi
        $maxPeriksa = !empty($periksaCounts) ? max($periksaCounts) : 0;
        $maxIndex = array_search($maxPeriksa, $periksaCounts);
        $hariTertinggi = ($maxPeriksa > 0 && isset($shortLabels[$maxIndex])) ? $shortLabels[$maxIndex] . ' (' . $maxPeriksa . ')' : '-';

        return [
            'labels' => $labels,
            'full_labels' => $shortLabels,
            'dates' => $dates,
            'periksa' => $periksaCounts,
            'pasien_baru' => $pasienBaruCounts,
            'total_periksa' => $totalPeriksa7Hari,
            'total_pasien_baru' => $totalPasien7Hari,
            'avg_periksa' => $avgPeriksa,
            'hari_tertinggi' => $hariTertinggi,
        ];
    }

    public function getPasienPerOmahTerapiku()
    {
        $allUnits = Omahterapiku::orderBy('nama', 'asc')->get();
        
        $palette = [
            '#2e4b82', // Navy Blue
            '#f5a623', // Amber / Warm Gold
            '#29b6f6', // Cyan / Cerulean
            '#28c76f', // Emerald Green
            '#7367f0', // Purple / Violet
            '#ea5455', // Coral Red
            '#ff9f43', // Orange
            '#00cfe8', // Teal
            '#6c5ce7', // Indigo
            '#10ac84'  // Mint Green
        ];

        $labels = [];
        $counts = [];
        $kunjungans = [];
        $items = [];
        $totalPasienUnik = 0;

        // Grouping dari rekam medis berdasarkan kolom poli (nama unit Omah Terapiku)
        $rekamGroup = DB::table('rekam')
            ->select('poli', DB::raw('count(distinct pasien_id) as total_pasien'), DB::raw('count(*) as total_kunjungan'))
            ->whereNotNull('poli')
            ->where('poli', '!=', '')
            ->groupBy('poli')
            ->get()
            ->keyBy('poli');

        $colorIdx = 0;
        $trackedPoli = [];

        // 1. Prioritaskan unit yang terdaftar di master Omahterapiku
        foreach ($allUnits as $unit) {
            $poliName = $unit->nama;
            $trackedPoli[] = $poliName;
            $pasienCount = isset($rekamGroup[$poliName]) ? (int)$rekamGroup[$poliName]->total_pasien : 0;
            $kunjunganCount = isset($rekamGroup[$poliName]) ? (int)$rekamGroup[$poliName]->total_kunjungan : 0;
            
            $color = $palette[$colorIdx % count($palette)];
            $colorIdx++;

            $labels[] = $unit->nama;
            $counts[] = $pasienCount;
            $kunjungans[] = $kunjunganCount;
            $totalPasienUnik += $pasienCount;

            $items[] = [
                'nama' => $unit->nama,
                'alamat' => $unit->alamat,
                'status' => $unit->status,
                'total_pasien' => $pasienCount,
                'total_kunjungan' => $kunjunganCount,
                'color' => $color,
            ];
        }

        // 2. Jika ada nama poli di rekam medis yang belum ada di tabel master
        foreach ($rekamGroup as $poliName => $data) {
            if (!in_array($poliName, $trackedPoli)) {
                $color = $palette[$colorIdx % count($palette)];
                $colorIdx++;

                $labels[] = $poliName;
                $counts[] = (int)$data->total_pasien;
                $kunjungans[] = (int)$data->total_kunjungan;
                $totalPasienUnik += (int)$data->total_pasien;

                $items[] = [
                    'nama' => $poliName,
                    'alamat' => '-',
                    'status' => 1,
                    'total_pasien' => (int)$data->total_pasien,
                    'total_kunjungan' => (int)$data->total_kunjungan,
                    'color' => $color,
                ];
            }
        }

        // Hitung persentase untuk setiap unit
        foreach ($items as &$it) {
            $it['persentase'] = $totalPasienUnik > 0 ? round(($it['total_pasien'] / $totalPasienUnik) * 100, 1) : 0;
        }

        return [
            'labels' => $labels,
            'counts' => $counts,
            'kunjungans' => $kunjungans,
            'colors' => array_column($items, 'color'),
            'items' => $items,
            'total_pasien' => $totalPasienUnik
        ];
    }
}