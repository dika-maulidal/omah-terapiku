@extends('layout.apps')
@section('content')

<!-- Page Header Banner (Unified White Card) -->
<div class="card mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 22px; flex-shrink: 0;">
                    <i class="fa-solid fa-users-rectangle"></i>
                </div>
                <div>
                    <h3 class="font-w700 mb-1" style="color: #1e40af; font-weight: 700; font-size: 20px;">Data Penerima Manfaat</h3>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">Kelola, cari, dan pantau seluruh data penerima manfaat Omah Terapi-KU</p>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <a href="{{Route('penerima-manfaat.add')}}" class="btn btn-sm btn-primary font-w700" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important; border: none !important; color: #ffffff !important; padding: 8px 18px; border-radius: 8px; font-size: 12.5px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-user-plus mr-1"></i> Penerima Manfaat Baru
                </a>
                <a href="{{Route('penerima-manfaat.export-csv', request()->all())}}" id="btnExportCsv" class="btn btn-sm btn-success font-w600" style="background: #10b981 !important; border: none !important; color: #ffffff !important; font-size: 12.5px; padding: 8px 16px; border-radius: 8px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);" title="Download data penerima manfaat ke CSV">
                    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
                </a>
                <a href="https://cekbansos.kemensos.go.id/" target="_blank" rel="noopener noreferrer" class="btn btn-sm font-w600" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; font-size: 12.5px; padding: 7px 14px; border-radius: 8px;" title="Buka website resmi Kemensos untuk cek desil / bansos">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Cek Desil Kemensos
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 4px 18px rgba(46, 75, 130, 0.05);">
            <div class="card-body p-3 p-md-4">
                <!-- Toolbar Filter & Search Sejajar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
                    <div class="d-flex align-items-center">
                        <span class="fs-13 font-w600 text-muted">
                            Total: <strong class="text-primary font-w700" id="totalPenerimaCount">{{ $datas->total() }}</strong> Penerima Manfaat
                        </span>
                    </div>

                    <!-- Filter & Pencarian Sejajar -->
                    <div class="flex-grow-1 d-flex justify-content-xl-end">
                        <form id="filterForm" method="get" action="{{ url()->current() }}" class="d-flex align-items-center flex-wrap" style="gap: 6px; max-width: 100%;">
                            <!-- 1. Filter Status -->
                            <div class="ot-filter-wrapper" style="width: 135px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <select name="status" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Status Pelayanan" style="width: 100%;">
                                    <option value="">Semua Status</option>
                                    <option value="sudah_periksa" {{ request('status') == 'sudah_periksa' ? 'selected' : '' }}>Sudah Terapi</option>
                                    <option value="pasien_baru" {{ request('status') == 'pasien_baru' ? 'selected' : '' }}>Penerima Baru</option>
                                    <option value="pasien_lama" {{ request('status') == 'pasien_lama' ? 'selected' : '' }}>Penerima Lama</option>
                                </select>
                            </div>

                            <!-- 2. Filter Desil -->
                            <div class="ot-filter-wrapper" style="width: 130px;">
                                <i class="fa-solid fa-layer-group"></i>
                                <select name="desil" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Tingkat Desil" style="width: 100%;">
                                    <option value="">Semua Desil</option>
                                    <option value="prioritas" {{ request('desil') == 'prioritas' ? 'selected' : '' }}>Prioritas (1-4)</option>
                                    <option value="Desil 1" {{ request('desil') == 'Desil 1' ? 'selected' : '' }}>Desil 1</option>
                                    <option value="Desil 2" {{ request('desil') == 'Desil 2' ? 'selected' : '' }}>Desil 2</option>
                                    <option value="Desil 3" {{ request('desil') == 'Desil 3' ? 'selected' : '' }}>Desil 3</option>
                                    <option value="Desil 4" {{ request('desil') == 'Desil 4' ? 'selected' : '' }}>Desil 4</option>
                                    <option value="Desil 5" {{ request('desil') == 'Desil 5' ? 'selected' : '' }}>Desil 5</option>
                                    <option value="desil_5_10" {{ (request('desil') == 'desil_5_10' || request('desil') == 'desil_6_10') ? 'selected' : '' }}>Desil 5-10</option>
                                    <option value="non_desil" {{ request('desil') == 'non_desil' ? 'selected' : '' }}>Non-Desil</option>
                                </select>
                            </div>

                            <!-- 3. Filter Jenis Kelamin -->
                            <div class="ot-filter-wrapper" style="width: 110px;">
                                <i class="fa-solid fa-venus-mars"></i>
                                <select name="jk" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Jenis Kelamin" style="width: 100%;">
                                    <option value="">Semua JK</option>
                                    <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- 4. Filter Disabilitas -->
                            <div class="ot-filter-wrapper" style="width: 135px;">
                                <i class="fa-solid fa-wheelchair"></i>
                                <select name="disabilitas" class="form-control form-control-sm ot-filter-select filter-select" title="Filter Ragam Disabilitas" style="width: 100%;">
                                    <option value="">Semua Ragam</option>
                                    <option value="Fisik" {{ request('disabilitas') == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                    <option value="Intelektual" {{ request('disabilitas') == 'Intelektual' ? 'selected' : '' }}>Intelektual</option>
                                    <option value="Mental" {{ request('disabilitas') == 'Mental' ? 'selected' : '' }}>Mental</option>
                                    <option value="Sensorik" {{ request('disabilitas') == 'Sensorik' ? 'selected' : '' }}>Sensorik</option>
                                    <option value="Ganda" {{ request('disabilitas') == 'Ganda' ? 'selected' : '' }}>Ganda</option>
                                </select>
                            </div>

                            <!-- 5. Filter Shows (Per Page Limit) -->
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
                            <div class="ot-search-wrapper" style="min-width: 175px; max-width: 210px;">
                                <i class="fa-solid fa-magnifying-glass ot-search-icon"></i>
                                <input type="text" class="ot-search-input" id="keywordInput" name="keyword" value="{{request('keyword')}}" placeholder="Cari nama, RM..." autocomplete="off">
                                <button type="submit" class="ot-search-btn" title="Cari Data">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Tombol Reset Filter -->
                            <div id="resetButtonWrapper" style="{{ (request('keyword') || request('status') || request('desil') || request('jk') || request('disabilitas') || (request('per_page') && request('per_page') != '10')) ? '' : 'display: none;' }}">
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
                        <span class="mt-2 text-primary font-w600" style="font-size: 13px; letter-spacing: 0.2px;">Memuat data penerima manfaat...</span>
                    </div>

                    <!-- Table Partial Content -->
                    <div id="tableContentWrapper">
                        @include('pasien.partial.table')
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
        function fetchPasienData(page = 1, updateUrl = true) {
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

            // Filter out empty params for clean URL query
            let cleanParams = $.param(formData.filter(item => item.value !== '' && !(item.name === 'per_page' && item.value === '10') && !(item.name === 'page' && item.value == '1')));
            let targetUrl = "{{ Route('penerima-manfaat') }}" + (cleanParams ? '?' + cleanParams : '');

            if (currentAjax) {
                currentAjax.abort();
            }

            // Show loading overlay
            $('#tableLoadingOverlay').removeClass('d-none').addClass('d-flex');

            currentAjax = $.ajax({
                url: "{{ Route('penerima-manfaat') }}",
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#tableContentWrapper').html(res.html);
                    
                    // Update total count
                    if (res.total !== undefined) {
                        let formattedTotal = new Intl.NumberFormat('id-ID').format(res.total);
                        $('#totalPenerimaCount').text(formattedTotal);
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
                fetchPasienData(1);
            }, 350);
        });

        // 2. Submit form on Enter or Search Button
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            clearTimeout(searchDebounceTimer);
            fetchPasienData(1);
        });

        // 3. Trigger fetch on filter select changes
        $('.filter-select').on('change', function () {
            fetchPasienData(1);
        });

        // 4. Reset Filter Button click
        $(document).on('click', '#btnResetFilter', function (e) {
            e.preventDefault();
            $('#filterForm select[name="status"]').val('');
            $('#filterForm select[name="desil"]').val('');
            $('#filterForm select[name="jk"]').val('');
            $('#filterForm select[name="disabilitas"]').val('');
            $('#filterForm select[name="per_page"]').val('10');
            $('#keywordInput').val('');
            fetchPasienData(1);
        });

        // 5. Intercept pagination link clicks
        $(document).on('click', '#tableDataContainer .pagination a', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            if (href) {
                let urlObj = new URL(href, window.location.origin);
                let page = urlObj.searchParams.get('page') || 1;
                fetchPasienData(page);

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
            $('#filterForm select[name="desil"]').val(params.get('desil') || '');
            $('#filterForm select[name="jk"]').val(params.get('jk') || '');
            $('#filterForm select[name="disabilitas"]').val(params.get('disabilitas') || '');
            $('#filterForm select[name="per_page"]').val(params.get('per_page') || '10');
            $('#keywordInput').val(params.get('keyword') || '');
            let page = params.get('page') || 1;
            fetchPasienData(page, false);
        });

        // 7. Delete Button Confirmation (Event Delegation)
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).attr('r-id');
            var name = $(this).attr('r-name');
            var link = $(this).attr('r-link');
            Swal.fire({
               title: 'Ingin Menghapus?',
               text: "Yakin ingin menghapus data penerima manfaat : " + name + " ini?",
               type: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#ef4444',
               cancelButtonColor: '#64748b',
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