<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekam extends Model
{
    protected $table = "rekam";
    protected $fillable = [
        "tgl_rekam", "pasien_id", "keluhan", "poli", "upt_lokasi", "layanan_terapi",
        "sesi_waktu", "dokter_id", "terapis_pendamping_id", "pemeriksaan", "diagnosa",
        "no_rekam", "tindakan", "status", "petugas_id", "biaya_pemeriksaan", "biaya_tindakan",
        "biaya_obat", "total_biaya", "cara_bayar", "resep_obat", "pemeriksaan_file", "tindakan_file"
    ];

    function getFilePemeriksaan(){
        return $this->pemeriksaan_file != null ? asset('images/pemeriksaan/'.$this->pemeriksaan_file) : null;
    }

    function getFileTindakan(){
        return $this->tindakan_file != null ? asset('images/pemeriksaan/'.$this->tindakan_file) : null;
    }

    function diagnosa(){
        return  RekamDiagnosa::where('rekam_id',$this->id)->get();
      }

    function assessment(){
        return $this->hasOne(RekamAssessment::class, 'rekam_id');
    }

    function pasien(){
        return $this->belongsTo(Pasien::class);
    }

    // function diagnosis(){
    //     return $this->belongsTo(Icd::class,'diagnosa','code');
    // }

    function dokter(){
        return $this->belongsTo(Dokter::class);
    }

    function terapisPendamping(){
        return $this->belongsTo(Dokter::class, 'terapis_pendamping_id');
    }
    function status_rekams(){
        switch ($this->status) {
            case 1:
                return "<span class='badge badge-rounded badge-warning'><i class='fa fa-clock-o mr-1'></i> Antrian</span>";
                break;
            case 2:
                return "<span class='badge badge-rounded badge-info'><i class='fa fa-stethoscope mr-1'></i> Belum Diperiksa</span>";
                break;
            case 3:
                return "<span class='badge badge-rounded badge-primary'><i class='fa fa-user-md mr-1'></i> Sudah Diperiksa</span>";
                break;
            case 4:
                return "<span class='badge badge-rounded badge-success'><i class='fa fa-check-circle mr-1'></i> Selesai</span>";
                break;
            case 5:
                return "<span class='badge badge-rounded badge-success'><i class='fa fa-check-circle mr-1'></i> Selesai</span>";
                break;
            default:
                # code...
                break;
        }
    }

    function status_display(){
        switch ($this->status) {
            case 1:
                return '<span class="badge badge-warning light font-w600">
                            <i class="fa-solid fa-clock mr-1"></i>
                            Antrian
                        </span>';
            break;
            case 2:
                return '<span class="badge badge-info light font-w600">
                            <i class="fa-solid fa-stethoscope mr-1"></i>
                            Pemeriksaan
                        </span>';
            break;
            case 3:
                return '<span class="badge badge-warning light font-w600" style="min-width:95px">
                           <i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu
                        </span>';
            break;
            case 4:
                return '<span class="badge badge-success light font-w600">
                            <i class="fa-solid fa-circle-check mr-1"></i>
                            Selesai
                        </span>';
            break;
            case 5:
                return '<span class="badge badge-success light font-w600" style="min-width:95px">
                            <i class="fa-solid fa-circle-check mr-1"></i>
                            Selesai
                        </span>';
            break;
            default:
                return '<span class="badge badge-secondary light font-w600">-</span>';
                break;
        }
    }
}
