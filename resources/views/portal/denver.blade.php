@extends('portal.layout.apps')

@section('title', 'Skala Perkembangan Denver II')

@section('style')
<style>
    .denver-stat-box {
        border-radius: 10px;
        padding: 14px 18px;
        text-align: center;
        min-width: 100px;
        transition: transform 0.2s ease;
    }
    .denver-stat-box:hover {
        transform: translateY(-2px);
    }
    .denver-task-table th {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #475569;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 11px 18px;
    }
    .denver-task-table td {
        padding: 11px 18px;
        vertical-align: middle;
    }
    .denver-task-table tr:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }
    .score-badge {
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
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
                        <i class="fa-solid fa-baby"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-0" style="color: var(--ot-navy, #1e40af) !important; font-size: 21px;">
                            Skala Perkembangan Denver II (DDST II)
                        </h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                            Skrining pencapaian 4 sektor tumbuh kembang anak sesuai kelompok usianya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($latestAssessment)
        @php
            $denverData = is_array($latestAssessment->denver_data) ? $latestAssessment->denver_data : [];
            $passCount = $latestAssessment->denver_pass_count ?? 0;
            $failCount = $latestAssessment->denver_fail_count ?? 0;
            $refusalCount = $latestAssessment->denver_refusal_count ?? 0;
            $noCount = $latestAssessment->denver_no_count ?? 0;
            $kesimpulan = $latestAssessment->denver_kesimpulan ?: 'Belum Dinilai';
        @endphp

        <!-- Ringkasan Kesimpulan Skrining Denver -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 pr-lg-4">
                            <div class="text-muted font-w600 d-flex align-items-center mb-2" style="font-size: 13px;">
                                <i class="fa-regular fa-calendar-check mr-2 text-primary" style="font-size: 14.5px;"></i>
                                <span>Tanggal Asesmen:</span>
                                <strong class="text-dark ml-2">{{ $latestAssessment->tgl_assessment ? \Carbon\Carbon::parse($latestAssessment->tgl_assessment)->isoFormat('D MMMM Y') : '-' }}</strong>
                            </div>
                            <h4 class="font-w700 text-dark mb-2.5 mt-2" style="font-size: 17px;">
                                Kesimpulan Skrining Perkembangan:
                            </h4>
                            <div class="mb-2">
                                @if(str_contains($kesimpulan, 'Normal'))
                                    <span class="badge badge-success px-3 py-2 font-w700" style="font-size: 13px; border-radius: 6px; background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-circle-check mr-1.5"></i> {{ $kesimpulan }}
                                    </span>
                                @elseif(str_contains($kesimpulan, 'Suspect') || str_contains($kesimpulan, 'Meragukan'))
                                    <span class="badge badge-warning px-3 py-2 font-w700" style="font-size: 13px; border-radius: 6px; background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                                        <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> {{ $kesimpulan }}
                                    </span>
                                @elseif(str_contains($kesimpulan, 'Keterlambatan') || str_contains($kesimpulan, 'Delay'))
                                    <span class="badge badge-danger px-3 py-2 font-w700" style="font-size: 13px; border-radius: 6px; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                        <i class="fa-solid fa-circle-xmark mr-1.5"></i> {{ $kesimpulan }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary px-3 py-2 font-w700" style="font-size: 13px; border-radius: 6px;">
                                        {{ $kesimpulan }}
                                    </span>
                                @endif
                            </div>
                            @if($latestAssessment->denver_catatan)
                                <div class="mt-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12.5px; color: #475569; line-height: 1.5;">
                                    <strong><i class="fa-solid fa-clipboard-list mr-1.5 text-primary"></i> Catatan Observasi:</strong> {{ $latestAssessment->denver_catatan }}
                                </div>
                            @endif
                        </div>

                        <!-- Score Counter Pills -->
                        <div class="col-lg-6 col-md-12 pl-lg-3">
                            <div class="d-flex flex-wrap justify-content-lg-end" style="gap: 12px;">
                                <div class="denver-stat-box" style="background: #ecfdf5; border: 1px solid #a7f3d0; min-width: 100px;">
                                    <div class="font-w800" style="font-size: 22px; color: #059669;">{{ $passCount }}</div>
                                    <div class="font-w700" style="font-size: 11px; color: #047857;">Pass (Lulus)</div>
                                </div>
                                <div class="denver-stat-box" style="background: #fef2f2; border: 1px solid #fecaca; min-width: 100px;">
                                    <div class="font-w800" style="font-size: 22px; color: #dc2626;">{{ $failCount }}</div>
                                    <div class="font-w700" style="font-size: 11px; color: #b91c1c;">Fail (Gagal)</div>
                                </div>
                                <div class="denver-stat-box" style="background: #fffbeb; border: 1px solid #fde68a; min-width: 100px;">
                                    <div class="font-w800" style="font-size: 22px; color: #d97706;">{{ $refusalCount }}</div>
                                    <div class="font-w700" style="font-size: 11px; color: #b45309;">Refusal</div>
                                </div>
                                <div class="denver-stat-box" style="background: #f8fafc; border: 1px solid #e2e8f0; min-width: 100px;">
                                    <div class="font-w800" style="font-size: 22px; color: #64748b;">{{ $noCount }}</div>
                                    <div class="font-w700" style="font-size: 11px; color: #475569;">No Opp</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Sektor Perkembangan Denver (2x2 Grid) -->
        @php
            $sectorIcons = [
                'A' => ['icon' => 'fa-users', 'bg' => '#eff6ff', 'color' => '#2563eb', 'border' => '#dbeafe'],
                'B' => ['icon' => 'fa-shapes', 'bg' => '#e0f2fe', 'color' => '#0284c7', 'border' => '#bae6fd'],
                'C' => ['icon' => 'fa-comments', 'bg' => '#fef3c7', 'color' => '#b45309', 'border' => '#fde68a'],
                'D' => ['icon' => 'fa-person-running', 'bg' => '#ecfdf5', 'color' => '#059669', 'border' => '#a7f3d0'],
            ];
        @endphp

        @foreach($denverSectors as $secKey => $sector)
            @php
                $style = $sectorIcons[$secKey] ?? ['icon' => 'fa-child', 'bg' => '#f1f5f9', 'color' => '#334155', 'border' => '#e2e8f0'];
                $rawTitle = $sector['title'] ?? $sector['name'] ?? ('Sektor ' . $secKey);
                $cleanTitle = preg_replace('/^[A-D]\.\s*/i', '', $rawTitle);
            @endphp
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card shadow-sm h-100" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                        <h4 class="card-title font-w700 mb-0 d-flex align-items-center" style="color: var(--ot-navy, #1e40af); font-size: 15.5px;">
                            <span class="mr-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px; background: {{ $style['bg'] }}; color: {{ $style['color'] }}; border: 1px solid {{ $style['border'] }}; font-size: 14px;">
                                <i class="fa-solid {{ $style['icon'] }}"></i>
                            </span>
                            <span>Sektor {{ $secKey }}: {{ $cleanTitle }}</span>
                        </h4>
                        <span class="badge font-w600 text-muted" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 11.5px; border-radius: 6px; padding: 4px 8px;">
                            {{ count($sector['tasks'] ?? []) }} Task
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 denver-task-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Nama Task Perkembangan</th>
                                        <th style="width: 25%;">Rentang Usia</th>
                                        <th style="width: 25%; text-align: center;">Hasil Evaluasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sector['tasks'] ?? [] as $tKey => $task)
                                        @php
                                            $taskResult = $denverData[$tKey]['score'] ?? '-';
                                            $taskNote = $denverData[$tKey]['catatan'] ?? '';
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong class="text-dark" style="font-size: 13px;">{{ $task['name'] ?? $task['title'] ?? '-' }}</strong>
                                                @if(!empty($taskNote) && $taskNote !== '-')
                                                    <div class="text-muted mt-0.5" style="font-size: 11.5px;"><em>"{{ $taskNote }}"</em></div>
                                                @endif
                                            </td>
                                            <td class="text-muted font-w600" style="font-size: 12.5px;">{{ $task['age'] ?? $task['age_range'] ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if($taskResult == 'P')
                                                    <span class="score-badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                        <i class="fa-solid fa-check"></i> Pass
                                                    </span>
                                                @elseif($taskResult == 'F')
                                                    <span class="score-badge" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                        <i class="fa-solid fa-xmark"></i> Fail
                                                    </span>
                                                @elseif($taskResult == 'R')
                                                    <span class="score-badge" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                                                        Refusal
                                                    </span>
                                                @elseif($taskResult == 'NO')
                                                    <span class="score-badge" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;">
                                                        No Opp
                                                    </span>
                                                @else
                                                    <span class="text-muted font-w600">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @else
        <div class="col-12">
            <div class="card shadow-sm text-center p-5" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05); background: #ffffff;">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background: #eff6ff; color: #2563eb; font-size: 28px; margin: 0 auto; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-baby"></i>
                </div>
                <h4 class="text-dark font-w700 mb-2" style="font-size: 18px;">Belum Ada Catatan Skala Denver II</h4>
                <p class="text-muted mb-4" style="max-width: 440px; margin: 0 auto; font-size: 13.5px; line-height: 1.5;">
                    Penerima manfaat ini belum memiliki data skrining Denver II yang direkam oleh terapis pada sistem rekam medis.
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
