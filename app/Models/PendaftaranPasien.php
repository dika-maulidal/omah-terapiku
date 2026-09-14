<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPasien extends Model
{
    protected $table = 'pendaftaran_pasien';

    protected $fillable = [
        'kode_pendaftaran',
        'nama',
        'nik',
        'no_bpjs',
        'tmp_lahir',
        'tgl_lahir',
        'jk',
        'status_menikah',
        'kewarganegaraan',
        'cara_bayar',
        'alamat_lengkap',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'kodepos',
        'agama',
        'pendidikan',
        'pekerjaan',
        'desil',
        'nama_wali',
        'hubungan_wali',
        'no_hp',
        'jenis_disabilitas',
        'alat_bantu',
        'keluhan_utama',
        'upt_lokasi',
        'layanan_terapi',
        'poli_id',
        'tgl_rencana_kunjungan',
        'jam_rencana_kunjungan',
        'file_kk',
        'file_resume',
        'status',
        'catatan_petugas',
        'verified_by',
        'verified_at',
        'pasien_id',
        'no_rm_diterbitkan',
        'terapis_id',
        'tgl_sesi_disetujui',
        'jam_sesi_disetujui',
        'rekam_id',
    ];

    public static function generateKodePendaftaran()
    {
        $yearMonth = date('ym');
        $prefix = 'REG-' . $yearMonth . '-';

        $lastRecord = self::where('kode_pendaftaran', 'LIKE', $prefix . '%')
            ->orderBy('kode_pendaftaran', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $parts = explode('-', $lastRecord->kode_pendaftaran);
            if (isset($parts[2]) && is_numeric($parts[2])) {
                $nextNumber = (int)$parts[2] + 1;
            }
        }

        $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $candidate = $prefix . $formattedNumber;

        while (self::where('kode_pendaftaran', $candidate)->exists()) {
            $nextNumber++;
            $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $candidate = $prefix . $formattedNumber;
        }

        return $candidate;
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function terapis()
    {
        return $this->belongsTo(Dokter::class, 'terapis_id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    public function rekam()
    {
        return $this->belongsTo(Rekam::class, 'rekam_id');
    }

    public function getFileKkUrlAttribute()
    {
        return $this->file_kk ? asset('images/pendaftaran/' . $this->file_kk) : null;
    }

    public function getFileResumeUrlAttribute()
    {
        return $this->file_resume ? asset('images/pendaftaran/' . $this->file_resume) : null;
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->status === 'disetujui') {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;"><i class="fa-solid fa-circle-check mr-1"></i> Disetujui</span>';
        } elseif ($this->status === 'ditolak') {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;"><i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak</span>';
        } else {
            return '<span class="badge font-w700" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; background: #fffbeb; color: #d97706; border: 1px solid #fde68a;"><i class="fa-solid fa-clock mr-1"></i> Menunggu Verifikasi</span>';
        }
    }
}
