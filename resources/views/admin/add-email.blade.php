@extends('layouts.template.app')

@section('title', 'Daftar Karyawan')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
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
            --secondary-light: #f6f9ff;
        }

        .main {
            margin-top: 60px;
            padding: 20px 30px;
            background: var(--secondary-light);
            min-height: calc(100vh - 60px);
        }

        .section {
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            margin-bottom: 30px;
            border: none;
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
        }

        .card-title {
            color: var(--secondary-main);
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .card-body {
            padding: 30px;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table thead th:first-child {
            border-top-left-radius: 10px;
        }

        .table thead th:last-child {
            border-top-right-radius: 10px;
        }

        .table thead th {
            background: var(--secondary-main);
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
            font-size: 15px;
            letter-spacing: 0.3px;
            /* Add these properties for better spacing */
            border-spacing: 0;
            border-collapse: separate;
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

        /* Badge Styling */
        .badge {
            padding: 8px 16px;
            font-weight: 500;
            font-size: 13px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .badge-verified {
            background: var(--success-main) !important;
        }

        .badge-unverified {
            background: var(--danger-main) !important;
        }

        /* Button Styling */
        .btn {
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 10px;
            letter-spacing: 0.3px;
        }

        .btn:hover {
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

        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 20px 25px;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
        }

        .modal-title {
            color: var(--secondary-main);
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .form-label {
            color: var(--secondary-main);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 18px;
            border-color: #e0e8f9;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            border-color: var(--primary-main);
            background: #fff;
        }

        /* DataTable Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            padding: 8px 12px;
            border-color: #e0e8f9;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary-main);
            box-shadow: none;
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-main);
            border-color: var(--primary-main);
            color: #fff !important;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
        }

        .alert-success {
            background: var(--success-light);
            color: #2e7d32;
            border-left: 4px solid var(--success-main);
        }

        /* DataTables Custom Styling */
        div.dataTables_wrapper div.dataTables_filter input {
            border-radius: 8px;
            padding: 8px 12px;
            border: 1px solid #e0e8f9;
            margin-left: 8px;
        }

        div.dataTables_wrapper div.dataTables_length select {
            border-radius: 8px;
            padding: 8px 12px;
            border: 1px solid #e0e8f9;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: var(--primary-light);
        }

        .table-striped>tbody>tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        /* Fix table overflow */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Fix badge alignment */
        td .badge {
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }

        /* Enhance button spacing */
        td .btn-sm {
            margin: 0 2px;
        }

        .btn-close {
            transition: transform 0.3s ease;
        }

        .btn-close:hover {
            transform: rotate(90deg);
        }
    </style>
@endpush

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Daftar Karyawan</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmailModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
                    </button>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="karyawanTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 20%">Nama</th>
                                    <th style="width: 25%">Email</th>
                                    <th style="width: 15%">Jabatan</th>
                                    <th style="width: 12%">Status</th>
                                    <th style="width: 10%">Role</th>
                                    <th style="width: 13%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawans as $index => $karyawan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $karyawan->nama_karyawan ?? 'Belum diisi' }}</td>
                                        <td>{{ $karyawan->email }}</td>
                                        <td>{{ $karyawan->jabatan->nama_jabatan ?? 'Belum diset' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $karyawan->is_verified ? 'badge-verified' : 'badge-unverified' }}">
                                                {{ $karyawan->is_verified ? 'Verified' : 'Unverified' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $karyawan->role === 'admin' ? 'danger' : 'info' }}">
                                                {{ ucfirst($karyawan->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (auth()->id() !== $karyawan->id)
                                                <a href="{{ route('admin.karyawan.show', $karyawan->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Current User</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection


<div class="modal fade" id="addEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.store-email') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror"
                            id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan') }}" required>
                        @error('nama_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan_id" class="form-label">Jabatan</label>
                        <select class="form-select @error('jabatan_id') is-invalid @enderror" id="jabatan_id"
                            name="jabatan_id" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}"
                                    {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                    {{ $jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#karyawanTable').DataTable({
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data yang tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                ordering: false,
                responsive: true,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 6]
                }]
            });
        });

        // Show modal if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                var addEmailModal = new bootstrap.Modal(document.getElementById('addEmailModal'));
                addEmailModal.show();
            });
        @endif
    </script>
@endpush
