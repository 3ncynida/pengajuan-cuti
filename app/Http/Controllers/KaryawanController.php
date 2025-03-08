<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $karyawan = auth()->user();
        $totalCuti = Cuti::where('karyawan_id', $karyawan->id)->count();
        $approvedCuti = Cuti::where('karyawan_id', $karyawan->id)
            ->where('status', 'approved')
            ->count();
        $pendingCuti = Cuti::where('karyawan_id', $karyawan->id)
            ->where('status', 'pending')
            ->count();
        $recentCuti = Cuti::where('karyawan_id', $karyawan->id)
            ->latest()
            ->get();

        return view('karyawan.dashboard', compact(
            'totalCuti',
            'approvedCuti',
            'pendingCuti',
            'recentCuti'
        ));
    }

    public function calendar()
    {
        $cutis = Cuti::with('karyawan')->get();

        $events = $cutis->map(function ($cuti) {
            $statusColor = [
                'pending' => '#ffc107',
                'approved' => '#198754',
                'rejected' => '#dc3545'
            ];

            $statusLabel = [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected'
            ];

            // Format the title to include leave period
            $title = sprintf(
                '%s (%s)',
                $cuti->karyawan->nama_karyawan,
                $statusLabel[$cuti->status]
            );

            return [
                'title' => $title,
                'start' => Carbon::parse($cuti->tanggal_mulai)->format('Y-m-d'),
                'end' => Carbon::parse($cuti->tanggal_selesai)->addDay()->format('Y-m-d'),
                'backgroundColor' => $statusColor[$cuti->status],
                'borderColor' => $statusColor[$cuti->status],
                'extendedProps' => [
                    'status' => $statusLabel[$cuti->status],
                    'karyawan' => $cuti->karyawan->nama_karyawan,
                    'startDate' => Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y'),
                    'endDate' => Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')
                ]
            ];
        });

        return view('karyawan.calendar', compact('events'));
    }

    public function create()
    {
        return view('karyawan.cuti.create');
    }

    public function store(Request $request)
    {
        // Check for pending leave requests
        $hasPendingCuti = Cuti::where('karyawan_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingCuti) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda masih memiliki pengajuan cuti yang pending. Harap tunggu hingga pengajuan sebelumnya diproses.');
        }

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
            // Store directly in the public disk
            $file->move(public_path('storage/dokumen_pendukung'), $filename);
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

        return view('karyawan.cuti.show', compact('cuti'));
    }
    public function destroy(Cuti $cuti)
    {
        try {
            // Check if the cuti belongs to the authenticated user
            if ($cuti->karyawan_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Only allow deletion of pending requests
            if ($cuti->status !== 'pending') {
                return response()->json(['error' => 'Tidak dapat menghapus pengajuan yang sudah diproses'], 403);
            }

            // Delete the supporting document if exists
            if ($cuti->dokumen_pendukung) {
                $path = public_path('storage/dokumen_pendukung/' . $cuti->dokumen_pendukung);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $cuti->delete();
            return response()->json(['message' => 'Pengajuan cuti berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus pengajuan cuti'], 500);
        }
    }
}
