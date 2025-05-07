<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $karyawan = auth()->user();
    $cutiQuota = $karyawan->cutiQuota()->where('tahun', now()->year)->first();

    if (!$cutiQuota) {
        return view('karyawan.dashboard', [
            'totalCuti' => 0,
            'jatahMasuk' => 0,
            'sisaJatahMasuk' => 0,
            'approvedCuti' => 0,
            'recentCuti' => collect([])
        ])->with('error', 'Kuota cuti belum diatur untuk tahun ini.');
    }

    return view('karyawan.dashboard', [
        'totalCuti' => $karyawan->cutis()->count(),
        'jatahMasuk' => $cutiQuota->jatah_masuk,
        'sisaJatahMasuk' => $cutiQuota->sisa_jatah_masuk,
        'approvedCuti' => $karyawan->cutis()->where('status', 'approved')->count(),
        'recentCuti' => $karyawan->cutis()->orderBy('created_at', 'desc')->take(5)->get(),
        'cutiQuota' => $cutiQuota
    ]);
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
                'backgroundColor' => $statusColor[$cuti->status],
                'borderColor' => $statusColor[$cuti->status],
                'extendedProps' => [
                    'karyawan' => $cuti->karyawan->nama_karyawan,
                    'jenis_cuti' => $cuti->jenis_cuti,
                    'jenis_cuti_label' => $jenisCutiLabel[$cuti->jenis_cuti],
                    'startDate' => Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y'),
                    'endDate' => Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y'),
                    'status' => $statusLabel[$cuti->status]
                ]
            ];
        });
    
        return view('karyawan.calendar', compact('events'));
    }

    public function create()
    {
        $karyawan = auth()->user();
        $cutiQuota = $karyawan->cutiQuota;
// dd($cutiQuota);
        return view('karyawan.cuti.create', compact('cutiQuota'));
    }

    public function store(Request $request)
    {
            // Add custom validation rule for weekday
            $request->validate([
                'tanggal_mulai' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                    function ($attribute, $value, $fail) {
                        $startDate = Carbon::parse($value);
                        if ($startDate->isWeekend()) {
                            $fail('Tanggal mulai harus hari kerja (Senin-Jumat).');
                        }
                    },
                ],
                'tanggal_selesai' => [
                    'required',
                    'date',
                    'after_or_equal:tanggal_mulai',
                    function ($attribute, $value, $fail) {
                        $endDate = Carbon::parse($value);
                        if ($endDate->isWeekend()) {
                            $fail('Tanggal selesai harus hari kerja (Senin-Jumat).');
                        }
                    },
                ],
                'jenis_cuti' => 'required|in:tahunan,khusus,haid,melahirkan,ayah',
                'alasan' => 'required|string',
                'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ], [
                'tanggal_mulai.after_or_equal' => 'Tanggal mulai harus hari ini atau setelahnya.',
                'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.'
            ]);
        
            // Check for weekend days between start and end dates
            $startDate = Carbon::parse($request->tanggal_mulai);
            $endDate = Carbon::parse($request->tanggal_selesai);
            $period = CarbonPeriod::create($startDate, $endDate);
        
            foreach ($period as $date) {
                if ($date->isWeekend()) {
                    return back()
                        ->withInput()
                        ->with('error', 'Rentang tanggal cuti tidak boleh termasuk hari Sabtu dan Minggu.');
                }
            }

        $karyawan = auth()->user();
        $cutiQuota = $karyawan->cutiQuota;

        // Check for pending leave requests
        $hasPendingLeave = Cuti::where('karyawan_id', $karyawan->karyawan_id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingLeave) {
            return back()
                ->withInput()
                ->with('error', 'Anda masih memiliki pengajuan cuti yang pending. Silakan tunggu sampai diproses.');
        }

        // Check for menstrual leave monthly limit
        if ($request->jenis_cuti === 'haid') {
            $hasHaidLeaveThisMonth = Cuti::where('karyawan_id', $karyawan->karyawan_id)
                ->where('jenis_cuti', 'haid')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->exists();

            if ($hasHaidLeaveThisMonth) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda sudah mengajukan cuti haid untuk bulan ini. Silakan ajukan kembali bulan depan.');
            }

            // Ensure only female employees can request menstrual leave
            if ($karyawan->jenis_kelamin !== 'P') {
                return back()
                    ->withInput()
                    ->with('error', 'Hanya karyawan perempuan yang dapat mengajukan cuti haid.');
            }
        }

           // Recalculate number of days excluding weekends
    $jumlah_hari = $startDate->diffInDaysFiltered(function (Carbon $date) {
        return !$date->isWeekend();
    }, $endDate) + 1;

        $quotaField = 'cuti_' . $request->jenis_cuti;

        // Check if employee has enough quota
        if (!$cutiQuota || $cutiQuota->$quotaField < $jumlah_hari) {
            return back()
                ->withInput()
                ->with('error', "Kuota cuti {$request->jenis_cuti} Anda tidak mencukupi. Sisa kuota: {$cutiQuota->$quotaField} hari.");
        }

        // Additional validation for specific leave types
        switch ($request->jenis_cuti) {
            case 'haid':
                if ($jumlah_hari > 1) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cuti haid hanya dapat diambil untuk 1 hari.');
                }
                break;
            case 'melahirkan':
                if ($jumlah_hari > 90) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cuti melahirkan maksimal 90 hari.');
                }
                break;
            case 'ayah':
                if ($jumlah_hari > 30) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cuti ayah maksimal 30 hari.');
                }
                break;
            case 'tahunan':
                if ($jumlah_hari > 12) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cuti tahunan maksimal 12 hari.');
                }
                break;
            case 'khusus':
                if ($jumlah_hari > 3) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cuti khusus maksimal 3 hari.');
                }
                break;
        }

        // Additional validation for menstrual leave duration
        if ($request->jenis_cuti === 'haid' && $jumlah_hari > 1) {
            return back()
                ->withInput()
                ->with('error', 'Cuti haid hanya dapat diambil untuk 1 hari.');
        }

        // Create cuti request using DB transaction
        DB::transaction(function () use ($request, $karyawan, $jumlah_hari, $cutiQuota) {
            // Store the created cuti in a variable
            $cuti = Cuti::create([
                'karyawan_id' => $karyawan->karyawan_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_hari' => $jumlah_hari,
                'jenis_cuti' => $request->jenis_cuti,
                'alasan' => $request->alasan,
                'status' => 'pending'
            ]);

            // Handle document upload if exists
            if ($request->hasFile('dokumen_pendukung')) {
                $file = $request->file('dokumen_pendukung');
                $filename = time() . '_' . $file->getClientOriginalName();
                // Store directly in the public disk
                $file->move(public_path('storage/dokumen_pendukung'), $filename);

                // Update and save the cuti model with the document
                $cuti->update(['dokumen_pendukung' => $filename]);
            }

            // Deduct quota only if cuti is approved
            if ($cuti->status === 'approved') {
                $quotaField = 'cuti_' . $request->jenis_cuti;
                $cutiQuota->$quotaField -= $jumlah_hari;
                $cutiQuota->save();
            }
        });

        return redirect()
            ->route('karyawan.dashboard')
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
