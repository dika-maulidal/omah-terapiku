<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icd extends Model
{
    protected $fillable = ['code', 'name_id', 'name_en'];

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';
}
