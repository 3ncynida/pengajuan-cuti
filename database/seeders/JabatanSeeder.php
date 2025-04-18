<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use App\Models\CutiQuota;
use Carbon\Carbon;

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
            'nohp' => '081234567890'
        ]);

        // Create CutiQuota for admin
        CutiQuota::create([
            'karyawan_id' => $admin->karyawan_id,
            'tahun' => Carbon::now()->year,
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
            $karyawan = Karyawan::create([
                'nama_karyawan' => 'Karyawan' . $i,
                'email' => 'karyawan' . $i . '@example.com',
                'jabatan_id' => $jabatans->random()->jabatan_id,
                'jenis_kelamin' => $gender[array_rand($gender)],
                'role' => 'karyawan',
                'password' => Hash::make('123123123'),
                'nohp' => '08' . rand(1000000000, 9999999999)
            ]);

            // Create CutiQuota for each karyawan
            CutiQuota::create([
                'karyawan_id' => $karyawan->karyawan_id,
                'tahun' => Carbon::now()->year,
                'cuti_tahunan' => 12,
                'cuti_khusus' => 3,
                'cuti_haid' => $karyawan->jenis_kelamin === 'P' ? 1 : 0,
                'cuti_melahirkan' => $karyawan->jenis_kelamin === 'P' ? 90 : 0,
                'cuti_ayah' => $karyawan->jenis_kelamin === 'L' ? 30 : 0
            ]);
        }
    }
}