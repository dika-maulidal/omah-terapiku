<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Menu Utama</li>
            
            <li>
                <a href="{{Route('dashboard')}}" class="ai-icon" aria-expanded="false">
                    <i class="fa fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->role_display() == 'Admin' || auth()->user()->role_display() == 'Pendaftaran')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
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
            <li>
                <a href="{{Route('omahterapiku')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-home"></i>
                    <span class="nav-text">Omah Terapiku</span>
                </a>
            </li>

            <li class="nav-label">Master Data</li>
            
            <li>
                <a href="{{Route('tindakan')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-notepad-1"></i>
                    <span class="nav-text">Tindakan</span>
                </a>
            </li>
            <li>
                <a href="{{Route('petugas')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-user-9"></i>
                    <span class="nav-text">Petugas</span>
                </a>
            </li>
            <li>
                <a href="{{Route('terapis')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-user-7"></i>
                    <span class="nav-text">Data Terapis</span>
                </a>
            </li>
            <li>
                <a href="{{Route('icd')}}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">ICD</span>
                </a>
            </li>
            @endif
        </ul>
        
        <div class="copyright">
            <p><strong>Omah Terapiku</strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>