<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = "pasien";
    
    protected $fillable = [
        "no_rm",
        "nama",
        "nik",
        "tmp_lahir",
        "tgl_lahir",
        "jk",
        "alamat_lengkap",
        "kelurahan",
        "kecamatan",
        "kabupaten",
        "kodepos",
        "agama",
        "status_menikah",
        "pendidikan",
        "pekerjaan",
        "desil",
        "upt_lokasi",
        "nama_wali",
        "hubungan_wali",
        "jenis_disabilitas",
        "alat_bantu",
        "kewarganegaraan",
        "no_hp",
        "cara_bayar",
        "no_bpjs",
        "deleted_at",
        "alergi",
        "file_kk",
        "file_resume"
    ];

    public function getFileKk()
    {
        return $this->file_kk != null ? asset('images/pasien/' . $this->file_kk) : null;
    }

    public function getFileResume()
    {
        return $this->file_resume != null ? asset('images/pasien/' . $this->file_resume) : null;
    }

    public function rekams()
    {
        return $this->hasMany(Rekam::class, 'pasien_id');
    }

    public function assessments()
    {
        return $this->hasMany(RekamAssessment::class, 'pasien_id');
    }

    public function statusPasien()
    {
        $rekam = isset($this->rekam_selesai_count)
            ? (int) $this->rekam_selesai_count
            : $this->rekams()->whereIn('status', [4, 5])->count();

        if ($rekam >= 2) {
            return '<span class="badge badge-success light font-w600" title="' . $rekam . ' Sesi Terapi Selesai">
                        <i class="fa-solid fa-user-check mr-1"></i>
                        Penerima Lama
                    </span>';
        } elseif ($rekam === 1) {
            return '<span class="badge badge-info light font-w600" title="1 Sesi Terapi Selesai">
                        <i class="fa-solid fa-user-plus mr-1"></i>
                        Penerima Baru
                    </span>';
        } else {
            return '<span class="badge badge-secondary light font-w600" title="Belum Memiliki Riwayat Terapi Selesai">
                        <i class="fa-solid fa-clock mr-1"></i>
                        Belum Terapi
                    </span>';
        }
    }

    public function getStatusPasienTextAttribute()
    {
        $rekam = isset($this->rekam_selesai_count)
            ? (int) $this->rekam_selesai_count
            : $this->rekams()->whereIn('status', [4, 5])->count();

        if ($rekam >= 2) {
            return 'Penerima Lama';
        } elseif ($rekam === 1) {
            return 'Penerima Baru';
        } else {
            return 'Belum Terapi';
        }
    }

    public static function generateNoRM()
    {
        $year = date('y');
        $prefix = 'OTK-' . $year . '-';

        $lastPatient = self::where('no_rm', 'LIKE', $prefix . '%')
                           ->orderBy('no_rm', 'desc')
                           ->first();

        $nextNumber = 1;
        if ($lastPatient) {
            $parts = explode('-', $lastPatient->no_rm);
            if (isset($parts[2]) && is_numeric($parts[2])) {
                $nextNumber = (int)$parts[2] + 1;
            }
        }

        $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $candidate = $prefix . $formattedNumber;

        while (self::where('no_rm', $candidate)->exists()) {
            $nextNumber++;
            $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $candidate = $prefix . $formattedNumber;
        }

        return $candidate;
    }

    public function getKategoriUsiaAttribute()
    {
        if ($this->tgl_lahir) {
            try {
                $age = Carbon::parse($this->tgl_lahir)->diffInYears(Carbon::now());
                return $age < 18 ? 'Anak' : 'Dewasa';
            } catch (\Exception $e) {
                return 'Dewasa';
            }
        }
        return 'Dewasa';
    }
}