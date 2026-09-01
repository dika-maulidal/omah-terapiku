<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamAssessment extends Model
{
    protected $table = 'rekam_assessment';

    protected $guarded = ['id'];

    protected $casts = [
        'custom_data' => 'array',
        'penglihatan_alat_bantu' => 'array',
        'nyeri_sifat' => 'array',
        'rom_mmt_data' => 'array',
        'neuro_koordinasi' => 'array',
        'postur_temuan' => 'array',
        'gait_karakteristik' => 'array',
        'tgl_assessment' => 'date',
    ];

    public function rekam()
    {
        return $this->belongsTo(Rekam::class, 'rekam_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    /**
     * Hitung persentase kelengkapan form assessment
     */
    public function getKelengkapanAttribute()
    {
        $fields = [
            $this->motorik_mengangkat_kepala,
            $this->motorik_posisi_tengkurap,
            $this->motorik_posisi_duduk,
            $this->motorik_merangkak,
            $this->motorik_berlutut,
            $this->motorik_berjalan,
            $this->adl_kontak_mata,
            $this->adl_duduk_tenang,
            $this->adl_gerakan_berulang,
            $this->adl_respon_nama,
            $this->adl_makan,
            $this->adl_mandi,
            $this->adl_berpakaian,
            $this->adl_bak,
            $this->adl_bab,
            $this->wicara_komunikasi,
            $this->wicara_organ,
            $this->wicara_makan_menelan,
        ];

        $filled = count(array_filter($fields, function ($val) {
            return !is_null($val) && $val !== '';
        }));

        return round(($filled / count($fields)) * 100);
    }
}
