@extends('layout.apps')
@section('content')

<!-- Header Section (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Rekam Medis</h3>
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12px;">
                        <li class="breadcrumb-item"><a href="{{Route('dashboard')}}" style="color: #2563eb;">Dashboard</a></li>
                        <li class="breadcrumb-item active text-muted">Rekam Medis</li>
                    </ol>
                </div>
            </div>

            <!-- Tombol Tambah & Export -->
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{Route('rekam.add')}}" class="btn btn-sm btn-primary font-w600" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); font-size: 13px;">
                    <i class="fa-solid fa-circle-plus mr-1"></i> Input Sesi Terapi
                </a>
                <a href="{{Route('rekam.export-csv', ['keyword' => request('keyword'), 'status' => request('status', request('tab')), 'layanan' => request('layanan'), 'upt' => request('upt', session('selected_upt'))])}}" id="btnExportCsv" class="btn btn-sm font-w600" style="border: 1px solid #a7f3d0; border-radius: 8px; background: #ecfdf5; color: #059669; padding: 8px 14px; font-size: 13px; transition: all 0.2s ease;" title="Download data rekam medis ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Section -->
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <!-- Toolbar Filter & Search Sejajar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700" id="totalRekamCount">{{ number_format($rekams->total(), 0, ',', '.') }}</strong> Sesi Rekam Medis
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form id="filterForm" method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            <!-- 0. Filter Lokasi UPT -->
                            <div class="ot-filter-wrapper" style="width: 175px;">
                                <i class="fa-solid fa-hospital-user"></i>
                                <select name="upt" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Lokasi UPT" style="width: 100%;">
                                    <option value="all" {{ (!session('selected_upt') || session('selected_upt') == 'all' || request('upt') == 'all') ? 'selected' : '' }}>Semua Lokasi UPT</option>
                                    @foreach($activeUpts as $u)
                                        <option value="{{ $u->nama }}" {{ ((session('selected_upt') == $u->nama && request('upt') !== 'all') || request('upt') == $u->nama) ? 'selected' : '' }}>
                                            {{ $u->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 140px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Pelayanan" style="width: 100%;">
                                    <option value="" {{ request('status') == '' && request('tab') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="1" {{ request('status') == '1' || request('tab') == '1' ? 'selected' : '' }}>Antrian</option>
                                    <option value="2" {{ request('status') == '2' || request('tab') == '2' ? 'selected' : '' }}>Pemeriksaan</option>
                                    <option value="3" {{ request('status') == '3' || request('tab') == '3' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="5" {{ request('status') == '5' || request('tab') == '5' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <!-- 2. Filter Layanan Terapi -->
                            <div class="ot-filter-wrapper" style="width: 155px;">
                                <i class="fa-solid fa-hand-holding-medical"></i>
                                <select name="layanan" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Layanan Terapi" style="width: 100%;">
                                    <option value="">Semua Layanan</option>
                                    <option value="Fisioterapi" {{ request('layanan') == 'Fisioterapi' ? 'selected' : '' }}>Fisioterapi</option>
                                    <option value="Okupasi" {{ request('layanan') == 'Okupasi' ? 'selected' : '' }}>Terapi Okupasi / SI</option>
                                    <option value="Wicara" {{ request('layanan') == 'Wicara' ? 'selected' : '' }}>Terapi Wicara</option>
                                    <option value="Netra" {{ request('layanan') == 'Netra' ? 'selected' : '' }}>Terapi Netra</option>
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
                                    <option value="250" {{ request('per_page') == '250' ? 'selected' : '' }}>Show 250</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show Semua</option>
                                </select>
                            </div>

                            <!-- Kolom Pencarian Sejajar -->
                            <div class="ot-search-wrapper" style="min-width: 185px; max-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari no. RM, pasien..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            <div id="resetButtonWrapper" style="{{ (request('keyword') || request('status') || request('tab') || request('layanan') || (request('upt') && request('upt') != 'all') || (session('selected_upt') && session('selected_upt') != 'all') || (request('per_page') && request('per_page') != '10')) ? '' : 'display: none;' }}">
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
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat data rekam medis...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('rekam.partial.table')
                    </div>
                </div>
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
        function fetchRekamData(page = 1, updateUrl = true) {
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
            let cleanParams = $.param(formData.filter(item => item.value !== '' && !(item.name === 'per_page' && item.value === '10') && !(item.name === 'page' && item.value == '1') && !(item.name === 'upt' && item.value === 'all')));
            let targetUrl = "{{ Route('rekam') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('rekam') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total count
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalRekamCount').text(formattedTotal);
                    }

                    // Update export CSV URL
                    if (res.export_url) {
                        $('#btnExportCsv').attr('href', res.export_url);
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
                fetchRekamData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchRekamData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchRekamData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="upt"]').val('all');
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="layanan"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchRekamData(1);
        });

        // 5. Intercept pagination link clicks
        $(document).on('click', '#tableDataContainer .pagination a', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            if (href) {
                let urlObj = new URL(href, window.location.origin);
                let page = urlObj.searchParams.get('page') || 1;
                fetchRekamData(page);

                // Smooth scroll to top of table
                $('html, body').animate({
                    scrollTop: $('#tableDataContainer').offset().top - 100
                }, 300);
            }
        });

        // 6. Handle browser Back/Forward (popstate)
        window.addEventListener('popstate', function () {
            let params = new URLSearchParams(window.location.search);
            $('#filterForm select[name="upt"]').val(params.get('upt') || 'all');
            $('#filterForm select[name="status"]').val(params.get('status') || params.get('tab') || '');
            $('#filterForm select[name="layanan"]').val(params.get('layanan') || '');
            $('#filterForm select[name="per_page"]').val(params.get('per_page') || '10');
            $('#keywordInput').val(params.get('keyword') || '');
            let page = params.get('page') || 1;
            fetchRekamData(page, false);
        });

        // 7. Delete Button Confirmation (Event Delegation)
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');

            Swal.fire({
                title: 'Ingin Menghapus?',
                text: "Yakin ingin menghapus data rekam medis: " + name + " ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus Data',
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
