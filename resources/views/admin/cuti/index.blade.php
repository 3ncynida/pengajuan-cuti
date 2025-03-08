@extends('layouts.template.app')

@section('title', 'Admin Dashboard')

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
            --secondary-main: #012970;
        }

        .month-filter .form-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e0e8f9;
            color: #012970;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .month-filter .form-select:focus {
            border-color: var(--primary-main);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            outline: none;
        }

        .month-filter .form-select:hover {
            border-color: var(--primary-main);
        }

        .dashboard-stats {
            padding: 25px;
            border-radius: 15px;
            margin: 25px 0;
            background: #f5f6fa;
        }

        .section {
            padding: 20px 30px;
            background: #f6f9ff;
            min-height: calc(100vh - 60px);
        }

        .dashboard-stats h3 {
            color: var(--primary-dark);
            font-size: 2.2rem;
            font-weight: 600;
        }

        .stat-card {
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.2);
        }

        .stat-icon {
            font-size: 2.8rem;
            margin-right: 20px;
            padding: 18px;
            border-radius: 12px;
            color: var(--primary-main);
            background: rgba(33, 150, 243, 0.1);
        }

        .stat-card h3 {
            color: var(--primary-dark);
            font-size: 2.2rem;
            font-weight: 600;
        }

        .stat-card p {
            color: #607d8b;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Date group modifications */
        .date-group {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            margin-bottom: 30px;
        }

        .date-group h5 {
            color: #012970;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-light);
        }

        /* Card modifications */
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        }

        .card-title {
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

        /* Badge styling */
        .badge {
            padding: 8px 16px;
            font-weight: 500;
            font-size: 13px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        /* Button styling */
        .table .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .table .btn-sm:hover {
            transform: translateY(-2px);
        }

        .table .btn i {
            font-size: 14px;
            margin-right: 6px;
        }

        .btn-primary {
            background: var(--primary-main);
            border: none;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
        }

        .card.recent-sales {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 30px;
        }

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
            background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%) !important;
            border: 1px solid rgba(255, 160, 0, 0.1) !important;
            box-shadow: 0 5px 20px rgba(255, 160, 0, 0.1) !important;
        }

        .stat-card:nth-child(2) .stat-icon {
            color: #ffa000 !important;
            background: rgba(255, 160, 0, 0.1) !important;
        }

        .stat-card:nth-child(2) h3 {
            color: #f57c00 !important;
        }

        /* Third card - Approved Cuti (Green) */
        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%) !important;
            border: 1px solid rgba(76, 175, 80, 0.1) !important;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.1) !important;
        }

        .stat-card:nth-child(3) .stat-icon {
            color: #4caf50 !important;
            background: rgba(76, 175, 80, 0.1) !important;
        }

        .stat-card:nth-child(3) h3 {
            color: #388e3c !important;
        }

        /* Hover effects */
        .stat-card:first-child:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.2);
        }

        .stat-card:nth-child(2):hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 160, 0, 0.2) !important;
        }

        .stat-card:nth-child(3):hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.2) !important;
        }
    </style>
@endpush

@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">

                        <!-- Stats Row -->
                        <div class="row mb-4 mt-4">
                            <div class="col-md-4 mt-4">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <i class='bi bi-people stat-icon text-primary'></i>
                                        <div>
                                            <h3 class="mb-0">{{ $totalKaryawan }}</h3>
                                            <p class="text-muted mb-0">Total Karyawan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <i class='bi bi-hourglass-split stat-icon text-warning'></i>
                                        <div>
                                            <h3 class="mb-0">{{ $totalCutiPending }}</h3>
                                            <p class="text-muted mb-0">Pending Cuti</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center">
                                        <i class='bi bi-check-circle stat-icon text-success'></i>
                                        <div>
                                            <h3 class="mb-0">{{ $totalCutiApproved }}</h3>
                                            <p class="text-muted mb-0">Approved Cuti (perbulan)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leave Requests List -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">
                                    Daftar Pengajuan Cuti
                                </h5>
                                <div class="month-filter">
                                    <form action="{{ route('admin.dashboard') }}" method="GET"
                                        class="d-flex align-items-center">
                                        <select name="month" class="form-select" onchange="this.form.submit()"
                                            style="width: 200px;">
                                            @php
                                                $months = [];
                                                for ($i = 0; $i < 12; $i++) {
                                                    $date = \Carbon\Carbon::now()->startOfYear()->addMonths($i);
                                                    $months[$date->format('Y-m')] = $date->format('F Y');
                                                }
                                            @endphp
                                            @foreach ($months as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ $selectedMonth === $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Karyawan</th>
                                            <th scope="col">Tanggal Mulai</th>
                                            <th scope="col">Tanggal Selesai</th>
                                            <th scope="col">Waktu Pengajuan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requests as $cuti)
                                            <tr>
                                                <td>{{ $cuti->karyawan->nama_karyawan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($cuti->created_at)->format('d/m/H:i') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($cuti->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.cuti.show', $cuti) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthInput = document.querySelector('input[type="month"]');

            // Prevent the clear button functionality
            monthInput.addEventListener('search', function(e) {
                e.preventDefault();
            });

            // Additional security to prevent value clearing
            monthInput.addEventListener('mouseup', function(e) {
                const initialValue = this.value;
                setTimeout(() => {
                    if (!this.value) {
                        this.value = initialValue;
                    }
                }, 1);
            });
        });
    </script>
@endpush
