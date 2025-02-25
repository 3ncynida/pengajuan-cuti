<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <style>
        .dashboard-stats {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .stat-icon {
            font-size: 2rem;
            margin-right: 10px;
        }

        .date-group h5 {
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .date-group {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    @include('layouts.nav')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Admin Dashboard</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-user stat-icon text-primary'></i>
                        <div>
                            <h3 class="mb-0">{{ $totalKaryawan }}</h3>
                            <p class="text-muted mb-0">Total Karyawan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-time stat-icon text-warning'></i>
                        <div>
                            <h3 class="mb-0">{{ $totalCutiPending }}</h3>
                            <p class="text-muted mb-0">Pending Cuti</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-check-circle stat-icon text-success'></i>
                        <div>
                            <h3 class="mb-0">{{ $totalCutiApproved }}</h3>
                            <p class="text-muted mb-0">Approved Cuti</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4>Daftar Pengajuan Cuti</h4>
        @php
            $groupedRequests = $latestCutiRequests->groupBy(function($cuti) {
                return \Carbon\Carbon::parse($cuti->created_at)->format('Y-m-d');
            });
        @endphp
        
        @foreach($groupedRequests as $date => $requests)
            <div class="date-group mb-4">
                <h5 class="border-bottom pb-2">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                </h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Waktu Pengajuan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $cuti)
                            <tr>
                                <td>{{ $cuti->karyawan->nama_karyawan }}</td>
                                <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cuti->created_at)->format('H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($cuti->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.cuti.show', $cuti) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
