<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/admin/jabatan/index.blade.php -->
@extends('layouts.template.app')

@section('title', 'Manajemen Jabatan')
@push('css')
    <style>
        :root {
            --primary-light: #e3f2fd;
            --primary-main: #2196f3;
            --primary-dark: #1e88e5;
            --secondary-light: #f5f6fa;
            --secondary-main: #012970;
            --success-light: #e8f5e9;
            --success-main: #4caf50;
            --warning-light: #fff8e1;
            --warning-main: #ffa000;
            --danger-light: #ffebee;
            --danger-main: #ef5350;
        }

        .main {
            margin-top: 60px;
            padding: 20px 30px;
            background: var(--secondary-light);
            min-height: calc(100vh - 60px);
        }

        .section {
            margin-bottom: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 25px 30px;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
            border-radius: 15px 15px 0 0;
        }

        .card-title {
            color: var(--secondary-main);
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 30px;
        }

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
            padding: 20px;
            border-color: #f1f5f9;
            vertical-align: middle;
            color: #012970;
            font-size: 15px;
            font-weight: 500;
        }

        /* Adjust button size in table */
        .table .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
        }

        .table .btn i {
            font-size: 14px;
        }

        /* Button Styling */
        .btn {
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 10px;
            letter-spacing: 0.3px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn i {
            margin-right: 6px;
        }

        .btn-primary {
            background: var(--primary-main);
            border: none;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-warning {
            background: var(--warning-main);
            border: none;
            color: #fff;
            box-shadow: 0 4px 12px rgba(255, 160, 0, 0.2);
        }

        .btn-warning:hover {
            background: #ff8f00;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 160, 0, 0.3);
        }

        .btn-danger {
            background: var(--danger-main);
            border: none;
            box-shadow: 0 4px 12px rgba(239, 83, 80, 0.2);
        }

        .btn-danger:hover {
            background: #e53935;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(239, 83, 80, 0.3);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 20px;
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

        .modal-body {
            padding: 25px;
        }

        .form-label {
            color: var(--secondary-main);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 18px;
            border-color: #e0e8f9;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            border-color: var(--primary-main);
            background: #fff;
        }

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: var(--success-light);
            color: #2e7d32;
            border-left: 4px solid var(--success-main);
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
<meta name="csrf-token" content="{{ csrf_token() }}">
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Jabatan</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJabatanModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Jabatan
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
                        <table id='karyawanTable' class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Nama Jabatan</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jabatans as $index => $jabatan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jabatan->nama_jabatan }}</td>
                                        <td>
                                            {{-- @if(config('app.debug'))
                                            <small class="text-muted">
                                                ({{ $jabatan->karyawans()->count() }} karyawan)
                                            </small>
                                        @endif --}}
                                            
                                                <button class="btn btn-sm btn-warning" 
                                                        onclick="editJabatan('{{ $jabatan->jabatan_id }}', '{{ $jabatan->nama_jabatan }}')"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="deleteJabatan({{ $jabatan->jabatan_id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            
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

    <!-- Create Modal -->
    <div class="modal fade" id="createJabatanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jabatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.jabatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror"
                                id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}" required>
                            @error('nama_jabatan')
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

    <!-- Edit Modals -->
    @foreach ($jabatans as $jabatan)
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control" name="nama_jabatan" id="editNamaJabatan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Keep existing modals but add proper styling classes -->
@endsection

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
                ordering: true,
                responsive: true,
                searching: false,
                columnDefs: [{
                        targets: [0], // No column
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: [2], // Actions column
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ], // Sort by nama_jabatan column by default
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                drawCallback: function(settings) {
                    // Add zebra-striping after each draw
                    $('tbody tr:odd').addClass('table-light');
                }
            });
        });

        function editJabatan(jabatan_id, nama_jabatan) {
        const form = document.getElementById('editForm');
        form.action = `/admin/jabatan/${jabatan_id}`;
        document.getElementById('editNamaJabatan').value = nama_jabatan;
    }

    function deleteJabatan(jabatan_id) {
    if (confirm('Apakah Anda yakin ingin menghapus jabatan ini?')) {
        fetch(`/admin/jabatan/${jabatan_id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Tidak dapat menghapus jabatan yang sedang digunakan oleh karyawan');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            alert(error.message);
        });
    }
}

        // Show create modal if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                var createModal = new bootstrap.Modal(document.getElementById('createJabatanModal'));
                createModal.show();
            });
        @endif
    </script>
@endpush
