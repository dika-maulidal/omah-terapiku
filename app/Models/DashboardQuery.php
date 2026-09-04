<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DashboardQuery 
{
    protected function scopeUpt($query)
    {
        if (session()->has('selected_upt') && session('selected_upt') != '') {
            $upt = session('selected_upt');
            $query->where(function($q) use ($upt) {
                $q->where('rekam.poli', 'LIKE', "%{$upt}%")
                  ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
            });
        }
        return $query;
    }

    public function perikaHariini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        $query = Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        });
        return $this->scopeUpt($query)->count();
    }

    public function pasienAntri(){
        $user = auth()->user();
        $role = $user->role_display();
        $query = Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        })
                        ->whereIn('status', [1, 2]);
        return $this->scopeUpt($query)->count();
    }

    public function perikaBulanini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        $query = Rekam::whereMonth('tgl_rekam', date('m'))
                    ->whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    });
        return $this->scopeUpt($query)->count();
    }

    public function perikaTahunini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        $query = Rekam::whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    });
        return $this->scopeUpt($query)->count();
    }

    public function totalPeriksa()
    {
        $user = auth()->user();
        $role = $user->role_display();
        $query = Rekam::when($role == "Dokter", function ($query) use ($user){
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', '=', $dokter->id);
            }
        });
        return $this->scopeUpt($query)->count();
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

    public function getTopDiagnosaTerbanyak($limit = 10, $periode = 'bulan')
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';
        $dokterId = null;
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            $dokterId = $dokter ? $dokter->id : null;
        }

        $query = DB::table('rekam_diagnosa')
            ->join('rekam', 'rekam.id', '=', 'rekam_diagnosa.rekam_id')
            ->leftJoin('icds', 'icds.code', '=', 'rekam_diagnosa.diagnosa')
            ->select(
                'rekam_diagnosa.diagnosa as code',
                'icds.name_id',
                'icds.name_en',
                DB::raw('count(*) as total')
            )
            ->whereNotNull('rekam_diagnosa.diagnosa')
            ->where('rekam_diagnosa.diagnosa', '!=', '')
            ->when($dokterId, function ($q) use ($dokterId) {
                $q->where('rekam.dokter_id', $dokterId);
            });

        if (session()->has('selected_upt') && session('selected_upt') != '') {
            $upt = session('selected_upt');
            $query->where(function($q) use ($upt) {
                $q->where('rekam.poli', 'LIKE', "%{$upt}%")
                  ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
            });
        }

        if ($periode === 'bulan') {
            $query->whereYear('rekam.tgl_rekam', date('Y'))
                  ->whereMonth('rekam.tgl_rekam', date('m'));
        } elseif ($periode === 'tahun') {
            $query->whereYear('rekam.tgl_rekam', date('Y'));
        }

        $diagnosaData = $query->groupBy('rekam_diagnosa.diagnosa', 'icds.name_id', 'icds.name_en')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();

        $items = [];
        $totalKasus = 0;
        $palette = ['#1e40af', '#2563eb', '#3b82f6', '#60a5fa', '#38bdf8', '#0284c7', '#0369a1', '#0ea5e9', '#64748b', '#475569'];
        $idx = 0;

        foreach ($diagnosaData as $row) {
            $code = $row->code;
            $nama = !empty($row->name_id) ? $row->name_id : (!empty($row->name_en) ? $row->name_en : $code);
            $count = (int)$row->total;
            $totalKasus += $count;

            $items[] = [
                'code' => $code,
                'nama' => $nama,
                'total' => $count,
                'color' => $palette[$idx % count($palette)]
            ];
            $idx++;
        }

        $maxCount = !empty($items) ? max(array_column($items, 'total')) : 0;
        foreach ($items as &$it) {
            $it['persentase'] = $totalKasus > 0 ? round(($it['total'] / $totalKasus) * 100, 1) : 0;
            $it['bar_persen'] = $maxCount > 0 ? round(($it['total'] / $maxCount) * 100, 1) : ($it['total'] > 0 ? 100 : 5);
        }

        return [
            'items' => $items,
            'total' => $totalKasus,
            'labels' => array_column($items, 'nama'),
            'counts' => array_column($items, 'total'),
            'colors' => array_column($items, 'color')
        ];
    }

    public function getTopDiagnosaAll($limit = 10)
    {
        return [
            'bulan' => $this->getTopDiagnosaTerbanyak($limit, 'bulan'),
            'tahun' => $this->getTopDiagnosaTerbanyak($limit, 'tahun'),
            'semua' => $this->getTopDiagnosaTerbanyak($limit, 'semua')
        ];
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

    public function getTrenPelayananData($days = 7)
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

        $hariIndoLengkap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $countDays = (int)$days;
        if ($countDays <= 0) $countDays = 7;

        for ($i = $countDays - 1; $i >= 0; $i--) {
            $time = strtotime("-{$i} days");
            $ymd = date('Y-m-d', $time);
            $w = (int)date('w', $time);
            $d = date('j', $time);
            $n = (int)date('n', $time) - 1;

            $dayName = $hariIndoLengkap[$w];
            $fullLabel = $dayName . ', ' . $d . ' ' . $bulanIndo[$n];

            if ($countDays <= 7) {
                $displayLabel = ($i === 0) ? 'Hari Ini' : $dayName;
                $labels[] = $displayLabel . ' (' . $d . '/' . date('m', $time) . ')';
            } else {
                $labels[] = $d . ' ' . $bulanIndo[$n];
            }

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

        $totalPeriksa = array_sum($periksaCounts);
        $totalPasien = array_sum($pasienBaruCounts);
        $avgPeriksa = round($totalPeriksa / $countDays, 1);

        // Cari hari tertinggi
        $maxPeriksa = !empty($periksaCounts) ? max($periksaCounts) : 0;
        $maxIndex = array_search($maxPeriksa, $periksaCounts);
        $hariTertinggi = ($maxPeriksa > 0 && isset($shortLabels[$maxIndex])) ? $shortLabels[$maxIndex] . ' (' . $maxPeriksa . ')' : '-';

        return [
            'days' => $countDays,
            'labels' => $labels,
            'full_labels' => $shortLabels,
            'dates' => $dates,
            'periksa' => $periksaCounts,
            'pasien_baru' => $pasienBaruCounts,
            'total_periksa' => $totalPeriksa,
            'total_pasien_baru' => $totalPasien,
            'avg_periksa' => $avgPeriksa,
            'hari_tertinggi' => $hariTertinggi,
        ];
    }

    public function getTren7HariTerakhir()
    {
        return $this->getTrenPelayananData(7);
    }

    public function getTrenPelayananAll()
    {
        return [
            '7' => $this->getTrenPelayananData(7),
            '30' => $this->getTrenPelayananData(30),
        ];
    }

    public function getPasienPerOmahTerapiku()
    {
        $allUnits = Poli::orderBy('nama', 'asc')->get();
        
        $palette = [
            '#1e3a8a', // Deep Navy Blue
            '#2563eb', // Royal Blue
            '#3b82f6', // Brand Blue
            '#60a5fa', // Sky Blue
            '#38bdf8', // Cerulean
            '#0284c7', // Ocean Blue
            '#0369a1', // Dark Cyan Blue
            '#1d4ed8', // Sapphire
            '#93c5fd', // Light Blue
            '#0284c7'  // Steel Blue
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

    public function getDemografiPenerimaManfaat()
    {
        $pasienQuery = Pasien::whereNull('deleted_at');
        $totalPasien = (clone $pasienQuery)->count();

        // 1. Demografi Berdasarkan Kelompok Usia
        $usiaBalita = (clone $pasienQuery)->whereNotNull('tgl_lahir')->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) <= 5')->count();
        $usiaAnak = (clone $pasienQuery)->whereNotNull('tgl_lahir')->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 6 AND 12')->count();
        $usiaRemaja = (clone $pasienQuery)->whereNotNull('tgl_lahir')->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 13 AND 17')->count();
        $usiaDewasa = (clone $pasienQuery)->whereNotNull('tgl_lahir')->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 59')->count();
        $usiaLansia = (clone $pasienQuery)->whereNotNull('tgl_lahir')->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 60')->count();
        $usiaUnknown = (clone $pasienQuery)->whereNull('tgl_lahir')->count();

        // 2. Demografi Berdasarkan Jenis Kelamin
        $jkLaki = (clone $pasienQuery)->where(function($q) {
            $q->where('jk', 'L')->orWhere('jk', 'LIKE', 'Laki%');
        })->count();
        $jkPerempuan = (clone $pasienQuery)->where(function($q) {
            $q->where('jk', 'P')->orWhere('jk', 'LIKE', 'Perem%');
        })->count();
        $jkLainnya = max(0, $totalPasien - ($jkLaki + $jkPerempuan));

        // 3. Demografi Berdasarkan Jenis Disabilitas
        $disabilitasData = DB::table('pasien')
            ->select('jenis_disabilitas', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->whereNotNull('jenis_disabilitas')
            ->where('jenis_disabilitas', '!=', '')
            ->groupBy('jenis_disabilitas')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return [
            'total' => $totalPasien,
            'usia' => [
                'labels' => ['Balita (0-5 th)', 'Anak-Anak (6-12 th)', 'Remaja (13-17 th)', 'Dewasa (18-59 th)', 'Lansia (60+ th)'],
                'counts' => [$usiaBalita, $usiaAnak, $usiaRemaja, $usiaDewasa, $usiaLansia],
                'unknown' => $usiaUnknown,
                'colors' => ['#93c5fd', '#60a5fa', '#3b82f6', '#2563eb', '#1e40af']
            ],
            'jk' => [
                'laki' => $jkLaki,
                'perempuan' => $jkPerempuan,
                'lainnya' => $jkLainnya,
                'persen_laki' => $totalPasien > 0 ? round(($jkLaki / $totalPasien) * 100, 1) : 0,
                'persen_perempuan' => $totalPasien > 0 ? round(($jkPerempuan / $totalPasien) * 100, 1) : 0,
            ],
            'disabilitas' => $disabilitasData
        ];
    }

    public function getDistribusiJenisTerapi()
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';
        $dokterId = null;
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            $dokterId = $dokter ? $dokter->id : null;
        }

        $query = DB::table('rekam')
            ->when($dokterId, function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            });

        $this->scopeUpt($query);

        $results = (clone $query)
            ->select('layanan_terapi', DB::raw('count(*) as total'))
            ->whereNotNull('layanan_terapi')
            ->where('layanan_terapi', '!=', '')
            ->groupBy('layanan_terapi')
            ->orderBy('total', 'desc')
            ->get();

        $standardLayanan = [
            'Fisioterapi' => ['color' => '#1e40af', 'icon' => 'fa-person-walking'],
            'Terapi Okupasi / Sensorik Integrasi' => ['color' => '#2563eb', 'icon' => 'fa-hands'],
            'Terapi Wicara' => ['color' => '#38bdf8', 'icon' => 'fa-comments'],
            'Terapi Netra (Orientasi & Mobilitas)' => ['color' => '#60a5fa', 'icon' => 'fa-eye'],
        ];

        $palette = ['#1e40af', '#2563eb', '#38bdf8', '#60a5fa', '#0284c7', '#1d4ed8', '#93c5fd', '#0369a1'];

        $labels = [];
        $counts = [];
        $colors = [];
        $items = [];
        $totalSessions = 0;
        $colorIdx = 0;

        if ($results->count() > 0) {
            foreach ($results as $row) {
                $name = $row->layanan_terapi;
                $count = (int)$row->total;
                $totalSessions += $count;

                $color = isset($standardLayanan[$name]) ? $standardLayanan[$name]['color'] : $palette[$colorIdx % count($palette)];
                $icon = isset($standardLayanan[$name]) ? $standardLayanan[$name]['icon'] : 'fa-hand-holding-medical';
                $colorIdx++;

                $labels[] = $name;
                $counts[] = $count;
                $colors[] = $color;

                $items[] = [
                    'nama' => $name,
                    'total' => $count,
                    'color' => $color,
                    'icon' => $icon
                ];
            }
        } else {
            foreach ($standardLayanan as $name => $meta) {
                $labels[] = $name;
                $counts[] = 0;
                $colors[] = $meta['color'];
                $items[] = [
                    'nama' => $name,
                    'total' => 0,
                    'color' => $meta['color'],
                    'icon' => $meta['icon']
                ];
            }
        }

        foreach ($items as &$it) {
            $it['persentase'] = $totalSessions > 0 ? round(($it['total'] / $totalSessions) * 100, 1) : 0;
        }

        return [
            'labels' => $labels,
            'counts' => $counts,
            'colors' => $colors,
            'items' => $items,
            'total' => $totalSessions
        ];
    }

    public function getTopTindakanTerbanyak($limit = 5, $periode = 'bulan')
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';
        $dokterId = null;
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            $dokterId = $dokter ? $dokter->id : null;
        }

        $query = DB::table('rekam')
            ->select('tindakan', DB::raw('count(*) as total'))
            ->when($dokterId, function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            })
            ->whereNotNull('tindakan')
            ->where('tindakan', '!=', '')
            ->where('tindakan', 'NOT LIKE', '%Belum ada catatan%');

        if (session()->has('selected_upt') && session('selected_upt') != '') {
            $upt = session('selected_upt');
            $query->where(function($q) use ($upt) {
                $q->where('rekam.poli', 'LIKE', "%{$upt}%")
                  ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
            });
        }

        if ($periode === 'bulan') {
            $query->whereYear('tgl_rekam', date('Y'))
                  ->whereMonth('tgl_rekam', date('m'));
        } elseif ($periode === 'tahun') {
            $query->whereYear('tgl_rekam', date('Y'));
        }

        $rekamTindakan = $query->groupBy('tindakan')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();

        $items = [];
        $totalTindakan = 0;
        $palette = ['#1e40af', '#2563eb', '#3b82f6', '#60a5fa', '#38bdf8', '#0284c7'];
        $idx = 0;

        foreach ($rekamTindakan as $row) {
            $namaTindakan = trim(strip_tags($row->tindakan));
            if (strlen($namaTindakan) > 55) {
                $namaTindakan = substr($namaTindakan, 0, 52) . '...';
            }
            $count = (int)$row->total;
            $totalTindakan += $count;

            $items[] = [
                'nama' => $namaTindakan,
                'total' => $count,
                'color' => $palette[$idx % count($palette)]
            ];
            $idx++;
        }

        $maxCount = !empty($items) ? max(array_column($items, 'total')) : 0;
        foreach ($items as &$it) {
            $it['persentase'] = $totalTindakan > 0 ? round(($it['total'] / $totalTindakan) * 100, 1) : 0;
            $it['bar_persen'] = $maxCount > 0 ? round(($it['total'] / $maxCount) * 100, 1) : ($it['total'] > 0 ? 100 : 5);
        }

        return [
            'items' => $items,
            'total' => $totalTindakan,
            'labels' => array_column($items, 'nama'),
            'counts' => array_column($items, 'total'),
            'colors' => array_column($items, 'color')
        ];
    }

    public function getTopTindakanAll($limit = 5)
    {
        return [
            'bulan' => $this->getTopTindakanTerbanyak($limit, 'bulan'),
            'tahun' => $this->getTopTindakanTerbanyak($limit, 'tahun'),
            'semua' => $this->getTopTindakanTerbanyak($limit, 'semua')
        ];
    }

    public function getRecentTherapistActivities($limit = 10)
    {
        $user = auth()->user();
        $role = $user ? $user->role_display() : '';
        $dokterId = null;
        if ($role == "Dokter") {
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            $dokterId = $dokter ? $dokter->id : null;
        }

        $query = Rekam::with(['pasien', 'dokter', 'assessment', 'terapisPendamping'])
            ->whereNotNull('pasien_id')
            ->when($dokterId, function ($q) use ($dokterId) {
                $q->where(function($sq) use ($dokterId) {
                    $sq->where('dokter_id', $dokterId)
                       ->orWhere('terapis_pendamping_id', $dokterId);
                });
            });

        $this->scopeUpt($query);

        $recentRecords = $query->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();

        $activities = [];
        foreach ($recentRecords as $rekam) {
            $pasienName = $rekam->pasien->nama ?? 'Penerima Manfaat';
            $pasienRm = $rekam->pasien->no_rm ?? '-';
            $pasienId = $rekam->pasien_id;
            $dokterName = $rekam->dokter->nama ?? 'Terapis';
            $layanan = $rekam->layanan_terapi ?: ($rekam->poli ?: 'Terapi');
            $upt = $rekam->upt_lokasi ?: ($rekam->poli ?: 'Omah Terapiku');
            $waktu = $rekam->updated_at ? $rekam->updated_at->diffForHumans() : ($rekam->created_at ? $rekam->created_at->diffForHumans() : '-');
            $timestamp = $rekam->updated_at ? $rekam->updated_at->format('d M Y, H:i') : ($rekam->created_at ? $rekam->created_at->format('d M Y, H:i') : '-');

            // Deteksi jenis aktivitas & konten ringkas
            $activityType = 'sesi';
            $actionTitle = 'Sesi Terapi';
            $badgeColor = '#2563eb';
            $badgeBg = '#eff6ff';
            $icon = 'fa-user-md';
            $snippet = '';

            if ($rekam->status == 4 || $rekam->status == 5) {
                $activityType = 'selesai';
                $actionTitle = 'Sesi Selesai';
                $badgeColor = '#10b981';
                $badgeBg = '#ecfdf5';
                $icon = 'fa-circle-check';
                if (!empty($rekam->tindakan) && $rekam->tindakan !== 'Belum ada catatan rencana/tindakan') {
                    $snippet = 'Tindakan: ' . trim(html_entity_decode(strip_tags($rekam->tindakan)));
                } else {
                    $snippet = 'Pelayanan terapi telah diselesaikan dan diverifikasi.';
                }
            } elseif ($rekam->assessment) {
                $activityType = 'assessment';
                $actionTitle = 'Asesmen 15 Modul';
                $badgeColor = '#1e40af';
                $badgeBg = '#eff6ff';
                $icon = 'fa-clipboard-list';
                $kelengkapan = $rekam->assessment->kelengkapan ?? 0;
                $diag = $rekam->assessment->diagnosa_medis ? ' (' . $rekam->assessment->diagnosa_medis . ')' : '';
                $snippet = 'Form Asesmen Klinis terisi ' . $kelengkapan . '%' . $diag;
            } elseif (!empty($rekam->tindakan) && $rekam->tindakan !== 'Belum ada catatan rencana/tindakan') {
                $activityType = 'tindakan';
                $actionTitle = 'Tindakan / Intervensi';
                $badgeColor = '#0284c7';
                $badgeBg = '#e0f2fe';
                $icon = 'fa-hand-holding-medical';
                $snippet = trim(html_entity_decode(strip_tags($rekam->tindakan)));
            } elseif (!empty($rekam->pemeriksaan) && $rekam->pemeriksaan !== 'Belum ada data pemeriksaan fisik') {
                $activityType = 'pemeriksaan';
                $actionTitle = 'Pemeriksaan Fisik';
                $badgeColor = '#3b82f6';
                $badgeBg = '#eff6ff';
                $icon = 'fa-stethoscope';
                $snippet = trim(html_entity_decode(strip_tags($rekam->pemeriksaan)));
            } else {
                $activityType = 'registrasi';
                $actionTitle = 'Pendaftaran Sesi';
                $badgeColor = '#f59e0b';
                $badgeBg = '#fef3c7';
                $icon = 'fa-notes-medical';
                $snippet = !empty($rekam->keluhan) ? 'Keluhan: ' . trim(html_entity_decode(strip_tags($rekam->keluhan))) : 'Sesi pelayanan telah dibuat dan dalam antrian.';
            }

            if (strlen($snippet) > 120) {
                $snippet = substr($snippet, 0, 117) . '...';
            }

            // Inisial Terapis
            $cleanName = preg_replace('/[^a-zA-Z]/', '', $dokterName);
            $initial = strtoupper(substr($cleanName ?: 'TP', 0, 2));

            $activities[] = [
                'id' => $rekam->id,
                'pasien_id' => $pasienId,
                'pasien_nama' => $pasienName,
                'pasien_rm' => $pasienRm,
                'dokter_nama' => $dokterName,
                'dokter_initial' => $initial,
                'layanan' => $layanan,
                'upt' => $upt,
                'activity_type' => $activityType,
                'action_title' => $actionTitle,
                'badge_color' => $badgeColor,
                'badge_bg' => $badgeBg,
                'icon' => $icon,
                'snippet' => $snippet,
                'waktu' => $waktu,
                'timestamp' => $timestamp,
                'status' => $rekam->status,
                'status_display' => $rekam->status_display(),
                'detail_url' => route('rekam.detail', $pasienId)
            ];
        }

        return $activities;
    }
}