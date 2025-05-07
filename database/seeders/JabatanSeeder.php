<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use App\Models\CutiQuota;
use Carbon\Carbon;
use App\Helpers\LeaveCalculator;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat jabatan dulu
        $namaJabatan = ['HRD', 'Strategist', 'Developer', 'Designer', 'Tester', 'Analyst', 'Manager', 'Supervisor', 'Staff', 'Intern'];
        
        foreach ($namaJabatan as $nama) {
            Jabatan::create([
                'nama_jabatan' => $nama,
            ]);
        }
    
        // Buat admin dengan jabatan HRD
        $hrd = Jabatan::where('nama_jabatan', 'HRD')->first();
        
        // Create admin
        $admin = Karyawan::create([
            'nama_karyawan' => 'Admin',
            'email' => 'admin@example.com',
            'jabatan_id' => $hrd->jabatan_id,
            'jenis_kelamin' => 'L',
            'role' => 'admin',
            'password' => Hash::make('123123123'),
            'nohp' => '081234567890',
            'tanggal_bergabung' => Carbon::now()->startOfYear()
        ]);

        // Create CutiQuota for admin
        CutiQuota::create([
            'karyawan_id' => $admin->karyawan_id,
            'tahun' => Carbon::now()->year,
            'jatah_masuk' => 240,
            'sisa_jatah_masuk' => 240,
            'cuti_tahunan' => 12,
            'cuti_khusus' => 3,
            'cuti_haid' => 0,
            'cuti_melahirkan' => 0,
            'cuti_ayah' => 30
        ]);

        // Buat 20 karyawan dummy
        $jabatans = Jabatan::all();
        $gender = ['L', 'P'];

        for ($i = 1; $i <= 20; $i++) {
            // Generate random hire date for this year
            $hireDate = Carbon::create(Carbon::now()->year, rand(1, 12), 1);
            
            $karyawan = Karyawan::create([
                'nama_karyawan' => 'Karyawan' . $i,
                'email' => 'karyawan' . $i . '@example.com',
                'jabatan_id' => $jabatans->random()->jabatan_id,
                'jenis_kelamin' => $gender[array_rand($gender)],
                'role' => 'karyawan',
                'password' => Hash::make('123123123'),
                'nohp' => '08' . rand(1000000000, 9999999999),
                'tanggal_bergabung' => $hireDate
            ]);

            // Calculate prorated working days based on hire date
            $remainingMonths = $hireDate->diffInMonths($hireDate->copy()->endOfYear()) + 1;
            $workingDays = $remainingMonths * 20; // 20 working days per month

            CutiQuota::create([
                'karyawan_id' => $karyawan->karyawan_id,
                'tahun' => Carbon::now()->year,
                'jatah_masuk' => LeaveCalculator::calculateWorkingDays($karyawan->tanggal_bergabung),
                'sisa_jatah_masuk' => LeaveCalculator::calculateWorkingDays($karyawan->tanggal_bergabung),
                'cuti_tahunan' => LeaveCalculator::calculateAnnualLeave($karyawan->tanggal_bergabung), // This will now always be 12
                'cuti_khusus' => 3,
                'cuti_haid' => $karyawan->jenis_kelamin === 'P' ? 1 : 0,
                'cuti_melahirkan' => $karyawan->jenis_kelamin === 'P' ? 90 : 0,
                'cuti_ayah' => $karyawan->jenis_kelamin === 'L' ? 30 : 0
            ]);
        }
    }
}