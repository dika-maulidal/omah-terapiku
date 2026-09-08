<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left d-flex align-items-center">
                    <div class="dashboard_bar mr-3">
                    </div>


                </div>
                <ul class="navbar-nav header-right d-flex align-items-center" style="gap: 14px;">

                    <!-- Tombol Tanya AI (Klinis & Terapi) -->
                    <li class="nav-item d-flex align-items-center">
                        <button type="button" class="btn btn-tanya-ai" id="btnOpenAiAssistant" title="Tanya AI Asisten Terapi & Klinis (Omah Terapi-KU)">
                            <span class="ai-agent-icon"><i class="fa-solid fa-robot"></i></span>
                            <span class="ai-btn-text">Tanya AI</span>
                            <span class="badge ml-1 ai-btn-badge" style="font-size: 9px; padding: 2px 5px; border-radius: 8px; font-weight: 700; background: rgba(255, 255, 255, 0.22); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35);">AI</span>
                        </button>
                    </li>

                    <li class="nav-item dropdown notification_dropdown dropdown-notifications">
                        <a class="nav-link ai-icon position-relative" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-expanded="false" title="Notifikasi Penugasan & Pemeriksaan" id="notificationDropdownBtn">
                            <svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="#ffffff"/>
                            </svg>
                            @php
                                $unreadCount = auth()->user()->unreadnotifications->count();
                            @endphp
                            <span class="badge badge-danger notif-badge-indicator {{ $unreadCount > 0 ? '' : 'd-none' }}" style="position: absolute; top: 4px; right: 4px; padding: 2px 5px; font-size: 10px; border-radius: 10px; background-color: #ef4444 !important; color: #ffffff; border: 1.5px solid #ffffff; font-weight: 700;">
                                <span class="notif-count">{{ $unreadCount }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg p-0" style="width: 360px; max-width: 90vw; border-radius: 12px; border: 1px solid #dbeafe; overflow: hidden;">
                            <div class="dropdown-header px-3 py-2.5 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom: 1px solid #bfdbfe;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-bell mr-2" style="color: #2563eb;"></i>
                                    <h6 class="mb-0 font-w700" style="color: #1e40af !important; font-size: 13.5px;">Notifikasi Penugasan</h6>
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-primary btn-mark-all-read" onclick="markAllNotificationsRead(event)" style="font-size: 11px; padding: 2px 8px; border-radius: 6px; border-color: #93c5fd; background: #ffffff; color: #1d4ed8;" title="Tandai semua notifikasi telah dibaca">
                                    <i class="fa-solid fa-check-double mr-1"></i> Baca Semua
                                </button>
                            </div>
                            <div id="DZ_W_Notification1" class="widget-media dz-scroll p-2" style="max-height: 380px; overflow-y: auto;">
                                <ul class="timeline mb-0" id="notificationTimelineList">
                                   @forelse (auth()->user()->unreadnotifications as $notif)
                                        @php
                                            $data = $notif->data;
                                            $namaPasien = $data['nama_pasien'] ?? 'Penerima Manfaat';
                                            $noRm = $data['no_rm'] ?? '-';
                                            $layanan = $data['layanan_terapi'] ?? 'Terapi';
                                            $sesi = $data['sesi_waktu'] ?? '';
                                            $msg = $data['message'] ?? 'Ada pasien baru ditugaskan ke Anda.';
                                            $createdAt = isset($data['created_at']) 
                                                ? (\Carbon\Carbon::parse($data['created_at'])->format('d/m/Y H:i'))
                                                : $notif->created_at->format('d/m/Y H:i');
                                        @endphp
                                        <li class="p-2 mb-1 notif-item" style="border-radius: 8px; border-bottom: 1px solid #f1f5f9; background: #ffffff; transition: background 0.2s ease;">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-2.5 mt-1" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 14px; flex-shrink: 0; border: 1px solid #bfdbfe;">
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                </div>
                                                <div class="media-body" style="font-size: 12px;">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <strong class="text-dark font-w700" style="font-size: 12.5px;">{{ $namaPasien }}</strong>
                                                        <span class="badge badge-primary light font-w600" style="font-size: 10px; padding: 1px 6px;">{{ $layanan }}</span>
                                                    </div>
                                                    <p class="mb-1 text-secondary" style="font-size: 11.5px; line-height: 1.35; color: #475569 !important;">
                                                        {{ $msg }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                                        <small class="text-muted font-w500" style="font-size: 10.5px;">
                                                            <i class="fa-regular fa-clock mr-1"></i>{{ $createdAt }}
                                                        </small>
                                                        <a href="{{ route('notifications.read', $notif->id) }}" class="btn btn-primary btn-xs font-w600" style="padding: 2px 8px; font-size: 11px; border-radius: 5px; background: #2563eb;">
                                                            <i class="fa-solid fa-arrow-right mr-1"></i> Buka
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                   @empty
                                        <li class="text-center py-4 text-muted empty-notif-state">
                                            <div class="mb-2" style="width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 18px;">
                                                <i class="fa-regular fa-bell-slash"></i>
                                            </div>
                                            <p class="fs-12 mb-0 font-w600 text-secondary">Tidak ada notifikasi baru</p>
                                            <small class="text-muted" style="font-size: 11px;">Notifikasi penugasan pasien akan muncul di sini</small>
                                        </li>
                                   @endforelse
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link user-profile-btn" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-expanded="false" title="Menu Profil User">
                            <div class="user-avatar-wrap">
                                <img src="{{asset('images/profile.png')}}" alt="Avatar"/>
                            </div>
                            <div class="header-info">
                                <span class="user-greeting">Halo, <strong>{{auth()->user()->name}}</strong></span>
                                <p class="fs-12 mb-0 user-role">{{auth()->user()->role_display()}}</p>
                            </div> 
                            <i class="fa-solid fa-chevron-down user-dropdown-caret"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header px-3 py-2 border-bottom">
                                <h6 class="mb-0 text-primary font-w600" style="color: #2e4b82 !important;">{{auth()->user()->name}}</h6>
                                <span class="fs-12 text-muted">{{auth()->user()->role_display()}}</span>
                            </div>
                            <a href="{{Route('setting.index')}}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ml-2">Pengaturan Akun </span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a href="{{Route('logout')}}" class="dropdown-item ai-icon btn-logout text-danger">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>