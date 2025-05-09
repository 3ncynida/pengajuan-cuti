<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalKaryawan = Karyawan::where('role', 'karyawan')->count();
        $totalCutiPending = Cuti::where('status', 'pending')->count();
        $totalCutiApproved = Cuti::where('status', 'approved')->count();
        $latestCutiRequests = Cuti::with('karyawan')
            ->latest()
            ->get();

        return view('admin.cuti.index', compact(
            'totalKaryawan',
            'totalCutiPending',
            'totalCutiApproved',
            'latestCutiRequests'
        ));
    }

    public function showAddEmailForm()
    {
        $karyawans = Karyawan::with('jabatan')->get();
        $jabatans = Jabatan::all();
        return view('admin.add-email', compact('karyawans', 'jabatans'));
    }

    public function storeEmail(Request $request)
    {
        $request->validate([
            'nama_karyawan' => ['required', 'string', 'max:25', 'unique:karyawans'],
            'email' => ['required', 'string', 'email', 'max:25', 'unique:karyawans'],
            'jabatan_id' => ['required', 'exists:jabatans,id'],
        ]);

        try {
            $karyawan = Karyawan::create([
                'nama_karyawan' => $request->nama_karyawan,
                'email' => $request->email,
                'jabatan_id' => $request->jabatan_id,
                'is_verified' => true,
                'role' => 'karyawan',
                'password' => null
            ]);

            return redirect()->back()->with('success', 'Email karyawan berhasil didaftarkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'email' => 'Gagal mendaftarkan email: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function updateKaryawan(Request $request, Karyawan $karyawan)
    {
        if ($karyawan->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah akun sendiri.');
        }

        $request->validate([
            'role' => ['required', 'in:admin,karyawan'],
            'jabatan_id' => ['required', 'exists:jabatans,id']
        ]);

        $karyawan->update([
            'is_verified' => $request->has('is_verified'),
            'role' => $request->role,
            'jabatan_id' => $request->jabatan_id
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil diupdate');
    }

    public function deleteKaryawan(Karyawan $karyawan)
    {
        if ($karyawan->id === auth()->id()) {
            return response()->json(['error' => 'Tidak dapat menghapus akun sendiri.'], 403);
        }

        $karyawan->delete();
        return response()->json(['message' => 'Karyawan deleted successfully']);
    }

    public function jabatanIndex()
    {
        $jabatans = Jabatan::all();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function jabatanStore(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans'
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function jabatanUpdate(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $jabatan->id
        ]);

        $jabatan->update($request->all());

        return redirect()->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil diupdate');
    }

    public function jabatanDestroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return response()->json(['message' => 'Jabatan berhasil dihapus']);
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['jabatan', 'cutis']);
        $jabatans = Jabatan::all();
        return view('admin.karyawan.show', compact('karyawan', 'jabatans'));
    }

    public function cutiShow(Cuti $cuti)
    {
        return view('admin.cuti.show', compact('cuti'));
    }

    public function cutiApprove(Request $request, Cuti $cuti)
    {
        $request->validate([
            'keterangan_status' => 'nullable|string|max:255'
        ]);

        $cuti->update([
            'status' => 'approved',
            'keterangan_status' => $request->keterangan_status
        ]);

        return redirect()->route('admin.cuti.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui');
    }

    public function cutiReject(Request $request, Cuti $cuti)
    {
        $request->validate([
            'keterangan_status' => 'required|string|max:255'
        ]);

        $cuti->update([
            'status' => 'rejected',
            'keterangan_status' => $request->keterangan_status
        ]);

        return redirect()->route('admin.cuti.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak');
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
                    'url' => route('admin.cuti.show', $cuti),
                    'status' => $statusLabel[$cuti->status],
                    'karyawan' => $cuti->karyawan->nama_karyawan,
                    'startDate' => Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y'),
                    'endDate' => Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y')
                ]
            ];
        });
    
        return view('admin.calendar', compact('events'));
    }
}
