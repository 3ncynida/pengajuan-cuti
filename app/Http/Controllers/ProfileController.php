<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $karyawan = auth()->user();
        $jabatans = Jabatan::all();
        return view('profile', compact('karyawan', 'jabatans'));
    }

    public function updateProfile(Request $request)
    {
        $karyawan = auth()->user();
    
        $request->validate([
            'nama_karyawan' => [
                'required',
                'string',
                'max:25',
                Rule::unique('karyawans')->ignore($karyawan->karyawan_id, 'karyawan_id')
            ],
            'nohp' => [
                'required',
                'string',
                'max:20',
                Rule::unique('karyawans')->ignore($karyawan->karyawan_id, 'karyawan_id')
            ]
        ], [
            'nama_karyawan.unique' => 'Nama karyawan sudah terdaftar, silakan gunakan nama lain!',
            'nohp.unique' => 'Nomor HP sudah terdaftar, silakan gunakan nomor lain!',
        ]);
    
        $karyawan->update($request->only(['nama_karyawan', 'nohp']));
    
        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }
}