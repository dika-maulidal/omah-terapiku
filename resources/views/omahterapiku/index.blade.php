@extends('layout.apps')

@section('style')
<style>
    .focus-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .ot-modal-content {
        border-radius: 14px !important;
        border: 1px solid #dbeafe !important;
        box-shadow: 0 14px 40px rgba(30, 64, 175, 0.12) !important;
        overflow: hidden !important;
    }
    .ot-modal-header {
        background: linear-gradient(135deg, #f0f7ff 0%, #eff6ff 100%) !important;
        border-bottom: 1.5px solid #bfdbfe !important;
        padding: 16px 22px !important;
    }
    .ot-modal-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 19px;
        border: 1px solid #bfdbfe;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.1);
        flex-shrink: 0;
    }
    .ot-modal-title {
        color: #1e40af !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        margin-bottom: 2px;
    }
    .ot-modal-subtitle {
        color: #64748b !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
    }
    .ot-input-modern {
        height: 44px !important;
        font-size: 13px !important;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #1e293b !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }
    .ot-input-modern:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
        outline: none !important;
    }
    /* Checkbox & Radio - Royal Blue Theme */
    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25) !important;
    }
    .custom-radio .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25) !important;
    }
    .custom-control-input:focus ~ .custom-control-label::before {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.18) !important;
        border-color: #2563eb !important;
    }
    .terapis-check-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 9px 12px;
        background: #ffffff;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .terapis-check-card:hover {
        background: #f0f7ff;
        border-color: #bfdbfe;
    }
    .terapis-check-card input[type="checkbox"]:checked + label {
        color: #1e40af;
        font-weight: 700;
    }
    .ot-sticky-col-right {
        position: sticky;
        right: 0;
        background: #ffffff;
        z-index: 2;
        box-shadow: -4px 0 8px rgba(0, 0, 0, 0.04);
    }
    .table thead th.ot-sticky-col-right {
        background: #f8fafc;
        z-index: 3;
    }
    .quick-tag-btn {
        font-size: 11.5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.15s ease;
        border: 1px solid #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .quick-tag-btn:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        color: #1e40af;
    }
</style>
@endsection

@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
            <div class="d-flex align-items-center">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Master Data Omah Terapi-KU</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item active text-muted">Omah Terapi-KU (UPT)</li>
                    </ol>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary font-w700 shadow-sm" data-toggle="modal" data-target="#addUptModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-circle-plus mr-1"></i> Tambah UPT Baru
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-4">
                
                <!-- Toolbar Filter & Search Sejajar (Single-Row Inline) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700" id="totalUptCount">{{ number_format($datas->total(), 0, ',', '.') }}</strong> Unit Omah Terapi-KU
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form id="filterForm" method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            
                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 140px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Operasional" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>

                            <!-- 2. Filter Fokus Layanan -->
                            <div class="ot-filter-wrapper" style="width: 180px;">
                                <i class="fa-solid fa-tag"></i>
                                <select name="fokus" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Fokus Layanan" style="width: 100%;">
                                    <option value="">Semua Fokus</option>
                                    <option value="ABK" {{ request('fokus') == 'ABK' ? 'selected' : '' }}>Anak (ABK)</option>
                                    <option value="ODGJ" {{ request('fokus') == 'ODGJ' ? 'selected' : '' }}>Dewasa / Stroke / ODGJ</option>
                                    <option value="Netra" {{ request('fokus') == 'Netra' ? 'selected' : '' }}>Netra & Olahraga</option>
                                </select>
                            </div>

                            <!-- 3. Filter Shows (Per Page Limit) -->
                            <div class="ot-filter-wrapper" style="width: 120px;" title="Tampilkan jumlah baris data per halaman">
                                <i class="fa-solid fa-list-ol"></i>
                                <select name="per_page" class="form-control form-control-sm ot-filter-select filter-select" style="width: 100%;">
                                    <option value="10" {{ request('per_page', 10) == '10' ? 'selected' : '' }}>Show 10</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>Show 25</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>Show 50</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>Show 100</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show Semua</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 185px; max-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari UPT, alamat..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter (Icon-Only 38x38px) -->
                            <div id="resetButtonWrapper" style="{{ (request('keyword') || (request('status') !== null && request('status') !== '') || request('fokus') || (request('per_page') && request('per_page') != '10')) ? '' : 'display: none;' }}">
                                <button type="button" id="btnResetFilter" class="btn btn-sm btn-light" style="width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b; font-size: 13px; transition: all 0.2s ease; flex-shrink: 0;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Container Tabel dengan Loading Processing Overlay -->
                <div id="tableDataContainer" style="position: relative; min-height: 250px;">
                    <!-- Loading Processing Overlay -->
                    <div id="tableLoadingOverlay" class="d-none" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.88); z-index: 20; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 3px;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat data Omah Terapi-KU...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('omahterapiku.partial.table')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ============================================================= -->
<!-- MODAL TAMBAH UPT BARU -->
<!-- ============================================================= -->
<div class="modal fade" id="addUptModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ot-modal-content">
            <div class="modal-header ot-modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ot-modal-icon mr-3">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <h5 class="modal-title ot-modal-title">Tambah Omah Terapi-KU Baru</h5>
                        <small class="ot-modal-subtitle">Daftarkan lokasi UPT / Balai pelayanan terapi baru</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; color: #64748b; opacity: 0.8; transition: all 0.2s ease;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-left" style="background: #ffffff;">
                <form action="{{ Route('omahterapiku.store') }}" method="POST">
                    {{ csrf_field() }}

                    <!-- 1. Nama UPT -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Nama UPT / Lokasi Pelayanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" required class="form-control ot-input-modern" placeholder="Contoh: UPT PPSAB Sidoarjo">
                    </div>

                    <!-- 2. Alamat Lengkap -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Alamat Lengkap Kantor / Lokasi
                        </label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Monginsidi No. 25, Sidoklumpuk, Sidoarjo..." style="font-size: 13px; border-radius: 8px; border: 1.5px solid #cbd5e1;">{{ old('alamat') }}</textarea>
                    </div>

                    <!-- 2b. No. Telp / Kontak UPT -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            No. Telp / Hotline UPT
                        </label>
                        <input type="text" name="no_telp" class="form-control ot-input-modern" placeholder="Contoh: (031) 8921234 / 081234567890" value="{{ old('no_telp') }}">
                        <small class="text-muted" style="font-size: 11px;">Nomor kontak ini dapat tercantum pada lembar cetak SOAP dan Latihan Rumahan.</small>
                    </div>

                    <!-- 3. Fokus Layanan -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1" style="font-size: 13px;">
                            Fokus Layanan Utama
                        </label>
                        <input type="text" name="fokus_layanan" id="fokusAddInput" class="form-control ot-input-modern mb-2" placeholder="Contoh: Anak Berkebutuhan Khusus (ABK)">
                        <div class="d-flex flex-wrap" style="gap: 6px;">
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Anak Berkebutuhan Khusus (ABK)')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> ABK
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Dewasa, Lansia, ODGJ, Pasca-Stroke')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Dewasa / ODGJ / Stroke
                            </button>
                            <button type="button" class="quick-tag-btn" onclick="$('#fokusAddInput').val('Disabilitas Netra & Olahraga')">
                                <i class="fa-solid fa-plus mr-1" style="font-size: 10px;"></i> Netra & Olahraga
                            </button>
                        </div>
                    </div>

                    <!-- 4. Pilih Terapis Bertugas -->
                    <div class="form-group mb-3">
                        <label class="form-label font-w600 text-dark mb-1 d-block" style="font-size: 13px;">
                            Pilih Terapis Bertugas di UPT Ini:
                        </label>
                        <div class="p-2.5 rounded" style="max-height: 170px; overflow-y: auto; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px;">
                            @if(isset($allTerapis) && count($allTerapis) > 0)
                                @foreach($allTerapis as $terapisOpt)
                                    <div class="terapis-check-card mb-1.5">
                                        <div class="custom-control custom-checkbox w-100">
                                            <input type="checkbox" name="terapis_ids[]" value="{{ $terapisOpt->id }}" class="custom-control-input" id="tAdd_{{ $terapisOpt->id }}">
                                            <label class="custom-control-label font-w600 text-dark d-flex justify-content-between align-items-center mb-0" for="tAdd_{{ $terapisOpt->id }}" style="cursor: pointer; font-size: 12.5px;">
                                                <span class="font-w600 text-dark">{{ $terapisOpt->nama }}</span>
                                                @if($terapisOpt->poli)
                                                    <small class="badge badge-light font-w500 text-muted" style="font-size: 10.5px; border: 1px solid #e2e8f0;">{{ $terapisOpt->poli }}</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <small class="text-muted d-block text-center py-2">Tidak ada data master terapis aktif.</small>
                            @endif
                        </div>
                    </div>

                    <!-- 5. Status (Radio Button) -->
                    <div class="form-group mb-2">
                        <label class="form-label font-w600 text-dark mb-2 d-block" style="font-size: 13px;">
                            Status Operasional:
                        </label>
                        <div class="d-flex align-items-center" style="gap: 24px; padding-left: 2px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddAktif" name="status" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label font-w600 text-dark mb-0" for="statusAddAktif" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-success mr-1" style="font-size: 9px; vertical-align: middle;"></i> Aktif
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusAddNon" name="status" value="0" class="custom-control-input">
                                <label class="custom-control-label font-w600 text-dark mb-0" for="statusAddNon" style="cursor: pointer; font-size: 13px;">
                                    <i class="fa-solid fa-circle text-danger mr-1" style="font-size: 9px; vertical-align: middle;"></i> Non-Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top" style="margin: 0 -24px -24px -24px; padding: 14px 24px !important; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-light font-w600" data-dismiss="modal" style="padding: 8px 18px; font-size: 12.5px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; background: #ffffff;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 9px 24px; font-size: 12.5px; border-radius: 8px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan UPT Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        let currentAjax = null;
        let searchDebounceTimer = null;

        // Function to fetch data via AJAX
        function fetchUptData(page = 1, updateUrl = true) {
            let form = $('#filterForm');
            let formData = form.serializeArray();
            
            // Check if page parameter is needed
            let hasPage = false;
            for (let i = 0; i < formData.length; i++) {
                if (formData[i].name === 'page') {
                    formData[i].value = page;
                    hasPage = true;
                    break;
                }
            }
            if (!hasPage && page) {
                formData.push({ name: 'page', value: page });
            }

            // Filter out default params for clean URL query
            let cleanParams = $.param(formData.filter(item => item.value !== '' && !(item.name === 'per_page' && item.value === '10') && !(item.name === 'page' && item.value == '1')));
            let targetUrl = "{{ Route('omahterapiku') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('omahterapiku') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total count
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalUptCount').text(formattedTotal);
                    }

                    // Toggle Reset Button
                    if (res.has_filters) {
                        $('#resetButtonWrapper').fadeIn(150);
                    } else {
                        $('#resetButtonWrapper').fadeOut(150);
                    }

                    // Update browser URL
                    if (updateUrl && window.history.pushState) {
                        window.history.pushState({ path: targetUrl }, '', targetUrl);
                    }
                },
                error: function (xhr, status, error) {
                    if (status !== 'abort') {
                        console.error('AJAX Error:', error);
                    }
                },
                complete: function () {
                    $('#tableLoadingOverlay').addClass('d-none').removeClass('d-flex');
                }
            });
        }

        // 1. Debounce on search keyword input
        $('#keywordInput').on('input', function () {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function () {
                fetchUptData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchUptData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchUptData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="fokus"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchUptData(1);
        });

        // 5. Intercept pagination link clicks
        $(document).on('click', '#tableDataContainer .pagination a', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            if (href) {
                let urlObj = new URL(href, window.location.origin);
                let page = urlObj.searchParams.get('page') || 1;
                fetchUptData(page);

                // Smooth scroll to top of table
                $('html, body').animate({
                    scrollTop: $('#tableDataContainer').offset().top - 100
                }, 300);
            }
        });

        // 6. Handle browser Back/Forward (popstate)
        window.addEventListener('popstate', function () {
            let params = new URLSearchParams(window.location.search);
            $('#filterForm select[name="status"]').val(params.get('status') || '');
            $('#filterForm select[name="fokus"]').val(params.get('fokus') || '');
            $('#filterForm select[name="per_page"]').val(params.get('per_page') || '10');
            $('#keywordInput').val(params.get('keyword') || '');
            let page = params.get('page') || 1;
            fetchUptData(page, false);
        });

        // 7. Delete Button Confirmation (Event Delegation)
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Hapus Omah Terapi-KU?',
                text: "Yakin ingin menghapus unit UPT: " + name + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location = link;
                }
            });
        });
    });
</script>
@endsection
