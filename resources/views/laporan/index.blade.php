@extends('layout.apps')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: 1px solid #e2e8f0;
    }
    .leaflet-popup-content {
        margin: 12px 14px;
        line-height: 1.4;
    }
    .custom-balai-marker {
        background: #ef4444;
        border: 2px solid #ffffff;
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.45);
        font-size: 11.5px;
    }
    .custom-pulse-ring {
        position: absolute;
        border: 2px solid #ef4444;
        border-radius: 50%;
        animation: pulseMap 1.8s infinite;
        opacity: 0.8;
    }
    @keyframes pulseMap {
        0% { transform: scale(0.9); opacity: 0.8; }
        70% { transform: scale(2.2); opacity: 0; }
        100% { transform: scale(2.2); opacity: 0; }
    }
</style>
@endsection

@section('content')
    <!-- Header Section (Unified White Card) -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Laporan Eksekutif & Statistik Dinas Sosial</h3>
                        <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                            <li class="breadcrumb-item text-muted">Laporan & Evaluasi</li>
                            <li class="breadcrumb-item active text-muted">Executive Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div>
                    <!-- Tombol Cetak PDF Resmi -->
                    <a href="{{ route('laporan.eksekutif.print', request()->all()) }}" target="_blank" id="btnPrintPdf" class="btn btn-sm btn-primary font-w700 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Laporan Resmi (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar Filter Periode & Layanan Card -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('laporan.eksekutif') }}" id="filterForm">
                <div class="row align-items-end" style="row-gap: 12px;">
                    <!-- 1. Tipe Periode -->
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                        <label class="form-label font-w600 text-dark mb-1 text-truncate d-block" style="font-size: 12.5px;" title="Jenis Periode Laporan">
                            <i class="fa-solid fa-calendar-days mr-1 text-primary"></i> Periode Laporan:
                        </label>
                        <select name="tipe_periode" id="tipePeriodeSelect" class="form-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 600;">
                            <option value="bulanan" {{ $meta['tipe'] == 'bulanan' ? 'selected' : '' }}>Rekap Bulanan</option>
                            <option value="triwulan" {{ $meta['tipe'] == 'triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan)</option>
                            <option value="semester" {{ $meta['tipe'] == 'semester' ? 'selected' : '' }}>Semester (6 Bulan)</option>
                            <option value="tahunan" {{ $meta['tipe'] == 'tahunan' ? 'selected' : '' }}>Tahunan (1 Tahun)</option>
                            <option value="custom" {{ $meta['tipe'] == 'custom' ? 'selected' : '' }}>Kustom Rentang Tanggal</option>
                        </select>
                    </div>

                    <!-- 2. Parameter Bulan (Bulanan) -->
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12 filter-input-group" id="inputBulan" style="{{ $meta['tipe'] == 'bulanan' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Bulan:</label>
                        <select name="bulan" id="bulanSelect" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            @foreach($meta['nama_bulan'] as $num => $nama)
                                <option value="{{ $num }}" {{ $meta['bulan'] == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Parameter Triwulan (Triwulan) -->
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12 filter-input-group" id="inputTriwulan" style="{{ $meta['tipe'] == 'triwulan' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Triwulan:</label>
                        <select name="triwulan" id="triwulanSelect" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="1" {{ $meta['triwulan'] == 1 ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                            <option value="2" {{ $meta['triwulan'] == 2 ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                            <option value="3" {{ $meta['triwulan'] == 3 ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                            <option value="4" {{ $meta['triwulan'] == 4 ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                        </select>
                    </div>

                    <!-- 4. Parameter Semester (Semester) -->
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12 filter-input-group" id="inputSemester" style="{{ $meta['tipe'] == 'semester' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Semester:</label>
                        <select name="semester" id="semesterSelect" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="1" {{ $meta['semester'] == 1 ? 'selected' : '' }}>Semester 1 (Jan-Jun)</option>
                            <option value="2" {{ $meta['semester'] == 2 ? 'selected' : '' }}>Semester 2 (Jul-Des)</option>
                        </select>
                    </div>

                    <!-- 5. Parameter Custom Range -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 filter-input-group" id="inputCustom" style="{{ $meta['tipe'] == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Rentang Tanggal:</label>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <input type="date" name="tgl_awal" id="tglAwalInput" value="{{ $meta['tgl_awal'] }}" class="form-control filter-control" style="height: 42px; font-size: 12px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                            <span class="text-muted font-w600">s/d</span>
                            <input type="date" name="tgl_akhir" id="tglAkhirInput" value="{{ $meta['tgl_akhir'] }}" class="form-control filter-control" style="height: 42px; font-size: 12px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                        </div>
                    </div>

                    <!-- 6. Parameter Tahun -->
                    <div class="col-xl-2 col-lg-4 col-md-6 col-12 filter-input-group" id="inputTahun" style="{{ $meta['tipe'] != 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 12.5px;">Tahun:</label>
                        <select name="tahun" id="tahunSelect" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500; padding: 0 10px;">
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $meta['tahun'] == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 7. Filter UPT -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <label class="form-label font-w600 text-dark mb-1 text-truncate d-block" style="font-size: 12.5px;" title="Cakupan Lokasi UPT">
                            <i class="fa-solid fa-hospital-user mr-1 text-primary"></i> Cakupan Lokasi UPT:
                        </label>
                        <select name="upt" id="uptSelect" class="form-control filter-control" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                            <option value="all" {{ $meta['upt'] == 'all' ? 'selected' : '' }}>Seluruh UPT (Provinsi Jatim)</option>
                            @foreach($allUpts as $u)
                                <option value="{{ $u->nama }}" {{ $meta['upt'] == $u->nama ? 'selected' : '' }}>{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 8. Filter Layanan + Reset Inline -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <label class="form-label font-w600 text-dark mb-1 text-truncate d-block" style="font-size: 12.5px;" title="Ragam Layanan">
                            <i class="fa-solid fa-tag mr-1 text-primary"></i> Ragam Layanan:
                        </label>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <select name="layanan" id="layananSelect" class="form-control filter-control flex-grow-1" style="height: 42px; font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1; font-weight: 500;">
                                <option value="all" {{ $meta['layanan'] == 'all' ? 'selected' : '' }}>Semua Layanan</option>
                                <option value="Fisioterapi" {{ $meta['layanan'] == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                <option value="Terapi Wicara" {{ $meta['layanan'] == 'Terapi Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                <option value="Terapi Okupasi" {{ $meta['layanan'] == 'Terapi Okupasi' ? 'selected' : '' }}>Terapi Okupasi</option>
                                <option value="Sensori Integrasi" {{ $meta['layanan'] == 'Sensori Integrasi' ? 'selected' : '' }}>Sensori Integrasi</option>
                            </select>
                            <button type="button" id="btnResetFilter" class="btn btn-light btn-sm font-w600 shadow-sm" style="height: 42px; width: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; color: #475569; padding: 0; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; background: #f8fafc; flex-shrink: 0;" title="Reset Filter ke Default">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Report Data Container with Loading Overlay -->
    <div id="reportDataContainer" style="position: relative; min-height: 400px;">
        <!-- Loading Overlay -->
        <div id="reportLoadingOverlay" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.85); z-index: 999; backdrop-filter: blur(2px); border-radius: 12px; align-items: center; justify-content: center; flex-direction: column;">
            <div class="spinner-border text-primary mb-2" role="status" style="width: 2.5rem; height: 2.5rem;">
                <span class="sr-only">Memuat...</span>
            </div>
            <span class="text-primary font-w600" style="font-size: 13.5px;">Memuat rekap laporan eksekutif &amp; statistik...</span>
        </div>

        <div id="reportContentWrapper">
            @include('laporan.partial.content')
        </div>
    </div>

@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let mapJatim = null;
    let currentPatientPoints = @json($data['map_patient_points'] ?? []);
    let currentBalaiPoints = @json($data['map_balai_points'] ?? []);
    let currentGeoView = 'map';

    function initMapJatim(patientPts, balaiPts) {
        const patients = patientPts !== undefined ? patientPts : currentPatientPoints;
        const balais = balaiPts !== undefined ? balaiPts : currentBalaiPoints;

        if (mapJatim !== null) {
            try {
                mapJatim.remove();
            } catch (e) {
                console.error(e);
            }
            mapJatim = null;
        }

        const mapEl = document.getElementById('mapJatim');
        if (!mapEl) return;

        // Inisialisasi Peta Jawa Timur
        mapJatim = L.map('mapJatim', {
            center: [-7.70, 112.65],
            zoom: 8,
            scrollWheelZoom: false,
            attributionControl: false
        });

        // Tile layer CartoDB Voyager
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            subdomains: 'abcd',
        }).addTo(mapJatim);

        // Custom Red Icon untuk Balai UPT
        const balaiIcon = L.divIcon({
            className: 'custom-balai-icon-wrapper',
            html: `
                <div style="position: relative; width: 28px; height: 28px;">
                    <div class="custom-pulse-ring" style="width: 28px; height: 28px; top: 0; left: 0;"></div>
                    <div class="custom-balai-marker" style="width: 28px; height: 28px; position: relative; z-index: 2;">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                </div>
            `,
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        // Tambahkan Titik Balai Omah Terapi-KU
        if (balais && balais.length > 0) {
            balais.forEach(function(b) {
                const marker = L.marker([b.lat, b.lng], { icon: balaiIcon }).addTo(mapJatim);
                marker.bindPopup(`
                    <div style="font-size: 12px; min-width: 190px;">
                        <span class="badge badge-danger text-white mb-1" style="font-size: 10px; padding: 3px 6px;">${b.badge}</span>
                        <strong style="color: #1e40af; display: block; font-size: 13px; font-weight: 700;">${b.nama}</strong>
                        <div style="color: #475569; font-size: 11px; margin-top: 3px;"><i class="fa-solid fa-location-dot text-danger mr-1"></i>${b.alamat}</div>
                        <div style="color: #059669; font-size: 11px; font-weight: 600; margin-top: 4px;"><i class="fa-solid fa-check-circle mr-1"></i>Fokus: ${b.fokus}</div>
                    </div>
                `);
            });
        }

        // Tambahkan Circle Bubble untuk Titik Pasien Asal Kab/Kota
        if (patients && patients.length > 0) {
            patients.forEach(function(p) {
                const radius = Math.max(12, Math.min(32, p.total * 5));
                const circle = L.circleMarker([p.lat, p.lng], {
                    radius: radius,
                    fillColor: '#2563eb',
                    fillOpacity: 0.65,
                    color: '#1d4ed8',
                    weight: 2
                }).addTo(mapJatim);

                circle.bindTooltip(`<strong>${p.nama}</strong>: ${p.total} Pasien (${p.percentage}%)`, {
                    direction: 'top',
                    offset: [0, -8]
                });

                circle.bindPopup(`
                    <div style="font-size: 12px; min-width: 170px;">
                        <span class="badge badge-primary text-white mb-1" style="font-size: 10px; padding: 3px 6px; background: #2563eb;">Domisili Penerima Manfaat</span>
                        <strong style="color: #0f172a; display: block; font-size: 13px; font-weight: 700;">${p.nama}</strong>
                        <div style="margin-top: 4px; font-size: 12px;">
                            Total Penerima: <strong style="color: #2563eb; font-size: 13px;">${p.total} Pasien</strong>
                        </div>
                        <div style="color: #64748b; font-size: 11px;">Proporsi: <strong>${p.percentage}%</strong> dari seluruh pasien</div>
                    </div>
                `);
            });
        }
    }

    function switchGeoView(type) {
        currentGeoView = type;
        if (type === 'map') {
            $('#geoMapView').show();
            $('#geoListView').hide();
            $('#btnToggleMap').removeClass('btn-light').addClass('btn-primary');
            $('#btnToggleList').removeClass('btn-primary').addClass('btn-light');
            setTimeout(function() {
                if (mapJatim) mapJatim.invalidateSize();
            }, 100);
        } else {
            $('#geoMapView').hide();
            $('#geoListView').show();
            $('#btnToggleList').removeClass('btn-light').addClass('btn-primary');
            $('#btnToggleMap').removeClass('btn-primary').addClass('btn-light');
        }
    }

    function togglePeriodeInput(tipe) {
        $('.filter-input-group').hide();
        if (tipe === 'bulanan') {
            $('#inputBulan').show();
            $('#inputTahun').show();
        } else if (tipe === 'triwulan') {
            $('#inputTriwulan').show();
            $('#inputTahun').show();
        } else if (tipe === 'semester') {
            $('#inputSemester').show();
            $('#inputTahun').show();
        } else if (tipe === 'tahunan') {
            $('#inputTahun').show();
        } else if (tipe === 'custom') {
            $('#inputCustom').show();
        }
    }

    function fetchReportData(customUrl = null) {
        $('#reportLoadingOverlay').css('display', 'flex');

        let targetUrl = customUrl;
        if (!targetUrl) {
            const formData = $('#filterForm').serialize();
            targetUrl = '{{ route('laporan.eksekutif') }}?' + formData;
        }

        $.ajax({
            url: targetUrl,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.html) {
                    $('#reportContentWrapper').html(response.html);
                }

                currentPatientPoints = response.map_patient_points || [];
                currentBalaiPoints = response.map_balai_points || [];

                if (response.print_url) {
                    $('#btnPrintPdf').attr('href', response.print_url);
                }

                initMapJatim(currentPatientPoints, currentBalaiPoints);
                switchGeoView(currentGeoView);

                if (!customUrl) {
                    history.pushState(null, '', targetUrl);
                }
            },
            error: function(xhr) {
                console.error('Gagal memuat data laporan:', xhr);
            },
            complete: function() {
                $('#reportLoadingOverlay').hide();
            }
        });
    }

    $(document).ready(function() {
        initMapJatim(currentPatientPoints, currentBalaiPoints);

        // Event change tipe periode
        $('#tipePeriodeSelect').on('change', function() {
            togglePeriodeInput(this.value);
            fetchReportData();
        });

        // Event change filter controls
        $('.filter-control').on('change', function() {
            fetchReportData();
        });

        // Submit form filter
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchReportData();
        });

        // Reset filter button
        $('#btnResetFilter').on('click', function() {
            $('#tipePeriodeSelect').val('bulanan');
            togglePeriodeInput('bulanan');
            $('#bulanSelect').val('{{ date('n') }}');
            $('#triwulanSelect').val('{{ ceil(date('n') / 3) }}');
            $('#semesterSelect').val('{{ date('n') <= 6 ? 1 : 2 }}');
            $('#tahunSelect').val('{{ date('Y') }}');
            $('#tglAwalInput').val('');
            $('#tglAkhirInput').val('');
            $('#uptSelect').val('all');
            $('#layananSelect').val('all');

            fetchReportData();
        });

        // Popstate for browser back/forward navigation
        window.onpopstate = function() {
            location.reload();
        };
    });
</script>
@endsection
