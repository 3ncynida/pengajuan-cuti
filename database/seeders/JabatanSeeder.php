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
        // List nama jabatan
        $namaJabatan = ['HRD', 'Strategist', 'Developer', 'Designer', 'Tester', 'Analyst', 'Manager', 'Supervisor', 'Staff', 'Intern'];

        // Simpan semua jabatan ke dalam database
        foreach ($namaJabatan as $nama) {
            Jabatan::create([
                'nama_jabatan' => $nama,
            ]);
        }

        // Ambil jabatan HRD untuk digunakan oleh Admin
        $hrd = Jabatan::where('nama_jabatan', 'HRD')->first();

        // Buat user admin dengan jabatan HRD
        Karyawan::create([
            'nama_karyawan' => 'Admin',
            'email' => 'admin@example.com',
            'jabatan_id' => $hrd->id, // Menggunakan jabatan HRD
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'nohp' => '081234567890'
        ]);
    }
}