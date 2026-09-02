<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = "omahterapiku";
    protected $fillable = ["nama", "alamat", "fokus_layanan", "status"];

    public function terapis()
    {
        return $this->hasMany(Dokter::class, 'poli', 'nama');
    }

    function status_display(){
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
