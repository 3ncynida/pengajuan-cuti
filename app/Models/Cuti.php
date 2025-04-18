<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    protected $primaryKey = 'cuti_id';

    protected $fillable = [
        'karyawan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'jenis_cuti', // Make sure this is included
        'alasan',
        'status',
        'keterangan_status',
        'dokumen_pendukung'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jumlah_hari' => 'integer',
    ];

    /**
     * Get the karyawan that owns the cuti.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'karyawan_id');
    }

    /**
     * Scope a query to only include pending cuti.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved cuti.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected cuti.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if the cuti is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the cuti is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the cuti is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}