<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'karyawan_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_karyawan',
        'email',
        'jabatan_id',
        'jenis_kelamin',
        'role',
        'password',
        'nohp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the jabatan that owns the karyawan.
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Check if the user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is karyawan
     */
    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

    public function cutis()
{
    return $this->hasMany(Cuti::class, 'karyawan_id');
}

public function cutiQuota()
{
    return $this->hasOne(CutiQuota::class, 'karyawan_id', 'karyawan_id')->where('tahun', now()->year);
}
}