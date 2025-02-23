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
        // Create HRD jabatan
        $hrd = Jabatan::create([
            'nama_jabatan' => 'HRD'
        ]);

        // Create HRD admin user
        Karyawan::create([
            'nama_karyawan' => 'Admin HRD',
            'email' => 'hrd@example.com',
            'jabatan_id' => $hrd->id,
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'nohp' => '081234567890'
        ]);
    }
}