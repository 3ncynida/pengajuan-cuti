@extends('layouts.template.app')

@section('title', 'Dashboard Karyawan')
@push('css')
<style>
        :root {
            --primary-light: #e3f2fd;
            --primary-main: #2196f3;
            --primary-dark: #1e88e5;
            --warning-light: #fff8e1;
            --warning-main: #ffa000;
            --success-light: #e8f5e9;
            --success-main: #4caf50;
            --danger-light: #ffebee;
            --danger-main: #ef5350;
            --secondary-main: #012970;
        }

        .section {
            padding: 20px 30px;
            background: #f6f9ff;
            min-height: calc(100vh - 60px);
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        /* First card - Total Cuti (Blue) */
        .stat-card:first-child {
            background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
            border: 1px solid rgba(33, 150, 243, 0.1);
            box-shadow: 0 5px 20px rgba(33, 150, 243, 0.1);
        }

        .stat-card:first-child .stat-icon {
            color: var(--primary-main);
            background: rgba(33, 150, 243, 0.1);
        }

        .stat-card:first-child h3 {
            color: var(--primary-dark);
        }

        /* Second card - Pending Cuti (Yellow) */
        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%);
            border: 1px solid rgba(255, 160, 0, 0.1);
            box-shadow: 0 5px 20px rgba(255, 160, 0, 0.1);
        }

        .stat-card:nth-child(2) .stat-icon {
            color: #ffa000;
            background: rgba(255, 160, 0, 0.1);
        }

        .stat-card:nth-child(2) h3 {
            color: #f57c00;
        }

        /* Third card - Approved Cuti (Green) */
        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
            border: 1px solid rgba(76, 175, 80, 0.1);
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.1);
        }

        .stat-card:nth-child(3) .stat-icon {
            color: #4caf50;
            background: rgba(76, 175, 80, 0.1);
        }

        .stat-card:nth-child(3) h3 {
            color: #388e3c;
        }

        .stat-card {
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.8rem;
            margin-right: 20px;
            padding: 18px;
            border-radius: 12px;
        }

        .stat-card h3 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #607d8b;
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
        }

        .history-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            margin-top: 30px;
        }

        .history-card h4 {
            color: #012970;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-light);
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table thead th {
            background: var(--secondary-main);
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
        }

        .table td {
            padding: 18px 20px;
            border-color: #f1f5f9;
            vertical-align: middle;
            color: #012970;
            font-size: 15px;
            font-weight: 500;
        }

        .badge {
            padding: 8px 16px;
            font-weight: 500;
            font-size: 13px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-sm:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary-main);
            border: none;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 6px 15px rgba(33, 150, 243, 0.3);
        }
</style>
@endpush

@section('content')
<main id="main" class="main">
    <div class="container py-4">


        <div class="row mt-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bi bi-calendar-check stat-icon text-primary'></i>
                        <div>
                            <h3>{{ $totalCuti }}</h3>
                            <p>Total Pengajuan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bi bi-hourglass-split stat-icon text-warning'></i>
                        <div>
                            <h3 class="mb-0">{{ $pendingCuti }}</h3>
                            <p class="text-muted mb-0">Pending</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bi bi-check-circle stat-icon text-success'></i>
                        <div>
                            <h3 class="mb-0">{{ $approvedCuti }}</h3>
                            <p class="text-muted mb-0">Approved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="history-card">
            <h4>Riwayat Pengajuan Cuti</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Waktu Diajukan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCuti as $cuti)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}</td>   
                            <td>{{ \Carbon\Carbon::parse($cuti->created_at)->format('d/m/H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($cuti->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cuti.show', $cuti) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @endsection