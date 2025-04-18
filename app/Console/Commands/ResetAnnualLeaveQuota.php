<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CutiQuota;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetAnnualLeaveQuota extends Command
{
    protected $signature = 'leave:reset-annual';
    protected $description = 'Reset annual leave quotas on January 1st';

    public function handle()
    {
        $this->info('Resetting annual leave quotas...');
        
        DB::transaction(function() {
            $currentYear = Carbon::now()->year;
            
            $karyawans = Karyawan::all();
            
            foreach ($karyawans as $karyawan) {
                CutiQuota::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->karyawan_id,
                        'tahun' => $currentYear
                    ],
                    [
                        'cuti_tahunan' => 12,
                        'cuti_khusus' => 3,
                        'cuti_haid' => $karyawan->jenis_kelamin === 'P' ? 1 : 0,
                        'cuti_melahirkan' => $karyawan->jenis_kelamin === 'P' ? 90 : 0,
                        'cuti_ayah' => $karyawan->jenis_kelamin === 'L' ? 30 : 0,
                    ]
                );
            }
        });

        $this->info('Annual leave quotas have been reset successfully!');
    }
}