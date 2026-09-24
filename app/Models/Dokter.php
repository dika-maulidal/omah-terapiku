<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = "terapis";
    protected $fillable = [
        "nama", "no_hp", "alamat", "poli", "status", "user_id",
        "no_str", "masa_berlaku_str", "file_str"
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    function status_display(){
        return $this->status ==1 ? 'Aktif' :'Tidak Aktif';
    }

    public function getFileStr()
    {
        if ($this->file_str && file_exists(public_path('images/terapis/str/' . $this->file_str))) {
            return asset('images/terapis/str/' . $this->file_str);
        }
        return null;
    }

    public function getFileStrUrlAttribute()
    {
        return $this->getFileStr();
    }
}

