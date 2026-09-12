<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <!-- Label: Menu Utama -->
            <li class="nav-label first">Menu Utama</li>

            <li class="{{ request()->routeIs('portal.dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.dashboard') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span class="nav-text">Beranda</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('portal.profil') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.profil') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-id-card-clip"></i>
                    <span class="nav-text">Profil Penerima Manfaat</span>
                </a>
            </li>

            <!-- Label: Hasil Asesmen Klinis -->
            <li class="nav-label">Hasil Asesmen & Terapi</li>

            <li class="{{ request()->routeIs('portal.denver') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.denver') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-baby"></i>
                    <span class="nav-text">Skala Denver II</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('portal.gmfm') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.gmfm') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-child-reaching"></i>
                    <span class="nav-text">Gross Motor (GMFM)</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('portal.nyeri') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.nyeri') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-heart-pulse"></i>
                    <span class="nav-text">Evaluasi Nyeri & Fisik</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('portal.home-program') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.home-program') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-house-chimney-medical"></i>
                    <span class="nav-text">Program Terapi Rumah</span>
                </a>
            </li>

            <!-- Label: Riwayat & Dokumen -->
            <li class="nav-label">Pelayanan & Dokumen</li>

            <li class="{{ request()->routeIs('portal.riwayat') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.riwayat') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="nav-text">Riwayat Sesi Terapi</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('portal.dokumen') ? 'mm-active' : '' }}">
                <a href="{{ route('portal.dokumen') }}" class="ai-icon" aria-expanded="false">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span class="nav-text">Dokumen & Cetak Laporan</span>
                </a>
            </li>

            <!-- Label: Akun -->
            <li class="nav-label">Sesi</li>

            <li>
                <a href="{{ route('portal.logout') }}" class="ai-icon text-danger" aria-expanded="false">
                    <i class="fa-solid fa-arrow-right-from-bracket text-danger"></i>
                    <span class="nav-text text-danger font-w600">Keluar Portal</span>
                </a>
            </li>
        </ul>

        <div class="copyright">
            <p><strong>Omah Terapiku</strong> © {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>
</div>
