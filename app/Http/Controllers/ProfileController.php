<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

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
        $request->validate([
            'nama_karyawan' => 'required|string|max:25|unique:karyawans,nama_karyawan,' . auth()->id(),
            'nohp' => 'required|string|max:20|unique:karyawans,nohp,' . auth()->id(),
        ],
        [
            'nama_karyawan.unique' => 'Nama karyawan sudah terdaftar, silakan gunakan nama lain!',
            'nohp.unique' => 'Nomor HP sudah terdaftar, silakan gunakan nomor lain!',
        ]);

        $karyawan = auth()->user();
        $karyawan->update($request->only(['nama_karyawan', 'nohp', 'jabatan_id']));

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}