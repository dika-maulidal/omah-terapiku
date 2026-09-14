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
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 14px;">
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

                    <!-- Actions & Filter (Standardized Dashboard Dropdown Filter) -->
                    @if($assessments && $assessments->count() > 0)
                        <div class="position-relative mt-2 mt-sm-0" style="min-width: 200px;">
                            <i class="fa fa-filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563eb; font-size: 12px; pointer-events: none; z-index: 2;"></i>
                            <select id="filterDenverAssessment" class="form-control form-control-sm font-w700" onchange="if(this.value) window.location.href = '{{ route('portal.denver') }}?assessment_id=' + this.value;" style="color: #2563eb !important; padding-left: 32px; padding-right: 36px; height: 36px; font-size: 12.5px; border-radius: 8px; border-color: #cbd5e1; cursor: pointer; background-color: #ffffff; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232563eb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 14px center; background-size: 11px 11px;">
                                @foreach($assessments as $asm)
                                    <option value="{{ $asm->id }}" {{ $latestAssessment && $latestAssessment->id == $asm->id ? 'selected' : '' }}>
                                        {{ $asm->tgl_assessment ? \Carbon\Carbon::parse($asm->tgl_assessment)->isoFormat('D MMMM Y') : 'Sesi #' . $asm->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
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

        <!-- Ringkasan Info Asesmen (Nuansa Evaluasi Nyeri & GMFM) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-calendar-check mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Tanggal Asesmen</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $latestAssessment->tgl_assessment ? \Carbon\Carbon::parse($latestAssessment->tgl_assessment)->isoFormat('D MMMM Y') : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="pl-md-3 d-flex align-items-center" style="border-left: 2px solid #f1f5f9;">
                                    <i class="fa-solid fa-user-doctor mr-2 text-primary" style="font-size: 16px;"></i>
                                    <div>
                                        <div class="text-muted font-w600" style="font-size: 11px; text-transform: uppercase;">Terapis Pemeriksa</div>
                                        <strong class="text-dark" style="font-size: 13.5px;">{{ $latestAssessment->dokter ? $latestAssessment->dokter->nama : 'Terapis Medis Omah Terapi-KU' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 text-lg-right">
                            <div class="d-flex align-items-center justify-content-lg-end flex-wrap" style="gap: 8px;">
                                @if(str_contains($kesimpulan, 'Normal'))
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-circle-check mr-1"></i> {{ $kesimpulan }}
                                    </span>
                                @elseif(str_contains($kesimpulan, 'Suspect') || str_contains($kesimpulan, 'Meragukan'))
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $kesimpulan }}
                                    </span>
                                @elseif(str_contains($kesimpulan, 'Keterlambatan') || str_contains($kesimpulan, 'Delay'))
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                        <i class="fa-solid fa-circle-xmark mr-1"></i> {{ $kesimpulan }}
                                    </span>
                                @else
                                    <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-clipboard-check mr-1"></i> {{ $kesimpulan }}
                                    </span>
                                @endif
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    <i class="fa-solid fa-list-check mr-1"></i> {{ $passCount + $failCount + $refusalCount + $noCount }} Item Teruji
                                </span>
                                <span class="badge px-3 py-2 font-w700" style="font-size: 12px; border-radius: 6px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-shapes mr-1"></i> 4 Sektor Terdata
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluasi Capaian Skala Perkembangan (DDST II) (Hero Card Nuansa GMFM & Nyeri) -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
                <div class="card-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                    <h4 class="card-title font-w700" style="color: var(--ot-navy, #1e40af); font-size: 16px; margin: 0;">
                        <i class="fa-solid fa-chart-pie text-primary mr-2"></i> Evaluasi Capaian Skala Perkembangan (DDST II)
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-stretch" style="row-gap: 16px;">
                        <!-- Left Hero Panel (Symmetrical & Balanced) -->
                        <div class="col-lg-6 col-md-12 d-flex flex-column">
                            <div class="p-4 rounded h-100 d-flex flex-column justify-content-between text-center" style="background: #fafcff; border: 1px solid #e2e8f0; border-radius: 12px;">
                                <div>
                                    <div class="text-muted font-w700" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Hasil Skrining Perkembangan
                                    </div>
                                    <div class="font-w800 my-2" style="font-size: 28px; line-height: 1.2; color: {{ str_contains($kesimpulan, 'Normal') ? '#059669' : (str_contains($kesimpulan, 'Suspect') || str_contains($kesimpulan, 'Meragukan') ? '#d97706' : (str_contains($kesimpulan, 'Delay') || str_contains($kesimpulan, 'Keterlambatan') ? '#dc2626' : '#1e40af')) }};">
                                        {{ $kesimpulan }}
                                    </div>
                                    <div class="mb-3">
                                        @if(str_contains($kesimpulan, 'Normal'))
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 16px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; box-shadow: 0 1px 2px rgba(5, 150, 105, 0.06); gap: 8px;">
                                                <i class="fa-solid fa-circle-check"></i> <span>Perkembangan Sesuai Usia Kronologis</span>
                                            </span>
                                        @elseif(str_contains($kesimpulan, 'Suspect') || str_contains($kesimpulan, 'Meragukan'))
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 16px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; box-shadow: 0 1px 2px rgba(217, 119, 6, 0.06); gap: 8px;">
                                                <i class="fa-solid fa-triangle-exclamation"></i> <span>Perkembangan Meragukan &mdash; Perlu Re-skrining</span>
                                            </span>
                                        @elseif(str_contains($kesimpulan, 'Keterlambatan') || str_contains($kesimpulan, 'Delay'))
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 16px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; box-shadow: 0 1px 2px rgba(220, 38, 38, 0.06); gap: 8px;">
                                                <i class="fa-solid fa-circle-xmark"></i> <span>Keterlambatan &mdash; Butuh Program Terapi</span>
                                            </span>
                                        @else
                                            <span class="d-inline-flex align-items-center" style="padding: 6px 16px; font-size: 12.5px; font-weight: 700; border-radius: 20px; background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; box-shadow: 0 1px 2px rgba(37, 99, 235, 0.06); gap: 8px;">
                                                <i class="fa-solid fa-circle-info"></i> <span>Observasi Klinis Tumbuh Kembang</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Observation Note / Scope -->
                                <div class="pt-3" style="border-top: 1px dashed #e2e8f0;">
                                    @if($latestAssessment->denver_catatan)
                                        <div class="text-left" style="font-size: 12.5px;">
                                            <div class="d-flex align-items-center mb-1" style="gap: 7px;">
                                                <i class="fa-solid fa-clipboard-list text-primary" style="font-size: 13.5px;"></i>
                                                <strong class="text-dark font-w700" style="font-size: 12.5px;">Catatan Observasi Terapis:</strong>
                                            </div>
                                            <span class="text-muted" style="line-height: 1.5;">{{ $latestAssessment->denver_catatan }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between align-items-center text-muted font-w600" style="font-size: 12px;">
                                            <span>Cakupan Skrining</span>
                                            <strong class="text-dark">4 Sektor Perkembangan Lengkap</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right 2x2 Stat Counter Grid -->
                        <div class="col-lg-6 col-md-12 d-flex flex-column">
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 14px; height: 100%;">
                                <!-- Stat 1: Pass (Lulus) -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                        <i class="fa-solid fa-check" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #059669; line-height: 1.2;">
                                        {{ $passCount }} <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Item</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Pass (Lulus)</div>
                                </div>

                                <!-- Stat 2: Fail (Gagal) -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                        <i class="fa-solid fa-xmark" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #dc2626; line-height: 1.2;">
                                        {{ $failCount }} <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Item</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Fail (Gagal)</div>
                                </div>

                                <!-- Stat 3: Refusal (Menolak) -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">
                                        <i class="fa-solid fa-hand" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #d97706; line-height: 1.2;">
                                        {{ $refusalCount }} <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Item</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">Refusal (Menolak)</div>
                                </div>

                                <!-- Stat 4: No Opportunity -->
                                <div class="p-3 rounded d-flex flex-column justify-content-center align-items-center text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center justify-content-center mb-2" style="width: 34px; height: 34px; border-radius: 8px; background: #f8fafc; color: #475569; border: 1px solid #cbd5e1;">
                                        <i class="fa-solid fa-ban" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="font-w800" style="font-size: 22px; color: #475569; line-height: 1.2;">
                                        {{ $noCount }} <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">Item</span>
                                    </div>
                                    <div class="font-w700 mt-1" style="font-size: 11.5px; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px;">No Opportunity</div>
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
