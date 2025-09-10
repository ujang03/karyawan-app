<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    //
    protected $table = 'karyawan';
    protected $fillable =  [
        'id',
        'nama',
        'email',
        'telp',
        'jabatan',
        'tgl_masuk',
        'gaji',

    ];
}
