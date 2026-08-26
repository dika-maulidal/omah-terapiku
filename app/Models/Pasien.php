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

    public function rekamGigi()
    {
        return RekamGigi::where('pasien_id', $this->id)->get();
    }

    public function isRekamGigi()
    {
        return RekamGigi::where('pasien_id', $this->id)->count() > 0;
    }

    public function statusPasien()
    {
        $lastData = Carbon::createFromFormat('Y-m-d H:i:s', '2023-05-22 18:00:00');

        $rekam = Rekam::where('pasien_id', $this->id)
                      ->whereIn('status', [4, 5])
                      ->count();

        if ($rekam > 0) {
            if ($this->created_at > $lastData) {
                return '<span class="badge badge-outline-primary">
                            <i class="fa fa-circle text-primary mr-1"></i>
                            Sudah Periksa
                        </span>';
            } else {
                return '<span class="badge badge-outline-success">
                            <i class="fa fa-circle text-success mr-1"></i>
                            Sudah Periksa
                        </span>';
            }
        } else {
            if ($this->created_at > $lastData) {
                return '<span class="badge badge-outline-primary">
                            <i class="fa fa-circle text-primary mr-1"></i>
                            Pasien Baru
                        </span>';
            } else {
                return '<span class="badge badge-outline-danger">
                            <i class="fa fa-circle text-danger mr-1"></i>
                            Pasien Lama
                        </span>';
            }
        }
    }

    public function getStatusPasienTextAttribute()
    {
        $lastData = Carbon::createFromFormat('Y-m-d H:i:s', '2023-05-22 18:00:00');

        $rekam = Rekam::where('pasien_id', $this->id)
                      ->whereIn('status', [4, 5])
                      ->count();

        if ($rekam > 0) {
            return 'Sudah Periksa';
        } else {
            return ($this->created_at && $this->created_at > $lastData) ? 'Pasien Baru' : 'Pasien Lama';
        }
    }
}