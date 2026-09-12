<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <!-- Left: Portal Title -->
                <div class="header-left">
                    <div class="dashboard_bar d-flex align-items-center">
                        <span class="font-w700 text-primary" style="font-size: 17px;">
                            <i class="fa-solid fa-hospital-user mr-1"></i> Portal Pasien & Keluarga
                        </span>
                    </div>
                </div>

                <!-- Right: Patient Avatar & Dropdown (Identical to Admin Style) -->
                <ul class="navbar-nav header-right d-flex align-items-center">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link user-profile-btn" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-expanded="false" title="Menu Profil Pasien">
                            <div class="user-avatar-wrap">
                                <img src="{{ asset('images/profile.png') }}" alt="Avatar Pasien"/>
                            </div>
                            <div class="header-info">
                                <span class="user-greeting">Halo, <strong>{{ session('portal_pasien_nama', 'Penerima Manfaat') }}</strong></span>
                                <p class="fs-12 mb-0 user-role">No. RM: {{ session('portal_pasien_no_rm', '-') }}</p>
                            </div> 
                            <i class="fa-solid fa-chevron-down user-dropdown-caret"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header px-3 py-2 border-bottom">
                                <h6 class="mb-0 text-primary font-w600" style="color: #2e4b82 !important;">{{ session('portal_pasien_nama', 'Penerima Manfaat') }}</h6>
                                <span class="fs-12 text-muted">No. RM: {{ session('portal_pasien_no_rm', '-') }}</span>
                            </div>
                            <a href="{{ route('portal.logout') }}" class="dropdown-item ai-icon btn-logout text-danger">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ml-2 font-w600">Keluar Portal</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
