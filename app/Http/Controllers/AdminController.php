<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get selected month or default to current month
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $selectedMonth);

        $totalKaryawan = Karyawan::count();
        $totalCutiPending = Cuti::where('status', 'pending')->count();

        // Get approved leaves for selected month
        $totalCutiApproved = Cuti::where('status', 'approved')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        // Get leave requests for selected month
        $requests = Cuti::with('karyawan')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.cuti.index', compact(
            'totalKaryawan',
            'totalCutiPending',
            'totalCutiApproved',
            'requests',
            'selectedMonth'
        ));
    }

    public function showAddEmailForm()
    {
        $karyawans = Karyawan::orderBy('nama_karyawan', 'asc')->get();
        $jabatans = Jabatan::orderBy('nama_jabatan', 'asc')->get();
        return view('admin.karyawan.index', compact('karyawans', 'jabatans'));
    }
    public function storeEmail(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawans,email',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan_id' => 'required|exists:jabatans,id',
            'role' => 'required|in:karyawan,admin'
        ]);
    
        $karyawan = Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jabatan_id' => $request->jabatan_id,
            'role' => $request->role
        ]);
    
        // Initialize cuti quota
        $karyawan->cutiQuota()->create([
            'tahun' => now()->year,
            'cuti_tahunan' => 12,
            'cuti_khusus' => 3,
            'cuti_haid' => $karyawan->jenis_kelamin === 'P' ? 1 : 0,
            'cuti_melahirkan' => $karyawan->jenis_kelamin === 'P' ? 90 : 0,
            'cuti_ayah' => $karyawan->jenis_kelamin === 'L' ? 30 : 0,
        ]);
    
        return redirect()->back()->with('success', 'Karyawan baru berhasil ditambahkan');
    }
    public function updateKaryawan(Request $request, Karyawan $karyawan)
    {
        if ($karyawan->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah akun sendiri.');
        }
    
        $request->validate([
            'role' => ['required', 'in:admin,karyawan'],
            'jabatan_id' => ['required', 'exists:jabatans,id'],
            'jenis_kelamin' => ['required', 'in:L,P']
        ]);
    
        DB::transaction(function() use ($request, $karyawan) {
            // Update karyawan data
            $oldGender = $karyawan->jenis_kelamin;
            
            $karyawan->update([
                'role' => $request->role,
                'jabatan_id' => $request->jabatan_id,
                'jenis_kelamin' => $request->jenis_kelamin
            ]);
    
            // Update cuti quota if gender changed
            if ($oldGender !== $request->jenis_kelamin) {
                $cutiQuota = $karyawan->cutiQuota;
                if ($cutiQuota) {
                    $cutiQuota->update([
                        'cuti_haid' => $request->jenis_kelamin === 'P' ? 1 : 0,
                        'cuti_melahirkan' => $request->jenis_kelamin === 'P' ? 90 : 0,
                        'cuti_ayah' => $request->jenis_kelamin === 'L' ? 30 : 0
                    ]);
                }
            }
        });
    
        return redirect()->back()->with('success', 'Karyawan berhasil diupdate');
    }

    public function deleteKaryawan(Karyawan $karyawan)
    {
        if ($karyawan->id === auth()->id()) {
            return response()->json(['error' => 'Tidak dapat menghapus akun sendiri.'], 403);
        }

        $karyawan->delete();
        return response()->json(['message' => 'Karyawan berhasil dihapus']);
    }

    public function jabatanIndex()
    {
        $jabatans = Jabatan::orderBy('nama_jabatan', 'asc')->get();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function jabatanStore(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans'
        ], [
            'nama_jabatan.unique' => 'Jabatan sudah terdaftar'
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function jabatanUpdate(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $jabatan->id
        ], [
            'nama_jabatan.unique' => 'Jabatan sudah terdaftar'
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

    DB::transaction(function() use ($request, $cuti) {
        // Update cuti status
        $cuti->update([
            'status' => 'approved',
            'keterangan_status' => $request->keterangan_status
        ]);

        // Deduct quota when approved
        $karyawan = $cuti->karyawan;
        $cutiQuota = $karyawan->cutiQuota;
        $quotaField = 'cuti_' . $cuti->jenis_cuti;
        
        if ($cutiQuota) {
            $cutiQuota->$quotaField -= $cuti->jumlah_hari;
            $cutiQuota->save();
        }
    });

    return redirect()
        ->route('admin.dashboard')
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

        return redirect()->route('admin.dashboard')
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
                'pending' => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak'
            ];
    
            $jenisCutiLabel = [
                'tahunan' => 'Cuti Tahunan',
                'khusus' => 'Cuti Khusus',
                'haid' => 'Cuti Haid',
                'melahirkan' => 'Cuti Melahirkan',
                'ayah' => 'Cuti Ayah'
            ];
    
            return [
                'title' => sprintf(
                    '%s - %s (%s)',
                    $cuti->karyawan->nama_karyawan,
                    $jenisCutiLabel[$cuti->jenis_cuti],
                    $statusLabel[$cuti->status]
                ),
                'start' => $cuti->tanggal_mulai,
                'end' => Carbon::parse($cuti->tanggal_selesai)->addDay()->format('Y-m-d'),
                'allDay' => true, // Add this to remove time
                'backgroundColor' => $statusColor[$cuti->status],
                'borderColor' => $statusColor[$cuti->status],
                'extendedProps' => [
                    'karyawan' => $cuti->karyawan->nama_karyawan,
                    'jenis_cuti' => $cuti->jenis_cuti,
                    'jenis_cuti_label' => $jenisCutiLabel[$cuti->jenis_cuti],
                    'startDate' => Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y'),
                    'endDate' => Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y'),
                    'status' => $statusLabel[$cuti->status],
                    'detailUrl' => route('admin.cuti.show', $cuti->id) // Change url to detailUrl
                ]
            ];
        });
    
        return view('admin.calendar', compact('events'));
    }
}
