<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
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

        return view('portal.login');
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

        return view('portal.dashboard', compact('pasien', 'latestAssessment', 'latestRekam'));
    }

    /**
     * 2. Profil Penerima Manfaat
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
    public function denver()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $latestAssessment = $assessments->first();
        $denverSectors = config('denver.sectors', []);

        return view('portal.denver', compact('pasien', 'assessments', 'latestAssessment', 'denverSectors'));
    }

    /**
     * 4. Gross Motor Function Measure (GMFM)
     */
    public function gmfm()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $latestAssessment = $assessments->first();
        $gmfmDimensions = config('gmfm.dimensions', []);

        return view('portal.gmfm', compact('pasien', 'assessments', 'latestAssessment', 'gmfmDimensions'));
    }

    /**
     * 5. Evaluasi Nyeri, Gerak Sendi (ROM), MMT, dan Keseimbangan
     */
    public function nyeri()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $latestAssessment = $assessments->first();

        return view('portal.nyeri', compact('pasien', 'assessments', 'latestAssessment'));
    }

    /**
     * 6. Program Latihan Mandiri di Rumah (Home Program)
     */
    public function homeProgram()
    {
        $pasien = $this->getAuthenticatedPasien();
        if (!$pasien) {
            return redirect()->route('portal.index')->with('gagal', 'Sesi Anda telah berakhir.');
        }

        $assessments = $pasien->assessments;
        $latestAssessment = $assessments->first();

        return view('portal.home-program', compact('pasien', 'assessments', 'latestAssessment'));
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

        return view('portal.dokumen', compact('pasien'));
    }

    /**
     * Keluar dari Sesi Portal Pasien
     */
    public function logout()
    {
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
