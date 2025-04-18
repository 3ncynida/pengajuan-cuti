<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $primaryKey = 'jabatan_id';
    protected $fillable = ['nama_jabatan'];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'jabatan_id', 'jabatan_id');
    }
}