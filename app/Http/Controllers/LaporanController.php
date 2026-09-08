<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Rekam;
use App\Models\Tindakan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Helper to parse filter parameters into date ranges and metadata
     */
    protected function getFilterMetadata(Request $request)
    {
        $tipe = $request->get('tipe_periode', 'bulanan');
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = (int) $request->get('bulan', date('n'));
        $triwulan = (int) $request->get('triwulan', ceil(date('n') / 3));
        $semester = (int) $request->get('semester', date('n') <= 6 ? 1 : 2);
        $tglAwal = $request->get('tgl_awal');
        $tglAkhir = $request->get('tgl_akhir');
        $upt = $request->get('upt', 'all');
        $layanan = $request->get('layanan', 'all');

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        switch ($tipe) {
            case 'tahunan':
                $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
                $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
                $periodeText = "Tahun Anggaran {$tahun}";
                break;

            case 'triwulan':
                $startMonth = ($triwulan - 1) * 3 + 1;
                $endMonth = $triwulan * 3;
                $startDate = Carbon::createFromDate($tahun, $startMonth, 1)->startOfDay();
                $endDate = Carbon::createFromDate($tahun, $endMonth, 1)->endOfMonth()->endOfDay();
                $periodeText = "Triwulan {$triwulan} ({$namaBulan[$startMonth]} - {$namaBulan[$endMonth]} {$tahun})";
                break;

            case 'semester':
                $startMonth = ($semester == 1) ? 1 : 7;
                $endMonth = ($semester == 1) ? 6 : 12;
                $startDate = Carbon::createFromDate($tahun, $startMonth, 1)->startOfDay();
                $endDate = Carbon::createFromDate($tahun, $endMonth, 1)->endOfMonth()->endOfDay();
                $periodeText = "Semester {$semester} ({$namaBulan[$startMonth]} - {$namaBulan[$endMonth]} {$tahun})";
                break;

            case 'custom':
                if ($tglAwal && $tglAkhir) {
                    $startDate = Carbon::parse($tglAwal)->startOfDay();
                    $endDate = Carbon::parse($tglAkhir)->endOfDay();
                    $periodeText = Carbon::parse($tglAwal)->format('d/m/Y') . " s.d. " . Carbon::parse($tglAkhir)->format('d/m/Y');
                } else {
                    $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
                    $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->endOfDay();
                    $periodeText = "Bulan {$namaBulan[$bulan]} {$tahun}";
                }
                break;

            case 'bulanan':
            default:
                $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
                $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->endOfDay();
                $periodeText = "Bulan {$namaBulan[$bulan]} {$tahun}";
                break;
        }

        $uptText = ($upt === 'all' || empty($upt))
            ? 'Seluruh Unit Pelaksana Teknis (Konsolidasi Provinsi Jawa Timur)'
            : $upt;

        $layananText = ($layanan === 'all' || empty($layanan))
            ? 'Semua Ragam Layanan Terapi'
            : $layanan;

        return [
            'tipe' => $tipe,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'triwulan' => $triwulan,
            'semester' => $semester,
            'tgl_awal' => $startDate->format('Y-m-d'),
            'tgl_akhir' => $endDate->format('Y-m-d'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'upt' => $upt,
            'layanan' => $layanan,
            'periode_text' => $periodeText,
            'upt_text' => $uptText,
            'layanan_text' => $layananText,
            'nama_bulan' => $namaBulan
        ];
    }

    /**
     * Compute full statistical datasets for the given date range & filter
     */
    protected function computeReportData($meta)
    {
        $startDate = $meta['start_date'];
        $endDate = $meta['end_date'];
        $upt = $meta['upt'];
        $layanan = $meta['layanan'];

        // Base Query Rekam
        $rekamQuery = Rekam::query()
            ->whereBetween('tgl_rekam', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($upt !== 'all' && !empty($upt), function ($q) use ($upt) {
                $q->where(function ($sub) use ($upt) {
                    $sub->where('rekam.poli', 'LIKE', "%{$upt}%")
                        ->orWhere('rekam.upt_lokasi', 'LIKE', "%{$upt}%");
                });
            })
            ->when($layanan !== 'all' && !empty($layanan), function ($q) use ($layanan) {
                $q->where('rekam.layanan_terapi', 'LIKE', "%{$layanan}%");
            });

        // 1. Total Sesi / Kunjungan
        $totalSesi = (clone $rekamQuery)->count();
        $totalSesiSelesai = (clone $rekamQuery)->where('status', 4)->count();
        $totalSesiProses = (clone $rekamQuery)->whereIn('status', [1, 2, 3])->count();
        $totalPasienTerlayani = (clone $rekamQuery)->distinct('pasien_id')->count('pasien_id');

        // Total Penerima Manfaat Baru Terdaftar dalam Periode
        $pasienBaruQuery = Pasien::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($upt !== 'all' && !empty($upt), function ($q) use ($upt) {
                $q->where('upt_lokasi', 'LIKE', "%{$upt}%");
            });
        $totalPasienBaru = $pasienBaruQuery->count();

        // Total Kumulatif Penerima Manfaat Terdaftar
        $totalPasienKumulatif = Pasien::query()
            ->when($upt !== 'all' && !empty($upt), function ($q) use ($upt) {
                $q->where('upt_lokasi', 'LIKE', "%{$upt}%");
            })->count();

        // Hitung Jumlah Hari Operasional Rabu dalam Periode
        $rabuCount = 0;
        $tempDate = $startDate->copy();
        while ($tempDate->lte($endDate)) {
            if ($tempDate->dayOfWeek === Carbon::WEDNESDAY) {
                $rabuCount++;
            }
            $tempDate->addDay();
        }
        $avgSesiPerRabu = $rabuCount > 0 ? round($totalSesi / $rabuCount, 1) : $totalSesi;

        // 2. Rekap Distribusi Desil DTKS / DTSEN (Ketepatan Sasaran Bansos)
        $rekamPasienIds = (clone $rekamQuery)->pluck('pasien_id')->unique()->toArray();
        $desilBreakdown = [
            'Desil 1' => 0,
            'Desil 2' => 0,
            'Desil 3' => 0,
            'Desil 4' => 0,
            'Desil 5' => 0,
            'Non-Desil / Belum Terdata' => 0,
        ];
        
        if (count($rekamPasienIds) > 0) {
            $pasienDesil = Pasien::whereIn('id', $rekamPasienIds)
                ->select('desil', DB::raw('count(*) as total'))
                ->groupBy('desil')
                ->get();

            foreach ($pasienDesil as $pd) {
                $d = trim((string)$pd->desil);
                if ($d === '1' || str_contains($d, '1')) {
                    $desilBreakdown['Desil 1'] += $pd->total;
                } elseif ($d === '2' || str_contains($d, '2')) {
                    $desilBreakdown['Desil 2'] += $pd->total;
                } elseif ($d === '3' || str_contains($d, '3')) {
                    $desilBreakdown['Desil 3'] += $pd->total;
                } elseif ($d === '4' || str_contains($d, '4')) {
                    $desilBreakdown['Desil 4'] += $pd->total;
                } elseif ($d === '5' || str_contains($d, '5')) {
                    $desilBreakdown['Desil 5'] += $pd->total;
                } else {
                    $desilBreakdown['Non-Desil / Belum Terdata'] += $pd->total;
                }
            }
        }

        // 3. Rekap Jenis Layanan Terapi
        $layananBreakdown = (clone $rekamQuery)
            ->select('layanan_terapi', DB::raw('count(*) as total'))
            ->whereNotNull('layanan_terapi')
            ->where('layanan_terapi', '!=', '')
            ->groupBy('layanan_terapi')
            ->orderBy('total', 'desc')
            ->get();

        // 4. Rekap Kelompok Usia & Gender dari Pasien yang Dilayani
        $demografi = [
            'anak' => 0,      // < 18 tahun (ABK)
            'dewasa' => 0,    // 18 - 59 tahun
            'lansia' => 0,    // >= 60 tahun
            'laki' => 0,
            'perempuan' => 0
        ];

        if (count($rekamPasienIds) > 0) {
            $pasiens = Pasien::whereIn('id', $rekamPasienIds)->get();
            foreach ($pasiens as $p) {
                // Gender
                if (strtolower($p->jk) == 'laki-laki' || strtolower($p->jk) == 'l') {
                    $demografi['laki']++;
                } else {
                    $demografi['perempuan']++;
                }

                // Usia
                if ($p->tgl_lahir) {
                    try {
                        $age = Carbon::parse($p->tgl_lahir)->age;
                        if ($age < 18) {
                            $demografi['anak']++;
                        } elseif ($age >= 60) {
                            $demografi['lansia']++;
                        } else {
                            $demografi['dewasa']++;
                        }
                    } catch (\Exception $e) {
                        $demografi['dewasa']++;
                    }
                } else {
                    $demografi['dewasa']++;
                }
            }
        }

        // 5. Rekap Ragam Disabilitas
        $disabilitasBreakdown = [];
        if (count($rekamPasienIds) > 0) {
            $rawDisabilitas = Pasien::whereIn('id', $rekamPasienIds)
                ->whereNotNull('jenis_disabilitas')
                ->where('jenis_disabilitas', '!=', '')
                ->pluck('jenis_disabilitas');

            foreach ($rawDisabilitas as $dis) {
                // Bisa comma-separated
                $items = explode(',', $dis);
                foreach ($items as $item) {
                    $clean = trim($item);
                    if ($clean) {
                        if (!isset($disabilitasBreakdown[$clean])) {
                            $disabilitasBreakdown[$clean] = 0;
                        }
                        $disabilitasBreakdown[$clean]++;
                    }
                }
            }
            arsort($disabilitasBreakdown);
        }

        // 5b. Rekap Sebaran Geografis Asal Pasien (Kabupaten / Kota)
        $wilayahBreakdown = [];
        if (count($rekamPasienIds) > 0) {
            $pasienWilayah = Pasien::whereIn('id', $rekamPasienIds)
                ->select('kabupaten', DB::raw('count(*) as total'))
                ->groupBy('kabupaten')
                ->orderBy('total', 'desc')
                ->get();

            foreach ($pasienWilayah as $pw) {
                $rawKab = trim((string)$pw->kabupaten);
                if (empty($rawKab) || $rawKab === '-' || strtolower($rawKab) === 'null') {
                    $kabLabel = 'Belum Terdata / Luar Wilayah';
                } else {
                    $kabLabel = $rawKab;
                }
                if (!isset($wilayahBreakdown[$kabLabel])) {
                    $wilayahBreakdown[$kabLabel] = 0;
                }
                $wilayahBreakdown[$kabLabel] += $pw->total;
            }
            arsort($wilayahBreakdown);
        }

        // 5c. Koordinat Wilayah Jawa Timur & Titik Balai untuk Peta Interaktif
        $coordsJatim = [
            'sidoarjo' => ['lat' => -7.4478, 'lng' => 112.7183],
            'surabaya' => ['lat' => -7.2575, 'lng' => 112.7521],
            'malang' => ['lat' => -7.9666, 'lng' => 112.6326],
            'pasuruan' => ['lat' => -7.6453, 'lng' => 112.9075],
            'mojokerto' => ['lat' => -7.4722, 'lng' => 112.4384],
            'gresik' => ['lat' => -7.1566, 'lng' => 112.6555],
            'jombang' => ['lat' => -7.5468, 'lng' => 112.2331],
            'lamongan' => ['lat' => -7.1206, 'lng' => 112.4158],
            'probolinggo' => ['lat' => -7.7543, 'lng' => 113.2159],
            'lumajang' => ['lat' => -8.1331, 'lng' => 113.2248],
            'jember' => ['lat' => -8.1724, 'lng' => 113.7007],
            'banyuwangi' => ['lat' => -8.2192, 'lng' => 114.3692],
            'bondowoso' => ['lat' => -7.9135, 'lng' => 113.8214],
            'situbondo' => ['lat' => -7.7061, 'lng' => 114.0097],
            'kediri' => ['lat' => -7.8480, 'lng' => 112.0178],
            'blitar' => ['lat' => -8.0983, 'lng' => 112.1681],
            'tulungagung' => ['lat' => -8.0667, 'lng' => 111.9000],
            'trenggalek' => ['lat' => -8.0500, 'lng' => 111.7167],
            'nganjuk' => ['lat' => -7.6049, 'lng' => 111.9042],
            'madiun' => ['lat' => -7.6298, 'lng' => 111.5239],
            'ponorogo' => ['lat' => -7.8692, 'lng' => 111.4623],
            'magetan' => ['lat' => -7.6536, 'lng' => 111.3283],
            'ngawi' => ['lat' => -7.4039, 'lng' => 111.4455],
            'bojonegoro' => ['lat' => -7.1502, 'lng' => 111.8817],
            'tuban' => ['lat' => -6.8976, 'lng' => 112.0649],
            'bangkalan' => ['lat' => -7.0455, 'lng' => 112.7388],
            'sampang' => ['lat' => -7.1873, 'lng' => 113.2394],
            'pamekasan' => ['lat' => -7.1605, 'lng' => 113.4746],
            'sumenep' => ['lat' => -7.0167, 'lng' => 113.8667],
            'pacitan' => ['lat' => -8.2064, 'lng' => 111.0939],
            'batu' => ['lat' => -7.8712, 'lng' => 112.5270],
        ];

        $mapBalaiPoints = [
            [
                'nama' => 'UPT PPSAB Sidoarjo',
                'lat' => -7.4526,
                'lng' => 112.7135,
                'alamat' => 'Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo',
                'fokus' => 'Anak Berkebutuhan Khusus (ABK)',
                'badge' => 'Balai Pelayanan ABK'
            ],
            [
                'nama' => 'Balai PRS PMKS Sidoarjo',
                'lat' => -7.4530,
                'lng' => 112.7160,
                'alamat' => 'Jl. Pahlawan No. 5, Sidokumpul, Sidoarjo',
                'fokus' => 'Dewasa, Lansia, ODGJ, Pasca-Stroke',
                'badge' => 'Balai Pelayanan PMKS'
            ],
            [
                'nama' => 'UPT RSBN Malang',
                'lat' => -8.0080,
                'lng' => 112.6320,
                'alamat' => 'Jl. Beringin No. 13, Bandungrejosari, Sukun, Malang',
                'fokus' => 'Disabilitas Netra & Fisioterapi Olahraga',
                'badge' => 'Balai Disabilitas Netra'
            ]
        ];

        $mapPatientPoints = [];
        $totalPasienWilayah = array_sum($wilayahBreakdown);
        foreach ($wilayahBreakdown as $kabName => $total) {
            $key = strtolower(trim($kabName));
            $foundCoords = null;
            foreach ($coordsJatim as $k => $c) {
                if (str_contains($key, $k)) {
                    $foundCoords = $c;
                    break;
                }
            }
            if ($foundCoords) {
                $pct = $totalPasienWilayah > 0 ? round(($total / $totalPasienWilayah) * 100, 1) : 0;
                $mapPatientPoints[] = [
                    'nama' => $kabName,
                    'lat' => $foundCoords['lat'],
                    'lng' => $foundCoords['lng'],
                    'total' => $total,
                    'percentage' => $pct,
                ];
            }
        }

        // 6. Rekapitulasi per Lokasi UPT Omah Terapi-KU
        $allUpts = Poli::orderBy('nama', 'asc')->get();
        $uptRekap = [];
        foreach ($allUpts as $u) {
            $sesiUpt = Rekam::whereBetween('tgl_rekam', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->where(function ($q) use ($u) {
                    $q->where('poli', 'LIKE', "%{$u->nama}%")
                      ->orWhere('upt_lokasi', 'LIKE', "%{$u->nama}%");
                });

            $totalSesiUpt = (clone $sesiUpt)->count();
            $selesaiUpt = (clone $sesiUpt)->where('status', 4)->count();
            $pasienUpt = (clone $sesiUpt)->distinct('pasien_id')->count('pasien_id');
            $terapisCount = Dokter::where('poli', 'LIKE', "%{$u->nama}%")->where('status', 1)->count();

            $uptRekap[] = [
                'nama' => $u->nama,
                'alamat' => $u->alamat ?: '-',
                'no_telp' => $u->no_telp ?: '-',
                'fokus' => $u->fokus_layanan ?: 'Pelayanan Terpadu',
                'total_sesi' => $totalSesiUpt,
                'selesai_sesi' => $selesaiUpt,
                'total_pasien' => $pasienUpt,
                'total_terapis' => $terapisCount,
            ];
        }

        // 7. Rekap Kinerja Terapis
        $terapisRekap = Dokter::where('status', 1)->get()->map(function ($terapis) use ($startDate, $endDate) {
            $sesiQuery = Rekam::whereBetween('tgl_rekam', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->where(function ($q) use ($terapis) {
                    $q->where('dokter_id', $terapis->id)
                      ->orWhere('terapis_pendamping_id', $terapis->id);
                });

            $totalSesi = (clone $sesiQuery)->count();
            $selesai = (clone $sesiQuery)->where('status', 4)->count();
            $pasienUnik = (clone $sesiQuery)->distinct('pasien_id')->count('pasien_id');

            return [
                'nama' => $terapis->nama,
                'nip' => $terapis->nip ?? ($terapis->user->nip ?? '-'),
                'penempatan' => $terapis->poli ?: '-',
                'no_hp' => $terapis->no_hp ?: '-',
                'total_sesi' => $totalSesi,
                'selesai' => $selesai,
                'pasien_unik' => $pasienUnik,
            ];
        })->sortByDesc('total_sesi')->values();

        // 8. Top Tindakan Terbanyak
        $topTindakan = (clone $rekamQuery)
            ->select('tindakan', DB::raw('count(*) as total'))
            ->whereNotNull('tindakan')
            ->where('tindakan', '!=', '')
            ->groupBy('tindakan')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();

        // 9. Daftar Sesi Rekam Medis (Sample Log Terbaru untuk lampiran)
        $daftarSesi = (clone $rekamQuery)
            ->with(['pasien', 'dokter', 'terapisPendamping'])
            ->orderBy('tgl_rekam', 'desc')
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        return [
            'total_sesi' => $totalSesi,
            'total_sesi_selesai' => $totalSesiSelesai,
            'total_sesi_proses' => $totalSesiProses,
            'total_pasien_terlayani' => $totalPasienTerlayani,
            'total_pasien_baru' => $totalPasienBaru,
            'total_pasien_kumulatif' => $totalPasienKumulatif,
            'rabu_count' => $rabuCount,
            'avg_sesi_per_rabu' => $avgSesiPerRabu,
            'desil_breakdown' => $desilBreakdown,
            'layanan_breakdown' => $layananBreakdown,
            'demografi' => $demografi,
            'disabilitas_breakdown' => $disabilitasBreakdown,
            'upt_rekap' => $uptRekap,
            'terapis_rekap' => $terapisRekap,
            'top_tindakan' => $topTindakan,
            'wilayah_breakdown' => $wilayahBreakdown,
            'map_patient_points' => $mapPatientPoints,
            'map_balai_points' => $mapBalaiPoints,
            'daftar_sesi' => $daftarSesi,
        ];
    }

    /**
     * Tampilan Web Interactive Executive Dashboard & Rekap Statistik
     */
    public function index(Request $request)
    {
        $meta = $this->getFilterMetadata($request);
        $data = $this->computeReportData($meta);
        $allUpts = Poli::where('status', 1)->orderBy('nama', 'asc')->get();
        $availableYears = range(date('Y'), date('Y') - 4);

        return view('laporan.index', compact('meta', 'data', 'allUpts', 'availableYears'));
    }

    /**
     * Tampilan Cetak / Export PDF Resmi (Format Standar Dinas Sosial Pemprov Jatim)
     */
    public function printPdf(Request $request)
    {
        $meta = $this->getFilterMetadata($request);
        $data = $this->computeReportData($meta);
        
        // Logo Base64
        $logoOmahPath = public_path('images/logo.png');
        if (!file_exists($logoOmahPath)) {
            $logoOmahPath = public_path('images/logo-blue.png');
        }
        $logoOmahBase64 = file_exists($logoOmahPath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoOmahPath))
            : asset('images/logo.png');

        $logoDinsosPath = public_path('images/logo-dinsos.png');
        if (!file_exists($logoDinsosPath)) {
            $logoDinsosPath = public_path('images/dinsos.png');
        }
        $logoDinsosBase64 = file_exists($logoDinsosPath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoDinsosPath))
            : asset('images/logo-dinsos.png');

        $tglCetakFormatted = Carbon::now()->translatedFormat('d F Y');

        return view('laporan.print-pdf', compact('meta', 'data', 'logoOmahBase64', 'logoDinsosBase64', 'tglCetakFormatted'));
    }
}
