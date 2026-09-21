<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left d-flex align-items-center">
                    <div class="dashboard_bar mr-3">
                    </div>


                </div>
                <ul class="navbar-nav header-right d-flex align-items-center" style="gap: 14px;">


                    <li class="nav-item dropdown notification_dropdown dropdown-notifications">
                        <a class="nav-link ai-icon position-relative" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-expanded="false" title="Notifikasi Penugasan & Pemeriksaan" id="notificationDropdownBtn">
                            <svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="#ffffff"/>
                            </svg>
                            @php
                                $unreadCount = auth()->user()->unreadnotifications->count();
                            @endphp
                            <span class="badge badge-danger notif-badge-indicator {{ $unreadCount > 0 ? '' : 'd-none' }}" style="position: absolute; top: 1px; right: -2px; min-width: 19px; height: 19px; padding: 0 4px; font-size: 10px; border-radius: 999px; background-color: #ef4444 !important; color: #ffffff; border: 2px solid #ffffff; font-weight: 800; display: {{ $unreadCount > 0 ? 'inline-flex' : 'none' }}; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.45); line-height: 1; z-index: 2;">
                                <span class="notif-count">{{ $unreadCount }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg p-0" style="width: 380px; max-width: 92vw; border-radius: 12px; border: 1px solid #dbeafe; overflow: hidden;">
                            <div class="dropdown-header px-3 py-2.5 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom: 1px solid #bfdbfe;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-bell mr-2" style="color: #2563eb;"></i>
                                    <h6 class="mb-0 font-w700" style="color: #1e40af !important; font-size: 13.5px;">Notifikasi & Antrean</h6>
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-primary btn-mark-all-read" onclick="markAllNotificationsRead(event)" style="font-size: 11px; padding: 2px 8px; border-radius: 6px; border-color: #93c5fd; background: #ffffff; color: #1d4ed8;" title="Tandai semua notifikasi telah dibaca">
                                    <i class="fa-solid fa-check-double mr-1"></i> Baca Semua
                                </button>
                            </div>
                            <div id="DZ_W_Notification1" class="widget-media dz-scroll" style="max-height: 420px; overflow-y: auto; padding: 12px; background: #f8fafc;">
                                <ul class="timeline mb-0" id="notificationTimelineList" style="display: flex; flex-direction: column; gap: 10px; padding: 0; margin: 0; list-style: none;">
                                   @forelse (auth()->user()->unreadnotifications as $notif)
                                        @php
                                            $data = $notif->data;
                                            $tipe = $data['tipe'] ?? 'penugasan';
                                            $namaPasien = $data['nama_pasien'] ?? 'Penerima Manfaat';
                                            $noRm = $data['no_rm'] ?? '-';
                                            $layanan = $data['layanan_terapi'] ?? 'Terapi';
                                            $sesi = $data['sesi_waktu'] ?? '';
                                            $msg = $data['message'] ?? 'Ada notifikasi aktivitas baru.';
                                            $createdAt = isset($data['created_at']) 
                                                ? (\Carbon\Carbon::parse($data['created_at'])->timezone('Asia/Jakarta')->format('d/m/Y H:i'))
                                                : $notif->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i');

                                            // Styling icon & badge berdasarkan tipe
                                            if ($tipe === 'pendaftaran_baru') {
                                                $iconClass = 'fa-solid fa-user-plus';
                                                $iconBoxStyle = 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;';
                                                $badgeHtml = '<span class="badge font-w700" style="font-size: 10px; padding: 2px 7px; border-radius: 5px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa-solid fa-user-plus mr-1"></i>Pasien Baru</span>';
                                                $btnStyle = 'background: #059669; border-color: #059669; color: #ffffff;';
                                            } elseif ($tipe === 'booking_baru') {
                                                $iconClass = 'fa-solid fa-calendar-plus';
                                                $iconBoxStyle = 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;';
                                                $badgeHtml = '<span class="badge font-w700" style="font-size: 10px; padding: 2px 7px; border-radius: 5px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;"><i class="fa-solid fa-calendar mr-1"></i>Booking</span>';
                                                $btnStyle = 'background: #d97706; border-color: #d97706; color: #ffffff;';
                                            } else {
                                                $iconClass = 'fa-solid fa-user-doctor';
                                                $iconBoxStyle = 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;';
                                                $badgeHtml = '<span class="badge badge-primary light font-w700" style="font-size: 10px; padding: 2px 7px; border-radius: 5px;">' . e($layanan) . '</span>';
                                                $btnStyle = 'background: #2563eb; border-color: #2563eb; color: #ffffff;';
                                            }
                                        @endphp
                                        <li class="notif-item" style="padding: 12px 14px; margin: 0; border-radius: 10px; border: 1px solid #e2e8f0; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                            <div class="d-flex align-items-start">
                                                <div class="notif-icon-box mr-3 mt-1" style="width: 38px; height: 38px; border-radius: 10px; {{ $iconBoxStyle }} display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; margin-right: 14px;">
                                                    <i class="{{ $iconClass }}"></i>
                                                </div>
                                                <div class="media-body" style="font-size: 12px; min-width: 0;">
                                                    <div class="d-flex align-items-center justify-content-between mb-1" style="gap: 8px;">
                                                        <strong class="text-dark font-w700" style="font-size: 13px; color: #1e293b !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $namaPasien }}</strong>
                                                        {!! $badgeHtml !!}
                                                    </div>
                                                    <p class="text-secondary" style="font-size: 11.5px; line-height: 1.5; color: #475569 !important; margin: 0 0 9px 0 !important;">
                                                        {{ $msg }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between pt-1" style="border-top: 1px dashed #e2e8f0;">
                                                        <small class="text-muted font-w500" style="font-size: 10.5px; display: inline-flex; align-items: center; gap: 4px;">
                                                            <i class="fa-regular fa-clock text-muted"></i>
                                                            <span>{{ $createdAt }}</span>
                                                        </small>
                                                        <a href="{{ route('notifications.read', $notif->id) }}" class="btn btn-xs font-w600" style="padding: 3px 10px; font-size: 11px; border-radius: 6px; {{ $btnStyle }} display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                                                            <span>Buka</span>
                                                            <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                   @empty
                                        <li class="text-center py-4 text-muted empty-notif-state" style="background: #ffffff; border-radius: 10px; border: 1px dashed #cbd5e1; padding: 24px 16px;">
                                            <div class="mb-2" style="width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 18px;">
                                                <i class="fa-regular fa-bell-slash"></i>
                                            </div>
                                            <p class="fs-12 mb-0 font-w600 text-secondary">Tidak ada notifikasi baru</p>
                                            <small class="text-muted" style="font-size: 11px;">Notifikasi penugasan atau antrean baru akan muncul di sini</small>
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
                                <p class="fs-12 mb-0 user-role">{{auth()->user()->role_label()}}</p>
                            </div> 
                            <i class="fa-solid fa-chevron-down user-dropdown-caret"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header px-3 py-2 border-bottom">
                                <h6 class="mb-0 text-primary font-w600" style="color: #2e4b82 !important;">{{auth()->user()->name}}</h6>
                                <span class="fs-12 text-muted">{{auth()->user()->role_label()}}</span>
                            </div>
                            <a href="{{Route('setting.index')}}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ml-2">Pengaturan Akun </span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a href="javascript:void(0)" data-url="{{Route('logout')}}" data-no-instant class="dropdown-item ai-icon btn-logout text-danger">
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