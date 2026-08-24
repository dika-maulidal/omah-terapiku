<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Omahterapiku extends Model
{
    protected $table = "omahterapiku";
    protected $fillable = ["nama", "alamat", "status"];

    public function status_display()
    {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
