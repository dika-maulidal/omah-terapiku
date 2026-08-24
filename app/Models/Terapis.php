<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terapis extends Model
{
    protected $table = "terapis";
    protected $fillable = ["nama", "no_hp", "alamat", "poli", "status", "user_id"];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function status_display()
    {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
