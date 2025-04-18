<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

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
        
        Karyawan::create([
            'nama_karyawan' => 'Admin',
            'email' => 'admin@example.com',
            'jabatan_id' => $hrd->jabatan_id,
            'jenis_kelamin' => 'L',
            'role' => 'admin',
            'password' => Hash::make('123123123'),
            'nohp' => '081234567890'
        ]);
    }
}