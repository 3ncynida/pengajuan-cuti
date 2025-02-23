<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = [
        'nama_jabatan',
    ];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}