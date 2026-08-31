<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Menu Utama</li>
            
            <li>
                <a href="{{Route('dashboard')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            @if (auth()->user()->role_display() == 'Admin' || auth()->user()->role_display() == 'Pendaftaran')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Penerima Manfaat</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{Route('penerima-manfaat')}}"><i class="fa fa-list mr-2"></i>Data Penerima Manfaat</a></li>
                    <li><a href="{{Route('penerima-manfaat.add')}}"><i class="fa fa-user-plus mr-2"></i>Penerima Manfaat Baru</a></li>
                </ul>
            </li>
            @endif

            <li class="nav-label">Pelayanan</li>
            
            @if (auth()->user()->role_display() == 'Admin' || auth()->user()->role_display() == 'Pendaftaran')
            <li>
                <a href="{{Route('rekam')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-notepad"></i>
                    <span class="nav-text">Rekam Medis</span>
                </a>
            </li>
            @elseif (auth()->user()->role_display() == 'Dokter')
            <li>
                <a href="{{Route('rekam', ['tab' => 2])}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-notepad"></i>
                    <span class="nav-text">Rekam Medis</span>
                </a>
            </li>
            @endif

            @if (auth()->user()->role_display() == 'Admin')
            <li class="nav-label">Master Data</li>
            
            <li>
                <a href="{{Route('omahterapiku')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-home"></i>
                    <span class="nav-text">Omah Terapiku</span>
                </a>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{Route('tindakan')}}"><i class="fa fa-stethoscope mr-2"></i>Tindakan</a></li>
                    <li><a href="{{Route('petugas')}}"><i class="fa fa-id-badge mr-2"></i>Petugas</a></li>
                    <li><a href="{{Route('terapis')}}"><i class="fa fa-user-md mr-2"></i>Data Terapis</a></li>
                    <li><a href="{{Route('icd')}}"><i class="fa fa-heartbeat mr-2"></i>ICD-10</a></li>
                </ul>
            </li>
            
            <li class="nav-label">Akun & Sistem</li>
            
            <li>
                <a href="{{Route('setting.index')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </li>
            @endif
        </ul>
        
        <div class="copyright">
            <p><strong>Omah Terapiku</strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>