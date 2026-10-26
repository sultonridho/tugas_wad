<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'nama',
        'umur',
        'pengalaman_pengemudi',
        'nomor_sim_aktif',
        'kontak',
        'status',
    ];
}
