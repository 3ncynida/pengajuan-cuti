<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiQuota extends Model
{
    protected $primaryKey = 'kuotacuti_id';

    protected $fillable = [
        'karyawan_id',
        'cuti_tahunan',
        'cuti_khusus',
        'cuti_haid',
        'cuti_melahirkan',
        'cuti_ayah',
        'tahun'
    ];

    protected $casts = [
        'tahun' => 'integer'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class,  'karyawan_id', 'karyawan_id');
    }
}