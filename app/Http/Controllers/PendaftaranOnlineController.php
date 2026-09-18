<?php

namespace App\Http\Controllers;

use App\Events\StatusRekamUpdate;
use App\Models\BookingSesi;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\PendaftaranPasien;
use App\Models\Poli;
use App\Models\Rekam;
use App\Notifications\BookingBaruNotification;
use App\Notifications\PendaftaranBaruNotification;
use App\Notifications\RekamUpdateNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class PendaftaranOnlineController extends Controller
{
    // =========================================================================
    // MODUL PUBLIK (PORTAL PASIEN & KELUARGA)
    // =========================================================================

    /**
     * Submit Formulir Pendaftaran Penerima Manfaat Baru Online
     */
    public function storePendaftaran(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:191',
            'nik' => 'nullable|string|max:50',
            'no_bpjs' => 'nullable|string|max:50',
            'tmp_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'jk' => 'required|string|max:20',
            'no_hp' => 'required|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kodepos' => 'nullable|string|max:20',
            'agama' => 'nullable|string|max:50',
            'status_menikah' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'kewarganegaraan' => 'nullable|string|max:20',
            'cara_bayar' => 'nullable|string|max:100',
            'desil' => 'nullable|string|max:50',
            'nama_wali' => 'nullable|string|max:191',
            'hubungan_wali' => 'nullable|string|max:100',
            'layanan_terapi' => 'required|string|max:191',
            'tgl_rencana_kunjungan' => 'required|date',
            'jam_rencana_kunjungan' => 'nullable|string|max:100',
            'keluhan_utama' => 'nullable|string',
            'upt_lokasi' => 'nullable|string|max:191',
            'file_kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240',
            'file_resume' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Process array multiselect for jenis_disabilitas & alat_bantu
        $disabilitas = $request->jenis_disabilitas;
        if (is_array($disabilitas)) {
            $disabilitas = array_map(function ($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->jenis_disabilitas_lainnya)) {
                    return 'Lainnya (' . trim($request->jenis_disabilitas_lainnya) . ')';
                }
                return $item;
            }, $disabilitas);
            $disabilitas = implode(', ', array_filter($disabilitas));
        }

        $alat = $request->alat_bantu;
        if (is_array($alat)) {
            $alat = array_map(function ($item) use ($request) {
                if ($item === 'Lainnya' && !empty($request->alat_bantu_lainnya)) {
                    return 'Lainnya (' . trim($request->alat_bantu_lainnya) . ')';
                }
                return $item;
            }, $alat);
            $alat = implode(', ', array_filter($alat));
        }

        // Handle File Uploads
        $fileKkName = null;
        if ($request->hasFile('file_kk')) {
            $file = $request->file('file_kk');
            $fileKkName = 'KK_REG_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/pasien');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $fileKkName);
        }

        $fileResumeName = null;
        if ($request->hasFile('file_resume')) {
            $file = $request->file('file_resume');
            $fileResumeName = 'RESUME_REG_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/pasien');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $fileResumeName);
        }

        $kodePendaftaran = PendaftaranPasien::generateKodePendaftaran();

        $pendaftaran = PendaftaranPasien::create([
            'kode_pendaftaran' => $kodePendaftaran,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'no_bpjs' => $request->no_bpjs,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jk,
            'status_menikah' => $request->status_menikah,
            'kewarganegaraan' => $request->kewarganegaraan ?: 'WNI',
            'cara_bayar' => $request->cara_bayar ?: 'Gratis',
            'alamat_lengkap' => $request->alamat_lengkap,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'kodepos' => $request->kodepos,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'desil' => $request->desil,
            'nama_wali' => $request->nama_wali,
            'hubungan_wali' => $request->hubungan_wali,
            'no_hp' => $request->no_hp,
            'layanan_terapi' => $request->layanan_terapi,
            'tgl_rencana_kunjungan' => $request->tgl_rencana_kunjungan,
            'jam_rencana_kunjungan' => $request->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)',
            'jenis_disabilitas' => $disabilitas,
            'alat_bantu' => $alat,
            'keluhan_utama' => $request->keluhan_utama,
            'upt_lokasi' => $request->upt_lokasi ?: 'UPT PPSAB Sidoarjo',
            'file_kk' => $fileKkName,
            'file_resume' => $fileResumeName,
            'status' => 'menunggu',
        ]);

        // Kirim notifikasi realtime & in-app ke Petugas Pendaftaran & Admin
        $this->notifyPetugasPendaftaranBaru($pendaftaran);

        // Berikan izin otorisasi cetak pada sesi pendaftar saat ini
        Session::put('portal_auth_reg_' . $kodePendaftaran, true);
        Session::put('portal_auth_reg_contact_' . $kodePendaftaran, $pendaftaran->no_hp);

        $cetakToken = self::generatePendaftaranToken($pendaftaran);
        $cetakUrl = route('portal.pendaftaran.cetak', ['kode' => $kodePendaftaran, 'token' => $cetakToken]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'kode_pendaftaran' => $kodePendaftaran,
                'nama' => $pendaftaran->nama,
                'layanan_terapi' => $pendaftaran->layanan_terapi,
                'tgl_rencana' => $pendaftaran->tgl_rencana_kunjungan ? Carbon::parse($pendaftaran->tgl_rencana_kunjungan)->isoFormat('D MMMM Y') : '-',
                'jam_rencana' => $pendaftaran->jam_rencana_kunjungan,
                'cetak_token' => $cetakToken,
                'cetak_url' => $cetakUrl,
                'message' => 'Pendaftaran penerima manfaat baru berhasil dikirim! Silakan simpan dan cetak bukti pendaftaran Anda.',
            ]);
        }

        return redirect()->route('portal.index')
            ->with('pendaftaran_success', true)
            ->with('kode_pendaftaran', $kodePendaftaran)
            ->with('nama_pasien', $pendaftaran->nama)
            ->with('layanan_terapi', $pendaftaran->layanan_terapi)
            ->with('tgl_rencana', $pendaftaran->tgl_rencana_kunjungan ? Carbon::parse($pendaftaran->tgl_rencana_kunjungan)->isoFormat('D MMMM Y') : '-')
            ->with('jam_rencana', $pendaftaran->jam_rencana_kunjungan)
            ->with('nama_wali', $pendaftaran->nama_wali)
            ->with('no_hp', $pendaftaran->no_hp)
            ->with('cetak_token', $cetakToken)
            ->with('cetak_url', $cetakUrl);
    }

    /**
     * Helper Generator Token HMAC Kriptografis untuk Akses Cetak Dokumen Pendaftaran
     */
    public static function generatePendaftaranToken(PendaftaranPasien $pendaftaran): string
    {
        $key = config('app.key') ?: 'omah-terapiku-secret-salt-2026';
        $contact = $pendaftaran->no_hp ?: ($pendaftaran->nik ?: ($pendaftaran->nama ?? ''));
        $salt = ($pendaftaran->created_at ? $pendaftaran->created_at->timestamp : '') . '|' . $contact;
        return substr(hash_hmac('sha256', $pendaftaran->kode_pendaftaran . '|' . $salt, $key), 0, 32);
    }

    /**
     * Helper Generator Token HMAC Kriptografis untuk Akses Cetak Dokumen Booking Sesi
     */
    public static function generateBookingToken(BookingSesi $booking): string
    {
        $key = config('app.key') ?: 'omah-terapiku-secret-salt-2026';
        $contact = $booking->pasien ? ($booking->pasien->no_hp ?: ($booking->pasien->nik ?: $booking->pasien->no_rm)) : '';
        $salt = ($booking->created_at ? $booking->created_at->timestamp : '') . '|' . $contact;
        return substr(hash_hmac('sha256', $booking->kode_booking . '|' . $salt, $key), 0, 32);
    }

    /**
     * Helper Validasi Otorisasi Akses Cetak Pendaftaran (Anti-IDOR / URL Tampering)
     */
    private function canAccessPendaftaran(PendaftaranPasien $pendaftaran, Request $request): bool
    {
        // 1. Staf backoffice login (Admin, Pendaftaran, Dokter)
        if (Auth::check()) {
            return true;
        }

        // 2. Token HMAC pada URL query parameter (?token=...)
        $token = $request->input('token');
        if (!empty($token) && hash_equals(self::generatePendaftaranToken($pendaftaran), (string)$token)) {
            return true;
        }

        // 3. Verifikasi Kontak pada URL query parameter (?no_hp=... atau ?nik=...)
        $queryContact = trim($request->input('no_hp', $request->input('nik', '')));
        if (!empty($queryContact)) {
            $cleanQuery = preg_replace('/\D/', '', $queryContact);
            $cleanHp = preg_replace('/\D/', '', $pendaftaran->no_hp ?: '');
            $cleanNik = preg_replace('/\D/', '', $pendaftaran->nik ?: '');
            if (($cleanQuery !== '' && ($cleanQuery === $cleanHp || $cleanQuery === $cleanNik)) ||
                (strcasecmp($queryContact, $pendaftaran->no_hp) === 0 || strcasecmp($queryContact, $pendaftaran->nik) === 0)) {
                return true;
            }
        }

        // 4. Izin Sesi Pendaftar / Pelacakan
        if (Session::get('portal_auth_reg_' . $pendaftaran->kode_pendaftaran) === true) {
            return true;
        }

        // 5. Pasien yang Sedang Login di Portal Pasien
        $portalPasienId = Session::get('portal_pasien_id');
        if ($portalPasienId) {
            $portalPasien = Pasien::find($portalPasienId);
            if ($portalPasien) {
                // Kecocokan No. RM
                if (!empty($pendaftaran->no_rm_diterbitkan) && strcasecmp($pendaftaran->no_rm_diterbitkan, $portalPasien->no_rm) === 0) {
                    return true;
                }
                // Kecocokan ID Pasien
                if (!empty($pendaftaran->pasien_id) && (int)$pendaftaran->pasien_id === (int)$portalPasien->id) {
                    return true;
                }
                // Kecocokan NIK / No. HP
                $cleanPasienHp = preg_replace('/\D/', '', $portalPasien->no_hp ?: '');
                $cleanPasienNik = preg_replace('/\D/', '', $portalPasien->nik ?: '');
                $cleanRegHp = preg_replace('/\D/', '', $pendaftaran->no_hp ?: '');
                $cleanRegNik = preg_replace('/\D/', '', $pendaftaran->nik ?: '');

                if ($cleanPasienNik !== '' && $cleanPasienNik === $cleanRegNik) {
                    return true;
                }
                if ($cleanPasienHp !== '' && $cleanPasienHp === $cleanRegHp) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Helper Validasi Otorisasi Akses Cetak Booking Sesi (Anti-IDOR / URL Tampering)
     */
    private function canAccessBooking(BookingSesi $booking, Request $request): bool
    {
        // 1. Staf backoffice login (Admin, Pendaftaran, Dokter)
        if (Auth::check()) {
            return true;
        }

        // 2. Token HMAC pada URL query parameter (?token=...)
        $token = $request->input('token');
        if (!empty($token) && hash_equals(self::generateBookingToken($booking), (string)$token)) {
            return true;
        }

        // 3. Verifikasi Kontak pada URL query parameter (?no_hp=... atau ?nik=...)
        $queryContact = trim($request->input('no_hp', $request->input('nik', '')));
        if (!empty($queryContact) && $booking->pasien) {
            $cleanQuery = preg_replace('/\D/', '', $queryContact);
            $cleanHp = preg_replace('/\D/', '', $booking->pasien->no_hp ?: '');
            $cleanNik = preg_replace('/\D/', '', $booking->pasien->nik ?: '');
            if (($cleanQuery !== '' && ($cleanQuery === $cleanHp || $cleanQuery === $cleanNik)) ||
                (strcasecmp($queryContact, $booking->pasien->no_hp) === 0 || strcasecmp($queryContact, $booking->pasien->nik) === 0)) {
                return true;
            }
        }

        // 4. Izin Sesi Booking / Pelacakan
        if (Session::get('portal_auth_bkg_' . $booking->kode_booking) === true) {
            return true;
        }

        // 5. Pasien yang Sedang Login di Portal Pasien
        $portalPasienId = Session::get('portal_pasien_id');
        if ($portalPasienId) {
            $portalPasien = Pasien::find($portalPasienId);
            if ($portalPasien) {
                if ((int)$booking->pasien_id === (int)$portalPasien->id) {
                    return true;
                }
                if ($booking->pasien && strcasecmp($booking->pasien->no_rm, $portalPasien->no_rm) === 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Cetak Lembar Bukti Pendaftaran Penerima Manfaat Baru Online (Struk/PDF)
     */
    public function cetakBuktiPendaftaran($kode, Request $request)
    {
        $pendaftaran = PendaftaranPasien::with(['terapis', 'pasien', 'verifier'])
            ->where('kode_pendaftaran', $kode)
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('portal.index')
                ->with('gagal', 'Dokumen Pendaftaran "' . htmlspecialchars($kode) . '" tidak ditemukan. Mohon pastikan nomor registrasi yang Anda masukkan sudah benar.');
        }

        // Proteksi Otorisasi Anti-IDOR
        if (!$this->canAccessPendaftaran($pendaftaran, $request)) {
            return redirect()->route('portal.index')
                ->with('gagal', 'Akses Ditolak: Dokumen pendaftaran ' . htmlspecialchars($kode) . ' bersifat rahasia. Silakan lakukan verifikasi melalui tab Lacak Status dengan memasukkan Nomor HP atau NIK yang terdaftar.');
        }

        $upt = Poli::where('nama', $pendaftaran->upt_lokasi)->first();

        return view('portal.cetak_pendaftaran', compact('pendaftaran', 'upt'));
    }

    /**
     * Cetak Lembar Bukti Reservasi Sesi Terapi (Struk/PDF)
     */
    public function cetakBuktiBooking($kode, Request $request)
    {
        $booking = BookingSesi::with(['pasien', 'dokter', 'verifier', 'rekam'])
            ->where('kode_booking', $kode)
            ->first();

        if (!$booking) {
            return redirect()->route('portal.index')
                ->with('gagal', 'Dokumen Reservasi Booking "' . htmlspecialchars($kode) . '" tidak ditemukan. Mohon pastikan kode booking yang Anda masukkan sudah benar.');
        }

        // Proteksi Otorisasi Anti-IDOR
        if (!$this->canAccessBooking($booking, $request)) {
            return redirect()->route('portal.index')
                ->with('gagal', 'Akses Ditolak: Dokumen booking ' . htmlspecialchars($kode) . ' bersifat rahasia. Silakan masuk ke Portal Pasien atau lakukan verifikasi melalui tab Lacak Status.');
        }

        $upt = Poli::where('nama', $booking->upt_lokasi)->first();
        if (!$upt && $booking->pasien) {
            $upt = Poli::where('nama', $booking->pasien->upt_lokasi)->first();
        }

        return view('portal.cetak_booking', compact('booking', 'upt'));
    }

    /**
     * Lacak Status Pendaftaran Baru, Booking Sesi Terapi, atau No. Rekam Medis (No. RM)
     */
    public function lacakStatus(Request $request)
    {
        $kode = trim($request->input('kode', ''));
        $noHp = trim($request->input('no_hp', ''));
        $keyword = trim($request->input('keyword', ''));

        if (empty($kode) && !empty($keyword)) {
            $kode = $keyword;
        }

        if (empty($kode)) {
            return response()->json([
                'success' => false,
                'message' => 'Harap masukkan Nomor Registrasi, No. RM, atau Kode Booking Anda.',
            ]);
        }

        if (empty($noHp)) {
            return response()->json([
                'success' => false,
                'message' => 'Harap masukkan Nomor HP atau NIK yang terdaftar untuk verifikasi data.',
            ]);
        }

        // Pembersihan karakter non-digit untuk pencocokan nomor telepon/NIK
        $cleanInput = preg_replace('/\D/', '', $noHp);

        // Helper closure untuk verifikasi kecocokan kontak
        $checkContactMatch = function ($entity) use ($noHp, $cleanInput) {
            if (!$entity) return false;
            $dbHp = $entity->no_hp ?? '';
            $dbNik = $entity->nik ?? '';
            $dbBpjs = $entity->no_bpjs ?? '';
            $dbRm = $entity->no_rm ?? ($entity->no_rm_diterbitkan ?? '');

            // 1. Direct string match
            if (strcasecmp($dbHp, $noHp) === 0 || strcasecmp($dbNik, $noHp) === 0 || strcasecmp($dbBpjs, $noHp) === 0 || strcasecmp($dbRm, $noHp) === 0) {
                return true;
            }

            // 2. Numeric / cleaned match
            if (!empty($cleanInput)) {
                $cleanDbHp = preg_replace('/\D/', '', $dbHp);
                $cleanDbNik = preg_replace('/\D/', '', $dbNik);
                $cleanDbBpjs = preg_replace('/\D/', '', $dbBpjs);

                if ($cleanInput === $cleanDbHp || $cleanInput === $cleanDbNik || $cleanInput === $cleanDbBpjs) {
                    return true;
                }
                if (strlen($cleanInput) >= 5 && strlen($cleanDbHp) >= 5 && (str_ends_with($cleanDbHp, $cleanInput) || str_ends_with($cleanInput, $cleanDbHp))) {
                    return true;
                }
                if (strlen($cleanInput) >= 8 && strlen($cleanDbNik) >= 8 && (str_ends_with($cleanDbNik, $cleanInput) || str_ends_with($cleanInput, $cleanDbNik))) {
                    return true;
                }
            }
            return false;
        };

        // ---------------------------------------------------------------------
        // 1. CEK BERDASARKAN NOMOR REKAM MEDIS (No. RM) ATAU NIK PASIEN (OTK-...)
        // ---------------------------------------------------------------------
        $pasien = Pasien::with([
            'pendaftaran.terapis',
            'bookings' => function ($q) {
                $q->with('dokter')->latest();
            },
            'rekams' => function ($q) {
                $q->with('dokter')->latest('tgl_rekam');
            }
        ])->where(function ($q) use ($kode) {
            $q->where('no_rm', $kode)
              ->orWhereRaw('LOWER(no_rm) = ?', [strtolower($kode)]);
        })->first();

        if ($pasien) {
            if (!$checkContactMatch($pasien)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor HP atau NIK yang Anda masukkan tidak cocok dengan data No. Rekam Medis ' . $pasien->no_rm . '. Silakan periksa kembali.',
                ]);
            }

            // Otorisasi dokumen terkait pasien ini untuk sesi saat ini
            $latestBooking = $pasien->bookings->first();
            $pendaftaran = $pasien->pendaftaran ?: PendaftaranPasien::where('no_rm_diterbitkan', $pasien->no_rm)->latest()->first();

            if ($pendaftaran) {
                Session::put('portal_auth_reg_' . $pendaftaran->kode_pendaftaran, true);
            }
            foreach ($pasien->bookings as $bkg) {
                Session::put('portal_auth_bkg_' . $bkg->kode_booking, true);
            }

            $bkgToken = $latestBooking ? self::generateBookingToken($latestBooking) : null;
            $regToken = $pendaftaran ? self::generatePendaftaranToken($pendaftaran) : null;

            return response()->json([
                'success' => true,
                'pasien' => [
                    'id' => $pasien->id,
                    'no_rm' => $pasien->no_rm,
                    'nama' => $pasien->nama,
                    'nik' => $pasien->nik ?: '-',
                    'no_hp' => $pasien->no_hp ?: '-',
                    'upt_lokasi' => $pasien->upt_lokasi ?: 'UPT RSBN Malang',
                    'status_text' => $pasien->statusPasien(),
                    'total_sesi' => $pasien->rekams->count(),
                    'sesi_terakhir' => $pasien->rekams->first() && $pasien->rekams->first()->tgl_rekam ? Carbon::parse($pasien->rekams->first()->tgl_rekam)->isoFormat('D MMMM Y') : null,
                    'terapis_terakhir' => ($pasien->rekams->first() && $pasien->rekams->first()->dokter) ? $pasien->rekams->first()->dokter->nama : null,
                ],
                'booking' => $latestBooking ? [
                    'kode' => $latestBooking->kode_booking,
                    'nama_pasien' => $pasien->nama,
                    'no_rm' => $pasien->no_rm,
                    'no_hp' => $pasien->no_hp,
                    'layanan' => $latestBooking->layanan_terapi,
                    'tgl_rencana' => Carbon::parse($latestBooking->tgl_rencana)->isoFormat('D MMMM Y'),
                    'status' => $latestBooking->status,
                    'status_badge' => $latestBooking->status_badge,
                    'terapis' => $latestBooking->dokter ? $latestBooking->dokter->nama : 'Belum Ditugaskan',
                    'jam_sesi' => $latestBooking->jam_sesi ?: 'Sesuai Antrean Kedatangan',
                    'catatan' => $latestBooking->catatan_petugas,
                    'cetak_token' => $bkgToken,
                    'cetak_url' => route('portal.booking.cetak', ['kode' => $latestBooking->kode_booking, 'token' => $bkgToken]),
                ] : null,
                'pendaftaran' => $pendaftaran ? [
                    'kode' => $pendaftaran->kode_pendaftaran,
                    'nama' => $pendaftaran->nama,
                    'nik' => $pendaftaran->nik ?: '-',
                    'no_hp' => $pendaftaran->no_hp ?: '-',
                    'layanan_terapi' => $pendaftaran->layanan_terapi ?: 'Layanan Terapi Terpadu',
                    'tgl_rencana' => $pendaftaran->tgl_rencana_kunjungan ? Carbon::parse($pendaftaran->tgl_rencana_kunjungan)->isoFormat('D MMMM Y') : '-',
                    'jam_rencana' => $pendaftaran->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)',
                    'tgl_daftar' => $pendaftaran->created_at->isoFormat('D MMMM Y, HH:mm'),
                    'status' => $pendaftaran->status,
                    'status_badge' => $pendaftaran->status_badge,
                    'no_rm' => $pendaftaran->no_rm_diterbitkan ?: $pasien->no_rm,
                    'terapis_nama' => $pendaftaran->terapis ? $pendaftaran->terapis->nama : null,
                    'tgl_sesi_disetujui' => $pendaftaran->tgl_sesi_disetujui ? Carbon::parse($pendaftaran->tgl_sesi_disetujui)->isoFormat('D MMMM Y') : null,
                    'jam_sesi_disetujui' => $pendaftaran->jam_sesi_disetujui,
                    'catatan' => $pendaftaran->catatan_petugas,
                    'upt_lokasi' => $pendaftaran->upt_lokasi ?: 'UPT RSBN Malang',
                    'cetak_token' => $regToken,
                    'cetak_url' => route('portal.pendaftaran.cetak', ['kode' => $pendaftaran->kode_pendaftaran, 'token' => $regToken]),
                ] : null,
            ]);
        }

        // ---------------------------------------------------------------------
        // 2. CEK PENDAFTARAN PASIEN BARU ONLINE (REG-...)
        // ---------------------------------------------------------------------
        $pendaftaran = PendaftaranPasien::with(['terapis', 'pasien'])
            ->where(function ($q) use ($kode) {
                $q->where('kode_pendaftaran', $kode)
                  ->orWhereRaw('LOWER(kode_pendaftaran) = ?', [strtolower($kode)])
                  ->orWhere('no_rm_diterbitkan', $kode);
            })
            ->latest()
            ->first();

        if ($pendaftaran) {
            if (!$checkContactMatch($pendaftaran)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor HP atau NIK yang Anda masukkan tidak cocok dengan data Nomor Registrasi ' . $pendaftaran->kode_pendaftaran . '. Silakan periksa kembali.',
                ]);
            }

            // Otorisasi dokumen pendaftaran untuk sesi saat ini
            Session::put('portal_auth_reg_' . $pendaftaran->kode_pendaftaran, true);
            $regToken = self::generatePendaftaranToken($pendaftaran);

            return response()->json([
                'success' => true,
                'pasien' => null,
                'pendaftaran' => [
                    'kode' => $pendaftaran->kode_pendaftaran,
                    'nama' => $pendaftaran->nama,
                    'nik' => $pendaftaran->nik ?: '-',
                    'no_hp' => $pendaftaran->no_hp ?: '-',
                    'layanan_terapi' => $pendaftaran->layanan_terapi ?: 'Layanan Terapi Terpadu',
                    'tgl_rencana' => $pendaftaran->tgl_rencana_kunjungan ? Carbon::parse($pendaftaran->tgl_rencana_kunjungan)->isoFormat('D MMMM Y') : '-',
                    'jam_rencana' => $pendaftaran->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)',
                    'tgl_daftar' => $pendaftaran->created_at->isoFormat('D MMMM Y, HH:mm'),
                    'status' => $pendaftaran->status,
                    'status_badge' => $pendaftaran->status_badge,
                    'no_rm' => $pendaftaran->no_rm_diterbitkan,
                    'terapis_nama' => $pendaftaran->terapis ? $pendaftaran->terapis->nama : null,
                    'tgl_sesi_disetujui' => $pendaftaran->tgl_sesi_disetujui ? Carbon::parse($pendaftaran->tgl_sesi_disetujui)->isoFormat('D MMMM Y') : null,
                    'jam_sesi_disetujui' => $pendaftaran->jam_sesi_disetujui,
                    'catatan' => $pendaftaran->catatan_petugas,
                    'upt_lokasi' => $pendaftaran->upt_lokasi ?: 'UPT RSBN Malang',
                    'cetak_token' => $regToken,
                    'cetak_url' => route('portal.pendaftaran.cetak', ['kode' => $pendaftaran->kode_pendaftaran, 'token' => $regToken]),
                ],
                'booking' => null,
            ]);
        }

        // ---------------------------------------------------------------------
        // 3. CEK BOOKING SESI TERAPI (BKG-...)
        // ---------------------------------------------------------------------
        $booking = BookingSesi::with(['pasien', 'dokter'])
            ->where(function ($q) use ($kode) {
                $q->where('kode_booking', $kode)
                  ->orWhereRaw('LOWER(kode_booking) = ?', [strtolower($kode)]);
            })
            ->latest()
            ->first();

        if ($booking) {
            $pasien = $booking->pasien;
            if (!$checkContactMatch($pasien)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor HP atau NIK yang Anda masukkan tidak cocok dengan data Kode Booking ' . $booking->kode_booking . '. Silakan periksa kembali.',
                ]);
            }

            // Otorisasi dokumen booking untuk sesi saat ini
            Session::put('portal_auth_bkg_' . $booking->kode_booking, true);
            $bkgToken = self::generateBookingToken($booking);

            return response()->json([
                'success' => true,
                'pasien' => null,
                'pendaftaran' => null,
                'booking' => [
                    'kode' => $booking->kode_booking,
                    'nama_pasien' => $booking->pasien ? $booking->pasien->nama : '-',
                    'no_rm' => $booking->pasien ? $booking->pasien->no_rm : '-',
                    'no_hp' => $booking->pasien ? $booking->pasien->no_hp : '-',
                    'layanan' => $booking->layanan_terapi,
                    'tgl_rencana' => Carbon::parse($booking->tgl_rencana)->isoFormat('D MMMM Y'),
                    'status' => $booking->status,
                    'status_badge' => $booking->status_badge,
                    'terapis' => $booking->dokter ? $booking->dokter->nama : 'Belum Ditugaskan',
                    'jam_sesi' => $booking->jam_sesi ?: 'Sesuai Antrean Kedatangan',
                    'upt_lokasi' => $booking->upt_lokasi ?: ($booking->pasien ? $booking->pasien->upt_lokasi : 'UPT RSBN Malang'),
                    'catatan' => $booking->catatan_petugas,
                    'cetak_token' => $bkgToken,
                    'cetak_url' => route('portal.booking.cetak', ['kode' => $booking->kode_booking, 'token' => $bkgToken]),
                ],
            ]);
        }

        // 4. Jika Kode Registrasi / No. RM / Booking tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Nomor Registrasi / No. RM / Kode Booking "' . htmlspecialchars($kode) . '" tidak ditemukan. Mohon pastikan data yang Anda masukkan sudah benar.',
        ]);
    }

    /**
     * Submit Pengajuan Sesi Terapi Baru (Khusus Pasien Login di Portal)
     */
    public function storeBookingSesi(Request $request)
    {
        $pasienId = Session::get('portal_pasien_id');
        $pasien = Pasien::find($pasienId);

        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi portal Anda telah berakhir. Silakan verifikasi ulang.');
        }

        $this->validate($request, [
            'layanan_terapi' => 'required|string|max:100',
            'tgl_rencana' => 'required|date|after_or_equal:today',
            'jam_sesi' => 'nullable|string|max:100',
            'upt_lokasi' => 'nullable|string|max:191',
            'keluhan_catatan' => 'nullable|string|max:1000',
        ]);

        $kodeBooking = BookingSesi::generateKodeBooking();

        $booking = BookingSesi::create([
            'kode_booking' => $kodeBooking,
            'pasien_id' => $pasien->id,
            'layanan_terapi' => $request->layanan_terapi,
            'tgl_rencana' => $request->tgl_rencana,
            'jam_sesi' => $request->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)',
            'keluhan_catatan' => $request->keluhan_catatan,
            'status' => 'menunggu',
            'upt_lokasi' => $request->upt_lokasi ?: ($pasien->upt_lokasi ?: 'UPT RSBN Malang'),
        ]);

        // Kirim notifikasi realtime & in-app ke Petugas Pendaftaran & Admin
        $this->notifyPetugasBookingBaru($booking);

        // Berikan izin otorisasi cetak pada sesi booking yang baru diajukan
        Session::put('portal_auth_bkg_' . $kodeBooking, true);

        return redirect()->route('portal.booking')
            ->with('booking_success', true)
            ->with('kode_booking', $kodeBooking)
            ->with('sukses', "Permohonan booking sesi terapi dengan kode {$kodeBooking} berhasil diajukan! Anda dapat memantau status persetujuan terapis secara langsung di halaman ini.");
    }

    // =========================================================================
    // MODUL BACKOFFICE (ADMIN & PETUGAS)
    // =========================================================================

    /**
     * Daftar Antrean Verifikasi Pasien Baru Online
     */
    public function indexPasienBaru(Request $request)
    {
        $selectedUpt = $request->get('upt', session('dashboard_upt', 'all'));
        $activeUpts = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        $query = PendaftaranPasien::with(['terapis', 'pasien', 'verifier']);

        // 1. Filter UPT
        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $query->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
        }

        // 2. Filter Status
        if ($request->has('status') && in_array($request->status, ['menunggu', 'disetujui', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // 3. Filter Layanan Terapi
        if ($request->has('layanan') && !empty($request->layanan)) {
            $query->where('layanan_terapi', 'LIKE', "%{$request->layanan}%");
        }

        // 4. Keyword Search
        if ($request->has('keyword') && !empty($request->keyword)) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('kode_pendaftaran', 'LIKE', "%{$kw}%")
                    ->orWhere('nama', 'LIKE', "%{$kw}%")
                    ->orWhere('nik', 'LIKE', "%{$kw}%")
                    ->orWhere('no_bpjs', 'LIKE', "%{$kw}%")
                    ->orWhere('nama_wali', 'LIKE', "%{$kw}%")
                    ->orWhere('no_hp', 'LIKE', "%{$kw}%")
                    ->orWhere('no_rm_diterbitkan', 'LIKE', "%{$kw}%")
                    ->orWhere('alamat_lengkap', 'LIKE', "%{$kw}%");
            });
        }

        // 5. Limit Per Page
        $perPageInput = $request->get('per_page', 10);
        if ($perPageInput === 'all') {
            $perPage = 1000;
        } else {
            $perPage = (int) $perPageInput;
            if ($perPage <= 0) {
                $perPage = 10;
            }
        }

        $pendaftarans = $query->latest()->paginate($perPage);

        // Counts based on UPT
        $countQuery = PendaftaranPasien::query();
        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $countQuery->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
        }
        $counts = [
            'total' => (clone $countQuery)->count(),
            'menunggu' => (clone $countQuery)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $countQuery)->where('status', 'disetujui')->count(),
            'ditolak' => (clone $countQuery)->where('status', 'ditolak')->count(),
        ];

        $dokters = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();
        $polis = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        $hasFilters = ($request->filled('keyword') || 
                       $request->filled('status') || 
                       $request->filled('layanan') || 
                       ($selectedUpt && $selectedUpt !== 'all') || 
                       ($request->filled('per_page') && $request->per_page != '10'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('pendaftaran.partial.table', compact('pendaftarans'))->render(),
                'total' => $pendaftarans->total(),
                'first_item' => $pendaftarans->firstItem() ?: 0,
                'last_item' => $pendaftarans->lastItem() ?: 0,
                'counts' => $counts,
                'has_filters' => $hasFilters,
                'export_url' => route('pendaftaran.export-csv', $request->all()),
            ]);
        }

        return view('pendaftaran.index', compact('pendaftarans', 'counts', 'dokters', 'polis', 'activeUpts', 'selectedUpt'));
    }

    /**
     * Export Data Pendaftaran Pasien Baru ke File CSV
     */
    public function exportCsvPasienBaru(Request $request)
    {
        $selectedUpt = $request->get('upt', session('dashboard_upt', 'all'));
        $query = PendaftaranPasien::with(['terapis', 'pasien', 'verifier']);

        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $query->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
        }
        if ($request->has('status') && in_array($request->status, ['menunggu', 'disetujui', 'ditolak'])) {
            $query->where('status', $request->status);
        }
        if ($request->has('layanan') && !empty($request->layanan)) {
            $query->where('layanan_terapi', 'LIKE', "%{$request->layanan}%");
        }
        if ($request->has('keyword') && !empty($request->keyword)) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('kode_pendaftaran', 'LIKE', "%{$kw}%")
                    ->orWhere('nama', 'LIKE', "%{$kw}%")
                    ->orWhere('nik', 'LIKE', "%{$kw}%")
                    ->orWhere('no_bpjs', 'LIKE', "%{$kw}%")
                    ->orWhere('nama_wali', 'LIKE', "%{$kw}%")
                    ->orWhere('no_hp', 'LIKE', "%{$kw}%")
                    ->orWhere('no_rm_diterbitkan', 'LIKE', "%{$kw}%")
                    ->orWhere('alamat_lengkap', 'LIKE', "%{$kw}%");
            });
        }

        $records = $query->latest()->get();

        $filename = 'Data_Pendaftaran_Online_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No',
                'Kode Registrasi',
                'Tanggal Mendaftar',
                'Nama Calon Penerima Manfaat',
                'NIK',
                'No. BPJS/KIS',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Nama Orang Tua / Wali',
                'Hubungan Wali',
                'No. HP / WhatsApp',
                'Alamat Lengkap',
                'Kelurahan/Desa',
                'Kecamatan',
                'Kabupaten/Kota',
                'Desil',
                'Ragam Disabilitas',
                'Alat Bantu',
                'Layanan Terapi Pilihan',
                'Rencana Tanggal Kunjungan',
                'Sesi Jam Kunjungan',
                'Keluhan Utama',
                'Pilihan Lokasi UPT',
                'Status Verifikasi',
                'No. RM Resmi Diterbitkan',
                'Terapis Penanggung Jawab',
                'Tanggal Sesi Terapi Disetujui',
                'Catatan Petugas',
            ]);

            foreach ($records as $idx => $r) {
                fputcsv($file, [
                    $idx + 1,
                    $r->kode_pendaftaran,
                    $r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-',
                    $r->nama,
                    $r->nik ? "'{$r->nik}" : '-',
                    $r->no_bpjs ? "'{$r->no_bpjs}" : '-',
                    $r->jk ?: '-',
                    $r->tmp_lahir ?: '-',
                    $r->tgl_lahir ?: '-',
                    $r->nama_wali ?: '-',
                    $r->hubungan_wali ?: '-',
                    $r->no_hp ? "'{$r->no_hp}" : '-',
                    $r->alamat_lengkap ?: '-',
                    $r->kelurahan ?: '-',
                    $r->kecamatan ?: '-',
                    $r->kabupaten ?: '-',
                    $r->desil ?: '-',
                    $r->jenis_disabilitas ?: '-',
                    $r->alat_bantu ?: '-',
                    $r->layanan_terapi ?: '-',
                    $r->tgl_rencana_kunjungan ?: '-',
                    $r->jam_rencana_kunjungan ?: '-',
                    $r->keluhan_utama ?: '-',
                    $r->upt_lokasi ?: '-',
                    strtoupper($r->status),
                    $r->no_rm_diterbitkan ?: '-',
                    $r->terapis ? $r->terapis->nama : '-',
                    $r->tgl_sesi_disetujui ?: '-',
                    $r->catatan_petugas ?: '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Detail Data Pendaftaran Baru (JSON untuk Modal Preview)
     */
    public function showPasienBaru($id)
    {
        $pendaftaran = PendaftaranPasien::with(['verifier', 'pasien', 'terapis', 'rekam'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $pendaftaran,
            'status_badge' => $pendaftaran->status_badge,
            'file_kk_url' => $pendaftaran->file_kk ? asset('images/pasien/' . $pendaftaran->file_kk) : null,
            'file_resume_url' => $pendaftaran->file_resume ? asset('images/pasien/' . $pendaftaran->file_resume) : null,
            'tgl_daftar_formatted' => $pendaftaran->created_at->isoFormat('D MMMM Y, HH:mm'),
            'tgl_lahir_formatted' => $pendaftaran->tgl_lahir ? Carbon::parse($pendaftaran->tgl_lahir)->isoFormat('D MMMM Y') : '-',
            'tgl_rencana_formatted' => $pendaftaran->tgl_rencana_kunjungan ? Carbon::parse($pendaftaran->tgl_rencana_kunjungan)->isoFormat('D MMMM Y') : '-',
            'tgl_sesi_disetujui_formatted' => $pendaftaran->tgl_sesi_disetujui ? Carbon::parse($pendaftaran->tgl_sesi_disetujui)->isoFormat('D MMMM Y') : '-',
            'terapis_nama' => $pendaftaran->terapis ? $pendaftaran->terapis->nama : '-',
        ]);
    }

    /**
     * Setujui Pendaftaran Pasien Baru -> Tentukan Terapis, Jadwal Sesi Pertama, Terbitkan No. RM Resmi & Buat Rekam Medis
     */
    public function approvePasienBaru(Request $request, $id)
    {
        $this->validate($request, [
            'dokter_id' => 'required|exists:terapis,id',
            'tgl_sesi' => 'required|date',
            'jam_sesi' => 'nullable|string|max:100',
            'layanan_terapi' => 'nullable|string|max:191',
            'catatan_petugas' => 'nullable|string|max:500',
        ]);

        $pendaftaran = PendaftaranPasien::findOrFail($id);

        if ($pendaftaran->status === 'disetujui') {
            return redirect()->back()->with('gagal', 'Pendaftaran ini sudah disetujui sebelumnya.');
        }

        return DB::transaction(function () use ($request, $pendaftaran) {
            // 1. Cek / Buat record resmi di tabel pasien (Master Pasien)
            $pasien = null;
            if ($pendaftaran->pasien_id) {
                $pasien = Pasien::find($pendaftaran->pasien_id);
            }

            if (!$pasien) {
                $noRm = Pasien::generateNoRM();
                $pasien = Pasien::create([
                    'no_rm' => $noRm,
                    'nama' => $pendaftaran->nama,
                    'nik' => $pendaftaran->nik,
                    'no_bpjs' => $pendaftaran->no_bpjs,
                    'tmp_lahir' => $pendaftaran->tmp_lahir,
                    'tgl_lahir' => $pendaftaran->tgl_lahir,
                    'jk' => $pendaftaran->jk,
                    'status_menikah' => $pendaftaran->status_menikah ?: 'Belum Menikah',
                    'agama' => $pendaftaran->agama ?: 'Islam',
                    'pendidikan' => $pendaftaran->pendidikan ?: 'Tidak Sekolah',
                    'pekerjaan' => $pendaftaran->pekerjaan ?: 'Pelajar/Mahasiswa',
                    'kewarganegaraan' => $pendaftaran->kewarganegaraan ?: 'WNI',
                    'cara_bayar' => $pendaftaran->cara_bayar ?: ($pendaftaran->no_bpjs ? 'BPJS/KIS' : 'Gratis'),
                    'alamat_lengkap' => $pendaftaran->alamat_lengkap,
                    'kelurahan' => $pendaftaran->kelurahan,
                    'kecamatan' => $pendaftaran->kecamatan,
                    'kabupaten' => $pendaftaran->kabupaten,
                    'kodepos' => $pendaftaran->kodepos,
                    'desil' => $pendaftaran->desil,
                    'upt_lokasi' => $pendaftaran->upt_lokasi ?: 'UPT PPSAB Sidoarjo',
                    'nama_wali' => $pendaftaran->nama_wali,
                    'hubungan_wali' => $pendaftaran->hubungan_wali,
                    'jenis_disabilitas' => $pendaftaran->jenis_disabilitas,
                    'alat_bantu' => $pendaftaran->alat_bantu,
                    'no_hp' => $pendaftaran->no_hp,
                    'file_kk' => $pendaftaran->file_kk,
                    'file_resume' => $pendaftaran->file_resume,
                ]);
            } else {
                $noRm = $pasien->no_rm;
            }

            $layanan = $request->layanan_terapi ?: ($pendaftaran->layanan_terapi ?: 'Layanan Terapi Terpadu');
            $tglSesi = $request->tgl_sesi ?: ($pendaftaran->tgl_rencana_kunjungan ?: date('Y-m-d'));
            $jamSesi = $request->jam_sesi ?: ($pendaftaran->jam_rencana_kunjungan ?: 'Sesi 1 (08.00 - 08.45 WIB)');

            // Generate No. Registrasi Rekam Medis unik
            $noRekam = "REG#" . date('Ymd') . $pasien->id;
            $existingCount = Rekam::where('no_rekam', 'LIKE', $noRekam . '%')->count();
            if ($existingCount > 0) {
                $noRekam .= "_" . ($existingCount + 1);
            }

            // 2. Buat record Sesi Rekam Medis Pertama otomatis
            $rekam = Rekam::create([
                'no_rekam' => $noRekam,
                'pasien_id' => $pasien->id,
                'dokter_id' => $request->dokter_id,
                'petugas_id' => Auth::id() ?: 1,
                'poli' => $pendaftaran->upt_lokasi ?: 'UPT RSBN Malang',
                'upt_lokasi' => $pendaftaran->upt_lokasi ?: 'UPT RSBN Malang',
                'tgl_rekam' => $tglSesi,
                'layanan_terapi' => $layanan,
                'sesi_waktu' => $jamSesi,
                'keluhan' => $pendaftaran->keluhan_utama ?: 'Pendaftaran Penerima Manfaat Baru Online',
                'status' => 1, // Status 1: Antrean
                'cara_bayar' => 'Gratis',
                'biaya_pemeriksaan' => 0,
                'biaya_dokter' => 0,
                'biaya_obat' => 0,
                'biaya_tindakan' => 0,
                'total_biaya' => 0,
            ]);

            $catatanPetugas = $request->filled('catatan_petugas') 
                ? trim($request->input('catatan_petugas')) 
                : 'Pendaftaran disetujui. Terapis dan jadwal sesi terapi pertama telah ditetapkan.';

            // 3. Update status pendaftaran
            $pendaftaran->update([
                'status' => 'disetujui',
                'catatan_petugas' => $catatanPetugas,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'pasien_id' => $pasien->id,
                'no_rm_diterbitkan' => $noRm,
                'terapis_id' => $request->dokter_id,
                'tgl_sesi_disetujui' => $tglSesi,
                'jam_sesi_disetujui' => $jamSesi,
                'rekam_id' => $rekam->id,
            ]);

            $terapis = Dokter::find($request->dokter_id);
            $terapisNama = $terapis ? $terapis->nama : 'Terapis';

            // Kirim notifikasi ke terapis yang ditugaskan
            $this->notifyTerapis($rekam, "Pasien baru {$pasien->nama} (No. RM: {$noRm}) telah disetujui dan ditugaskan ke Anda untuk sesi tanggal " . Carbon::parse($tglSesi)->isoFormat('D MMMM Y') . " ({$jamSesi}).");

            return redirect()->route('pendaftaran.index')
                ->with('sukses', "Pendaftaran {$pendaftaran->nama} berhasil disetujui! No. RM: {$noRm}, Terapis: {$terapisNama}, Jadwal Sesi: " . Carbon::parse($tglSesi)->isoFormat('D MMMM Y') . " ({$jamSesi})");
        });
    }

    /**
     * Tolak Pendaftaran Pasien Baru
     */
    public function rejectPasienBaru(Request $request, $id)
    {
        $this->validate($request, [
            'catatan_petugas' => 'required|string|max:500',
        ]);

        $pendaftaran = PendaftaranPasien::findOrFail($id);

        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan_petugas' => $request->catatan_petugas,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('sukses', "Pendaftaran {$pendaftaran->nama} telah ditolak dengan catatan: {$request->catatan_petugas}");
    }

    /**
     * Daftar Antrean Booking Sesi Terapi (Backoffice)
     */
    public function indexBookingSesi(Request $request)
    {
        $selectedUpt = $request->get('upt', session('dashboard_upt', 'all'));
        $activeUpts = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        $query = BookingSesi::with(['pasien', 'dokter', 'verifier', 'rekam']);

        // 1. Filter UPT
        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $query->where(function ($q) use ($selectedUpt) {
                $q->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%")
                  ->orWhereHas('pasien', function ($qp) use ($selectedUpt) {
                      $qp->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
                  });
            });
        }

        // 2. Filter Status
        if ($request->has('status') && in_array($request->status, ['menunggu', 'disetujui', 'ditolak', 'selesai'])) {
            $query->where('status', $request->status);
        }

        // 3. Filter Layanan
        if ($request->has('layanan') && !empty($request->layanan)) {
            $query->where('layanan_terapi', 'LIKE', "%{$request->layanan}%");
        }

        // 4. Keyword Search
        if ($request->has('keyword') && !empty($request->keyword)) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('kode_booking', 'LIKE', "%{$kw}%")
                    ->orWhere('keluhan_catatan', 'LIKE', "%{$kw}%")
                    ->orWhereHas('pasien', function ($qp) use ($kw) {
                        $qp->where('nama', 'LIKE', "%{$kw}%")
                            ->orWhere('no_rm', 'LIKE', "%{$kw}%")
                            ->orWhere('no_hp', 'LIKE', "%{$kw}%");
                    });
            });
        }

        // 5. Limit Per Page
        $perPageInput = $request->get('per_page', 10);
        if ($perPageInput === 'all') {
            $perPage = 1000;
        } else {
            $perPage = (int) $perPageInput;
            if ($perPage <= 0) {
                $perPage = 10;
            }
        }

        $bookings = $query->latest('tgl_rencana')->paginate($perPage);

        // Counts based on UPT
        $countQuery = BookingSesi::query();
        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $countQuery->where(function ($q) use ($selectedUpt) {
                $q->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%")
                  ->orWhereHas('pasien', function ($qp) use ($selectedUpt) {
                      $qp->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
                  });
            });
        }

        $counts = [
            'total' => (clone $countQuery)->count(),
            'menunggu' => (clone $countQuery)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $countQuery)->where('status', 'disetujui')->count(),
            'ditolak' => (clone $countQuery)->where('status', 'ditolak')->count(),
            'selesai' => (clone $countQuery)->where('status', 'selesai')->count(),
        ];

        $dokters = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();
        $polis = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        $hasFilters = ($request->filled('keyword') || 
                       $request->filled('status') || 
                       $request->filled('layanan') || 
                       ($selectedUpt && $selectedUpt !== 'all') || 
                       ($request->filled('per_page') && $request->per_page != '10'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('booking.partial.table', compact('bookings'))->render(),
                'total' => $bookings->total(),
                'first_item' => $bookings->firstItem() ?: 0,
                'last_item' => $bookings->lastItem() ?: 0,
                'counts' => $counts,
                'has_filters' => $hasFilters,
                'export_url' => route('booking.export-csv', $request->all()),
            ]);
        }

        return view('booking.index', compact('bookings', 'counts', 'dokters', 'polis', 'activeUpts', 'selectedUpt'));
    }

    /**
     * Export Data Permohonan Booking Sesi ke File CSV
     */
    public function exportCsvBookingSesi(Request $request)
    {
        $selectedUpt = $request->get('upt', session('dashboard_upt', 'all'));
        $query = BookingSesi::with(['pasien', 'dokter', 'verifier', 'rekam']);

        if ($selectedUpt && $selectedUpt !== 'all' && $selectedUpt !== '') {
            $query->where(function ($q) use ($selectedUpt) {
                $q->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%")
                  ->orWhereHas('pasien', function ($qp) use ($selectedUpt) {
                      $qp->where('upt_lokasi', 'LIKE', "%{$selectedUpt}%");
                  });
            });
        }
        if ($request->has('status') && in_array($request->status, ['menunggu', 'disetujui', 'ditolak', 'selesai'])) {
            $query->where('status', $request->status);
        }
        if ($request->has('layanan') && !empty($request->layanan)) {
            $query->where('layanan_terapi', 'LIKE', "%{$request->layanan}%");
        }
        if ($request->has('keyword') && !empty($request->keyword)) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('kode_booking', 'LIKE', "%{$kw}%")
                    ->orWhere('keluhan_catatan', 'LIKE', "%{$kw}%")
                    ->orWhereHas('pasien', function ($qp) use ($kw) {
                        $qp->where('nama', 'LIKE', "%{$kw}%")
                            ->orWhere('no_rm', 'LIKE', "%{$kw}%")
                            ->orWhere('no_hp', 'LIKE', "%{$kw}%");
                    });
            });
        }

        $records = $query->latest('tgl_rencana')->get();

        $filename = 'Data_Booking_Sesi_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No',
                'Kode Booking',
                'Waktu Pengajuan',
                'Nama Penerima Manfaat',
                'No. Rekam Medis',
                'No. HP / WhatsApp',
                'Layanan Terapi',
                'Rencana Tanggal Kunjungan',
                'Jam / Sesi Sesi',
                'Lokasi UPT',
                'Terapis Ditugaskan',
                'Status Permohonan',
                'Catatan Pasien',
                'Catatan Petugas',
            ]);

            foreach ($records as $idx => $r) {
                fputcsv($file, [
                    $idx + 1,
                    $r->kode_booking,
                    $r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-',
                    $r->pasien ? $r->pasien->nama : '-',
                    $r->pasien ? $r->pasien->no_rm : '-',
                    $r->pasien && $r->pasien->no_hp ? "'{$r->pasien->no_hp}" : '-',
                    $r->layanan_terapi ?: '-',
                    $r->tgl_rencana ?: '-',
                    $r->jam_sesi ?: '-',
                    $r->upt_lokasi ?: ($r->pasien ? $r->pasien->upt_lokasi : '-'),
                    $r->dokter ? $r->dokter->nama : '-',
                    strtoupper($r->status),
                    $r->keluhan_catatan ?: '-',
                    $r->catatan_petugas ?: '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Setujui Booking Sesi -> Tentukan Terapis & Otomatis Buat Sesi Rekam Medis
     */
    public function approveBookingSesi(Request $request, $id)
    {
        $this->validate($request, [
            'dokter_id' => 'required|exists:terapis,id',
            'jam_sesi' => 'nullable|string|max:50',
            'tgl_rekam' => 'required|date',
            'upt_lokasi' => 'nullable|string|max:191',
        ]);

        $booking = BookingSesi::with('pasien')->findOrFail($id);

        if ($booking->status === 'disetujui') {
            return redirect()->back()->with('gagal', 'Permohonan booking ini sudah disetujui.');
        }

        return DB::transaction(function () use ($request, $booking) {
            // Generate No. Registrasi Rekam Medis unik
            $noRekam = "REG#" . date('Ymd') . $booking->pasien_id;
            $existingCount = Rekam::where('no_rekam', 'LIKE', $noRekam . '%')->count();
            if ($existingCount > 0) {
                $noRekam .= "_" . ($existingCount + 1);
            }

            // 1. Buat record sesi rekam medis resmi
            $rekam = Rekam::create([
                'no_rekam' => $noRekam,
                'pasien_id' => $booking->pasien_id,
                'dokter_id' => $request->dokter_id,
                'petugas_id' => Auth::id() ?: 1,
                'poli' => $request->upt_lokasi ?: ($booking->pasien ? $booking->pasien->upt_lokasi : 'UPT RSBN Malang'),
                'upt_lokasi' => $request->upt_lokasi ?: ($booking->pasien ? $booking->pasien->upt_lokasi : 'UPT RSBN Malang'),
                'tgl_rekam' => $request->tgl_rekam,
                'layanan_terapi' => $booking->layanan_terapi,
                'sesi_waktu' => $request->jam_sesi ?: ($booking->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)'),
                'keluhan' => $booking->keluhan_catatan ?: 'Sesi terapi terjadwal via Booking Online',
                'status' => 1, // Status 1: Antrean
                'cara_bayar' => 'Gratis',
                'biaya_pemeriksaan' => 0,
                'biaya_dokter' => 0,
                'biaya_obat' => 0,
                'biaya_tindakan' => 0,
                'total_biaya' => 0,
            ]);

            // 2. Update status booking sesi
            $booking->update([
                'status' => 'disetujui',
                'dokter_id' => $request->dokter_id,
                'jam_sesi' => $request->jam_sesi ?: ($booking->jam_sesi ?: 'Sesi 1 (08.00 - 08.45 WIB)'),
                'upt_lokasi' => $request->upt_lokasi ?: $rekam->upt_lokasi,
                'rekam_id' => $rekam->id,
                'catatan_petugas' => $request->input('catatan_petugas', 'Jadwal sesi terapi telah dikonfirmasi oleh petugas.'),
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Kirim notifikasi ke terapis yang ditugaskan
            $this->notifyTerapis($rekam, "Booking sesi terapi {$booking->pasien->nama} ({$booking->kode_booking}) telah disetujui dan ditugaskan ke Anda untuk tanggal " . Carbon::parse($rekam->tgl_rekam)->isoFormat('D MMMM Y') . " ({$rekam->sesi_waktu}).");

            return redirect()->route('booking.index')
                ->with('sukses', "Booking sesi {$booking->pasien->nama} ({$booking->kode_booking}) berhasil disetujui & rekam sesi otomatis terbuat!");
        });
    }

    /**
     * Tolak Booking Sesi Terapi
     */
    public function rejectBookingSesi(Request $request, $id)
    {
        $this->validate($request, [
            'catatan_petugas' => 'required|string|max:500',
        ]);

        $booking = BookingSesi::with('pasien')->findOrFail($id);

        $booking->update([
            'status' => 'ditolak',
            'catatan_petugas' => $request->catatan_petugas,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('booking.index')
            ->with('sukses', "Permohonan booking ({$booking->kode_booking}) telah ditolak dengan catatan: {$request->catatan_petugas}");
    }

    // =========================================================================
    // NOTIFICATION HELPERS
    // =========================================================================

    /**
     * Kirim notifikasi ke semua Petugas Pendaftaran & Admin aktif saat ada pendaftaran baru
     */
    private function notifyPetugasPendaftaranBaru($pendaftaran)
    {
        try {
            $petugasUsers = User::whereIn('role', [1, 2])->where('status', 1)->get();
            if ($petugasUsers->isNotEmpty()) {
                $notif = new PendaftaranBaruNotification($pendaftaran);
                Notification::send($petugasUsers, $notif);

                $waktu = now()->format('d/m/Y H:i:s');
                $link = route('pendaftaran.index');
                foreach ($petugasUsers as $pUser) {
                    try {
                        event(new StatusRekamUpdate($pUser->id, $pendaftaran->kode_pendaftaran, $notif->message, $link, $waktu));
                    } catch (\Throwable $e) {
                        // ignore broadcast error
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal mengirim notifikasi pendaftaran baru: ' . $th->getMessage());
        }
    }

    /**
     * Kirim notifikasi ke semua Petugas Pendaftaran & Admin aktif saat ada booking baru
     */
    private function notifyPetugasBookingBaru($booking)
    {
        try {
            $petugasUsers = User::whereIn('role', [1, 2])->where('status', 1)->get();
            if ($petugasUsers->isNotEmpty()) {
                $notif = new BookingBaruNotification($booking);
                Notification::send($petugasUsers, $notif);

                $waktu = now()->format('d/m/Y H:i:s');
                $link = route('booking.index');
                foreach ($petugasUsers as $pUser) {
                    try {
                        event(new StatusRekamUpdate($pUser->id, $booking->kode_booking, $notif->message, $link, $waktu));
                    } catch (\Throwable $e) {
                        // ignore broadcast error
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal mengirim notifikasi booking baru: ' . $th->getMessage());
        }
    }

    /**
     * Kirim notifikasi penugasan ke terapis terkait
     */
    private function notifyTerapis($rekam, $message, $tipe = 'penugasan')
    {
        try {
            if ($rekam && $rekam->dokter_id) {
                $dokter = Dokter::find($rekam->dokter_id);
                if ($dokter && $dokter->user_id) {
                    $user = User::find($dokter->user_id);
                    if ($user) {
                        Notification::send($user, new RekamUpdateNotification($rekam, $message, $tipe));
                        try {
                            $waktu = Carbon::parse($rekam->created_at ?? now())->format('d/m/Y H:i:s');
                            $link = route('rekam.detail', $rekam->pasien_id);
                            event(new StatusRekamUpdate($user->id, $rekam->no_rekam, $message, $link, $waktu));
                        } catch (\Throwable $e) {
                            // ignore broadcast error
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal mengirim notifikasi ke terapis: ' . $th->getMessage());
        }
    }
}
