<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CutiQuota;
use App\Models\Karyawan;
use Carbon\Carbon;

class ResetAnnualLeaveQuota extends Command
{
    protected $signature = 'leave:reset-annual';
    protected $description = 'Reset annual leave quotas on the first day of each year';

    public function handle()
    {
        $this->info('Resetting annual leave quotas...');

        // Get all employees
        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            // Create new quota for the new year
            CutiQuota::create([
                'karyawan_id' => $karyawan->id,
                'cuti_tahunan' => 12,
                'cuti_khusus' => 3,
                'cuti_haid' => $karyawan->jenis_kelamin === 'P' ? 1 : 0,
                'cuti_melahirkan' => $karyawan->jenis_kelamin === 'P' ? 90 : 0,
                'cuti_ayah' => $karyawan->jenis_kelamin === 'L' ? 30 : 0,
                'tahun' => Carbon::now()->year
            ]);
        }

        $this->info('Annual leave quotas have been reset successfully.');
    }
}