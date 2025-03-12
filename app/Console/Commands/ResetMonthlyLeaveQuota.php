<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CutiQuota;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetMonthlyLeaveQuota extends Command
{
    protected $signature = 'leave:reset-monthly';
    protected $description = 'Reset monthly leave quotas on the first day of each month';

    public function handle()
    {
        $this->info('Resetting monthly leave quotas...');
        
        DB::transaction(function() {
            $currentYear = Carbon::now()->year;
            
            // Get all female employees
            $karyawans = Karyawan::where('jenis_kelamin', 'P')->get();
            
            foreach ($karyawans as $karyawan) {
                // Reset cuti_haid quota
                $cutiQuota = CutiQuota::where('karyawan_id', $karyawan->id)
                    ->where('tahun', $currentYear)
                    ->first();

                if ($cutiQuota) {
                    $cutiQuota->update(['cuti_haid' => 1]);
                    $this->info("Reset monthly quota for {$karyawan->nama_karyawan} successful.");
                }
            }
        });

        $this->info('All monthly leave quotas have been reset successfully.');
    }
}