<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Rekam;
use App\Models\RekamAssessment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientPortalController extends Controller
{
    /**
     * Helper untuk mengambil data pasien yang sedang terotentikasi di sesi portal
     */
    private function getAuthenticatedPasien()
    {
        if (!session()->has('portal_pasien_id')) {
            return null;
        }

        $pasienId = session('portal_pasien_id');
        return Pasien::with([
            'rekams' => function ($q) {
                $q->with(['dokter', 'assessment'])->latest('tgl_rekam');
            },
            'assessments' => function ($q) {
                $q->with('dokter')->latest('tgl_assessment');
            }
        ])->find($pasienId);
    }

    /**
     * Halaman Login / Pencarian Data Pasien
     */
    public function index()
    {
        if (session()->has('portal_pasien_id')) {
            return redirect()->route('portal.dashboard');
        }

        $polis = Poli::where('status', 1)->with('terapis')->get();

        return view('portal.login', compact('polis'));
    }

    /**
     * Proses Verifikasi No. RM & Tanggal Lahir
     */
    public function login(Request $request)
    {
        $request->validate([
            'no_rm' => 'required|string',
            'tgl_lahir' => 'required',
        ], [
            'no_rm.required' => 'Nomor Rekam Medis wajib diisi.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
        ]);

        $noRm = trim($request->input('no_rm'));
        $rawTglLahir = trim($request->input('tgl_lahir'));

        try {
            $formattedTgl = Carbon::parse($rawTglLahir)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('gagal', 'Format tanggal lahir tidak valid.');
        }

        $pasien = Pasien::where(function ($query) use ($noRm) {
                $query->where('no_rm', $noRm)
                      ->orWhereRaw('LOWER(no_rm) = ?', [strtolower($noRm)]);
            })
            ->whereDate('tgl_lahir', $formattedTgl)
            ->first();

        if (!$pasien) {
            return redirect()->back()
                ->withInput()
                ->with('gagal', 'Nomor Rekam Medis atau Tanggal Lahir tidak cocok. Mohon periksa kembali kartu berobat Anda.');
        }

        session([
            'portal_pasien_id' => $pasien->id,
            'portal_pasien_no_rm' => $pasien->no_rm,
            'portal_pasien_nama' => $pasien->nama,
            'portal_login_time' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->route('portal.dashboard')
            ->with('sukses', 'Selamat Datang di Portal Omah Terapi-KU, ' . $pasien->nama . '!');
    }

    /**
     * 1. Beranda / Overview Dashboard Pasien
     */
    public function dashboard()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $latestAssessment = $pasien->assessments->first();
        $latestRekam = $pasien->rekams->first();
        $latestBooking = $pasien->bookings()->latest()->first();

        return view('portal.dashboard', compact('pasien', 'latestAssessment', 'latestRekam', 'latestBooking'));
    }

    /**
     * 2. Booking & Tracking Jadwal Sesi Terapi
     */
    public function booking(Request $request)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $bookings = $pasien->bookings()
            ->with(['dokter', 'rekam', 'verifier'])
            ->orderBy('created_at', 'desc')
            ->get();

        $polis = Poli::where('status', 1)->orderBy('nama', 'asc')->get();

        return view('portal.booking', compact('pasien', 'bookings', 'polis'));
    }

    /**
     * 3. Profil Penerima Manfaat
     */
    public function profil()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        return view('portal.profil', compact('pasien'));
    }

    /**
     * 3. Hasil Skala Denver II (DDST II)
     */
    public function denver(Request $request)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $selectedAssessmentId = $request->get('assessment_id');
        $latestAssessment = $selectedAssessmentId
            ? ($assessments->firstWhere('id', $selectedAssessmentId) ?? $assessments->first())
            : $assessments->first();
            
        $denverSectors = config('denver.sectors', []);

        return view('portal.denver', compact('pasien', 'assessments', 'latestAssessment', 'denverSectors'));
    }

    /**
     * 4. Gross Motor Function Measure (GMFM)
     */
    public function gmfm(Request $request)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $selectedAssessmentId = $request->get('assessment_id');
        $latestAssessment = $selectedAssessmentId
            ? ($assessments->firstWhere('id', $selectedAssessmentId) ?? $assessments->first())
            : $assessments->first();

        $gmfmDimensions = config('gmfm.dimensions', []);

        return view('portal.gmfm', compact('pasien', 'assessments', 'latestAssessment', 'gmfmDimensions'));
    }

    /**
     * 5. Evaluasi Nyeri, Gerak Sendi (ROM), MMT, dan Keseimbangan
     */
    public function nyeri(Request $request)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $selectedAssessmentId = $request->get('assessment_id');
        $latestAssessment = $selectedAssessmentId
            ? ($assessments->firstWhere('id', $selectedAssessmentId) ?? $assessments->first())
            : $assessments->first();

        return view('portal.nyeri', compact('pasien', 'assessments', 'latestAssessment'));
    }

    /**
     * 6. Program Latihan Mandiri di Rumah (Home Program)
     */
    public function homeProgram(Request $request)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $rekams = $pasien->rekams;
        
        $selectedRekamId = $request->get('rekam_id');
        if (!$selectedRekamId && $request->filled('assessment_id')) {
            $asm = $pasien->assessments->firstWhere('id', $request->get('assessment_id'));
            $selectedRekamId = $asm ? $asm->rekam_id : null;
        }

        $selectedRekam = $selectedRekamId
            ? ($rekams->firstWhere('id', $selectedRekamId) ?? $rekams->first())
            : $rekams->first();

        $latestAssessment = $selectedRekam ? $selectedRekam->assessment : null;

        return view('portal.home-program', compact('pasien', 'rekams', 'selectedRekam', 'latestAssessment'));
    }

    /**
     * 7. Riwayat Sesi Terapi & Kunjungan (Timeline & Catatan SOAP)
     */
    public function riwayat()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $rekams = $pasien->rekams;

        return view('portal.riwayat', compact('pasien', 'rekams'));
    }

    /**
     * 8. Dokumen & Cetak Laporan Asesmen (PDF)
     */
     public function dokumen()
     {
         $pasien = $this->getAuthenticatedPasien();
         if (!$pasien) {
             return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
         }

         $rekams = $pasien->rekams()->with(['dokter', 'assessment'])->orderBy('tgl_rekam', 'desc')->get();

         return view('portal.dokumen', compact('pasien', 'rekams'));
     }

    /**
     * Cetak Lembar Asesmen Terpadu (15 Modul) Khusus Portal Pasien
     */
    public function printAssessment($rekamId)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir. Silakan verifikasi ulang No. RM & Tanggal Lahir.');
        }

        $rekam = Rekam::with(['pasien', 'dokter', 'assessment'])
            ->where('pasien_id', $pasien->id)
            ->findOrFail($rekamId);

        $assessment = $rekam->assessment;
        if (!$assessment) {
            return redirect()->route('portal.dokumen')->with('gagal', 'Form assessment belum diisi oleh terapis.');
        }

        $upt = Poli::where('nama', $rekam->upt_lokasi)->orWhere('nama', $rekam->poli)->first();

        return view('rekam.assessment.print', compact('rekam', 'pasien', 'assessment', 'upt'));
    }

    /**
     * Cetak Lembar Catatan Sesi Terapi (SOAP) Khusus Portal Pasien
     */
    public function printSoap($rekamId)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir. Silakan verifikasi ulang No. RM & Tanggal Lahir.');
        }

        $rekam = Rekam::with(['pasien', 'dokter', 'assessment'])
            ->where('pasien_id', $pasien->id)
            ->findOrFail($rekamId);

        $hasSoap = !empty($rekam->pemeriksaan) || !empty($rekam->tindakan) || !empty($rekam->diagnosa) || ($rekam->status >= 2) || ($rekam->assessment);
        if (!$hasSoap) {
            return redirect()->route('portal.dokumen')->with('gagal', 'Catatan sesi terapi (SOAP) belum diisi oleh terapis.');
        }

        $upt = Poli::where('nama', $rekam->upt_lokasi)->orWhere('nama', $rekam->poli)->first();
        $assessment = $rekam->assessment;

        return view('rekam.print-soap', compact('rekam', 'pasien', 'upt', 'assessment'));
    }

    /**
     * Cetak Lembar Panduan Latihan di Rumah (Home Program) Khusus Portal Pasien
     */
    public function printHomeProgram($rekamId)
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir. Silakan verifikasi ulang No. RM & Tanggal Lahir.');
        }

        $rekam = Rekam::with(['pasien', 'dokter', 'assessment'])
            ->where('pasien_id', $pasien->id)
            ->findOrFail($rekamId);

        $hasHp = !empty($rekam->latihan_rumahan) || ($rekam->assessment && (!empty($rekam->assessment->rencana_latihan_terapi) || !empty($rekam->assessment->rencana_dosis_frekuensi)));
        if (!$hasHp) {
            return redirect()->route('portal.dokumen')->with('gagal', 'Panduan latihan di rumah (Home Program) belum disusun oleh terapis untuk sesi ini.');
        }

        $upt = Poli::where('nama', $rekam->upt_lokasi)->orWhere('nama', $rekam->poli)->first();

        return view('rekam.print-home-program', compact('rekam', 'pasien', 'upt'));
    }

    /**
     * Keluar dari Sesi Portal Pasien
     */
    public function logout()
    {
        // Abaikan request jika berasal dari prefetch browser (instant.page hover)
        if (request()->header('Sec-Purpose') === 'prefetch' || request()->header('Purpose') === 'prefetch' || request()->header('X-Purpose') === 'preview' || request()->header('X-Moz') === 'prefetch') {
            return response('', 204);
        }

        session()->forget([
            'portal_pasien_id',
            'portal_pasien_no_rm',
            'portal_pasien_nama',
            'portal_login_time',
        ]);

        return redirect()->route('portal.index')
            ->with('sukses', 'Anda telah berhasil keluar dari Portal Pasien.');
    }
}
