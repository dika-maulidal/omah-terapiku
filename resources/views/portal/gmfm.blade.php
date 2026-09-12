@extends('portal.layout.apps')

@section('title', 'Gross Motor (GMFM)')

@section('style')
<style>
    .gmfm-dim-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .gmfm-dim-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(46, 75, 130, 0.08);
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Header Banner (Unified White Card - DESIGN.md Section 1 & 3) -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 20px; border: 1px solid #bfdbfe; border-radius: 10px;">
                        <i class="fa-solid fa-child-reaching"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Gross Motor Function Measure (GMFM)
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Pengukuran evaluasi fungsi motorik kasar Dimensi A sampai E
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($latestAssessment && $latestAssessment->gmfm_total_persen !== null)
        <!-- Total Skor GMFM Banner -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: white; border-radius: 12px; box-shadow: 0 6px 20px rgba(37, 99, 235, 0.22);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                            <span class="badge badge-light text-primary font-w700 text-uppercase mb-2 px-3 py-1" style="font-size: 11px; border-radius: 6px;">
                                Capaian Evaluasi Terakhir &bull; {{ $latestAssessment->tgl_assessment ? \Carbon\Carbon::parse($latestAssessment->tgl_assessment)->isoFormat('D MMMM Y') : '-' }}
                            </span>
                            <h3 class="text-white font-w800 mb-1" style="font-size: 24px;">
                                Total Skor Capaian: {{ $latestAssessment->gmfm_total_persen }}%
                            </h3>
                            <p class="text-white-50 mb-0" style="font-size: 13px;">
                                <i class="fa-solid fa-user-doctor mr-1"></i> Terapis Pemeriksa: <strong class="text-white">{{ $latestAssessment->dokter ? $latestAssessment->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-12 text-lg-right">
                            <div class="d-inline-block bg-white text-dark p-3 rounded text-center shadow-sm" style="min-width: 140px; border-radius: 10px !important;">
                                <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;">Total Nilai</div>
                                <div class="text-primary font-w800" style="font-size: 26px;">{{ $latestAssessment->gmfm_total_persen }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5 Dimensi GMFM Cards -->
        @php
            $dimensions = [
                'a' => [
                    'code' => 'A',
                    'title' => 'Dimensi A: Terlentang & Berguling',
                    'sub' => 'Lying & Rolling (17 Task)',
                    'total' => $latestAssessment->gmfm_dimensi_a_total,
                    'persen' => $latestAssessment->gmfm_dimensi_a_persen,
                    'catatan' => $latestAssessment->gmfm_dimensi_a_catatan,
                    'icon' => 'fa-bed',
                    'color' => '#2563eb',
                    'bg' => '#eff6ff',
                    'border' => '#bfdbfe'
                ],
                'b' => [
                    'code' => 'B',
                    'title' => 'Dimensi B: Posisi Duduk',
                    'sub' => 'Sitting (20 Task)',
                    'total' => $latestAssessment->gmfm_dimensi_b_total,
                    'persen' => $latestAssessment->gmfm_dimensi_b_persen,
                    'catatan' => $latestAssessment->gmfm_dimensi_b_catatan,
                    'icon' => 'fa-chair',
                    'color' => '#0284c7',
                    'bg' => '#e0f2fe',
                    'border' => '#bae6fd'
                ],
                'c' => [
                    'code' => 'C',
                    'title' => 'Dimensi C: Merangkak & Berlutut',
                    'sub' => 'Crawling & Kneeling (14 Task)',
                    'total' => $latestAssessment->gmfm_dimensi_c_total,
                    'persen' => $latestAssessment->gmfm_dimensi_c_persen,
                    'catatan' => $latestAssessment->gmfm_dimensi_c_catatan,
                    'icon' => 'fa-person-booth',
                    'color' => '#10b981',
                    'bg' => '#ecfdf5',
                    'border' => '#a7f3d0'
                ],
                'd' => [
                    'code' => 'D',
                    'title' => 'Dimensi D: Posisi Berdiri',
                    'sub' => 'Standing (13 Task)',
                    'total' => $latestAssessment->gmfm_dimensi_d_total,
                    'persen' => $latestAssessment->gmfm_dimensi_d_persen,
                    'catatan' => $latestAssessment->gmfm_dimensi_d_catatan,
                    'icon' => 'fa-person',
                    'color' => '#f59e0b',
                    'bg' => '#fffbeb',
                    'border' => '#fde68a'
                ],
                'e' => [
                    'code' => 'E',
                    'title' => 'Dimensi E: Berjalan, Berlari & Melompat',
                    'sub' => 'Walking, Running & Jumping (24 Task)',
                    'total' => $latestAssessment->gmfm_dimensi_e_total,
                    'persen' => $latestAssessment->gmfm_dimensi_e_persen,
                    'catatan' => $latestAssessment->gmfm_dimensi_e_catatan,
                    'icon' => 'fa-person-walking',
                    'color' => '#6366f1',
                    'bg' => '#e0e7ff',
                    'border' => '#c7d2fe'
                ],
            ];
        @endphp

        @foreach($dimensions as $dim)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="gmfm-dim-card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                        <h4 class="card-title font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 15.5px;">
                            <span class="mr-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px; background: {{ $dim['bg'] }}; color: {{ $dim['color'] }}; border: 1px solid {{ $dim['border'] }}; font-size: 14px;">
                                <i class="fa-solid {{ $dim['icon'] }}"></i>
                            </span>
                            <span>{{ $dim['title'] }}</span>
                        </h4>
                        <span class="badge font-w700" style="font-size: 13px; background: {{ $dim['bg'] }}; color: {{ $dim['color'] }}; border: 1px solid {{ $dim['border'] }}; border-radius: 6px; padding: 4px 10px;">
                            {{ $dim['persen'] !== null ? $dim['persen'] . '%' : '-' }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-muted mb-2" style="font-size: 12px;">{{ $dim['sub'] }}</div>
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-3" style="height: 10px; border-radius: 5px; background: #f1f5f9;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $dim['persen'] ?? 0 }}%; background: {{ $dim['color'] }}; border-radius: 5px;" 
                                 aria-valuenow="{{ $dim['persen'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-muted font-w600 mb-3" style="font-size: 12.5px;">
                            <span>Skor Nilai: <strong class="text-dark">{{ $dim['total'] ?? '-' }}</strong></span>
                            <span>Capaian: <strong style="color: {{ $dim['color'] }};">{{ $dim['persen'] !== null ? $dim['persen'] . '%' : '-' }}</strong></span>
                        </div>

                        @if($dim['catatan'])
                            <div class="p-3 rounded" style="font-size: 12.5px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid {{ $dim['color'] }}; color: #475569;">
                                <strong><i class="fa-solid fa-comment-dots mr-1" style="color: {{ $dim['color'] }};"></i> Catatan Terapis:</strong> {{ $dim['catatan'] }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    @else
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05); background: #ffffff;">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 28px; margin: 0 auto; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <h4 class="text-dark font-w700 mb-2" style="font-size: 18px;">Belum Ada Catatan GMFM</h4>
                <p class="text-muted mb-4" style="max-width: 440px; margin: 0 auto; font-size: 13.5px; line-height: 1.5;">
                    Penerima manfaat ini belum memiliki data pengukuran Gross Motor Function Measure (GMFM) yang direkam oleh terapis.
                </p>
                <div>
                    <a href="{{ route('portal.dashboard') }}" class="btn btn-primary font-w700" style="border-radius: 8px; padding: 9px 20px;">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
