<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = "dokter";
    protected $fillable = ["nama","no_hp","alamat","poli","status","user_id"];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    function status_display(){
        return $this->status ==1 ? 'Aktif' :'Tidak Aktif';
    }
}
