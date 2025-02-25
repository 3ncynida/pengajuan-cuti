<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaryawanDashboardController extends Controller
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
                         ->take(5)
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
}