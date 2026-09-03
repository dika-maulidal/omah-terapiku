<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Menu Utama</li>
            
            <li>
                <a href="{{Route('dashboard')}}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            @if (auth()->user()->role_display() == 'Admin' || auth()->user()->role_display() == 'Pendaftaran')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa-solid fa-wheelchair"></i>
                    <span class="nav-text">Penerima Manfaat</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{Route('penerima-manfaat')}}"><i class="fa-solid fa-table-list mr-2"></i>Data Penerima Manfaat</a></li>
                    <li><a href="{{Route('penerima-manfaat.add')}}"><i class="fa-solid fa-user-plus mr-2"></i>Penerima Manfaat Baru</a></li>
                </ul>
            </li>
            @endif

            <li class="nav-label">Pelayanan</li>

            <li>
                <a href="{{Route('jadwal.index')}}" class="ai-icon {{ request()->routeIs('jadwal.*') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="nav-text">Jadwal & Kalender</span>
                </a>
            </li>
            
            @if (auth()->user()->role_display() == 'Admin' || auth()->user()->role_display() == 'Pendaftaran')
            <li>
                <a href="{{Route('rekam')}}" class="ai-icon {{ request()->routeIs('rekam*') && !request()->routeIs('jadwal.*') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-notes-medical"></i>
                    <span class="nav-text">Rekam Medis</span>
                </a>
            </li>
            @elseif (auth()->user()->role_display() == 'Dokter')
            <li>
                <a href="{{Route('rekam', ['tab' => 2])}}" class="ai-icon {{ request()->routeIs('rekam*') && !request()->routeIs('jadwal.*') ? 'mm-active' : '' }}" aria-expanded="false">
                    <i class="fa-solid fa-notes-medical"></i>
                    <span class="nav-text">Rekam Medis</span>
                </a>
            </li>
            @endif

            @if (auth()->user()->role_display() == 'Admin')
            <li class="nav-label">Master Data</li>
            
            <li>
                <a href="{{Route('omahterapiku')}}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span class="nav-text">Omah Terapiku</span>
                </a>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa-solid fa-database"></i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{Route('tindakan')}}"><i class="fa-solid fa-stethoscope mr-2"></i>Tindakan</a></li>
                    <li><a href="{{Route('icd')}}"><i class="fa-solid fa-book-medical mr-2"></i>ICD-10 Diagnosa</a></li>
                    <li><a href="{{Route('petugas')}}"><i class="fa-solid fa-id-badge mr-2"></i>Petugas</a></li>
                    <li><a href="{{Route('terapis')}}"><i class="fa-solid fa-user-doctor mr-2"></i>Data Terapis</a></li>
                </ul>
            </li>
            @endif
            
            <li class="nav-label">Akun & Sistem</li>
            
            @if (auth()->user()->role_display() == 'Admin')
            <li>
                <a href="{{Route('setting.index')}}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-sliders"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{Route('logout')}}" class="ai-icon text-logout" aria-expanded="false">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
        
        <div class="copyright">
            <p><strong>Omah Terapiku</strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>