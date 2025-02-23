<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

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
}