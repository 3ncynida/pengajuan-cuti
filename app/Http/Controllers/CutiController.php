<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function create()
    {
        return view('cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $jumlah_hari = Carbon::parse($request->tanggal_mulai)
                            ->diffInDays(Carbon::parse($request->tanggal_selesai)) + 1;

        $cuti = new Cuti();
        $cuti->karyawan_id = auth()->id();
        $cuti->tanggal_mulai = $request->tanggal_mulai;
        $cuti->tanggal_selesai = $request->tanggal_selesai;
        $cuti->jumlah_hari = $jumlah_hari;
        $cuti->alasan = $request->alasan;
        $cuti->status = 'pending';

        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen_pendukung', $filename);
            $cuti->dokumen_pendukung = $filename;
        }

        $cuti->save();

        return redirect()->route('karyawan.dashboard')
                        ->with('success', 'Pengajuan cuti berhasil disubmit.');
    }

    public function show(Cuti $cuti)
{
    // Ensure karyawan can only see their own leave requests
    if ($cuti->karyawan_id !== auth()->id()) {
        abort(403);
    }

    return view('cuti.show', compact('cuti'));
}
}